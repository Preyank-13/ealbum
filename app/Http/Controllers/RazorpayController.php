<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Exception;
use App\Models\credit;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RazorpayController extends Controller
{
    public function index()
    {
        return view('admin.pages.razorpay');
    }

    public function payment(Request $request)
{
    $api = new Api('rzp_test_SPSlUSEJS6hnwx', 'ZfbuH0IAu4MJWy7C4Rtj1m2o');
    $user = Auth::user();
    $amount = $request->amount;

    // 🟢 SECURITY CHECK: Rokne ke liye ki bada plan wala sasta plan na lele
    if ($user->active_plan == 'Studio Plan' || $user->active_plan == 'Studio') {
        return back()->with('error', 'You already have the Studio Plan (Unlimited). No need to buy smaller plans.');
    }

    if (($user->active_plan == 'Pro Plan' || $user->active_plan == 'Pro') && $amount == 999) {
        return back()->with('error', 'You already have a Pro Plan. You can only upgrade to Studio.');
    }

    $amountInPaise = $amount * 100;

    try {
        $order = $api->order->create([
            'receipt' => 'rcpt_' . rand(1000, 9999),
            'amount' => $amountInPaise,
            'currency' => 'INR',
        ]);

        return view('admin.pages.payment', [
            'orderId' => $order['id'],
            'amount' => $amountInPaise,
            'plan_name' => $request->plan_name ?? 'Credit Purchase'
        ]);

    } catch (Exception $e) {
        return "Order Error: " . $e->getMessage();
    }
}

    public function callback(Request $request)
    {
        $api = new Api('rzp_test_SPSlUSEJS6hnwx', 'ZfbuH0IAu4MJWy7C4Rtj1m2o');

        try {
            $attr = [
                'razorpay_order_id' => $request->orderid,
                'razorpay_payment_id' => $request->payid,
                'razorpay_signature' => $request->sign
            ];

            $api->utility->verifyPaymentSignature($attr);

            $user = Auth::user();
            $amountInRupees = $request->amount / 100;

            $creditsToAdd = 0;
            $isUnlimited = false;
            $currentPlan = null;
            $isMajorPlan = false;

            // 🟢 LOGIC: Plan Management & Hierarchy
            if ($amountInRupees == 4999) {
                $creditsToAdd = 0; 
                $isUnlimited = true;
                $currentPlan = 'Studio';
                $isMajorPlan = true;
            } elseif ($amountInRupees == 2499) {
                // User hamesha Pro le sakta hai unless woh pehle se Studio na ho
                if ($user->active_plan != 'Studio') {
                    $creditsToAdd = 3000;
                    $isUnlimited = false;
                    $currentPlan = 'Pro';
                    $isMajorPlan = true;
                }
            } elseif ($amountInRupees == 999) {
                // Basic tabhi jab user pehle se Pro/Studio na ho
                if (!in_array($user->active_plan, ['Pro', 'Studio'])) {
                    $creditsToAdd = 1000;
                    $isUnlimited = false;
                    $currentPlan = 'Basic';
                    $isMajorPlan = true;
                }
            } else {
                // Normal top-up logic
                $creditsToAdd = $amountInRupees;
                $isUnlimited = $user->is_unlimited; 
                $currentPlan = $user->active_plan;
            }

            // 🟢 Update Expiry & Plan Status
            if ($isMajorPlan) {
                $user->active_plan = $currentPlan;
                $user->is_unlimited = $isUnlimited;

                // Agar plan active hai toh purani date mein +1 Year karein, warna aaj se
                $baseDate = ($user->plan_expires_at && Carbon::parse($user->plan_expires_at)->isFuture()) 
                            ? Carbon::parse($user->plan_expires_at) 
                            : now();
                
                $user->plan_expires_at = $baseDate->addYear();
            }
            
            // Increment Credits
            if ($creditsToAdd > 0) {
                $user->credits += $creditsToAdd;
            }
            
            $user->save();

            // Database History Entry
            credit::create([
                'user_id' => $user->id,
                'order_id' => $request->orderid,
                'purchase_date' => now(),
                'album_name' => $currentPlan ? $currentPlan . ' Plan Purchase' : 'Credit Top-up',
                'credits' => ($amountInRupees == 4999) ? 0 : $creditsToAdd,
                'amount' => $amountInRupees,
                'payment_type' => 'Razorpay Online', 'Debit',
                'status' => 'Success',
                'message' => ($amountInRupees == 4999) 
                             ? 'Studio Plan Activated (Unlimited Albums)' 
                             : $creditsToAdd . ' credits added to account',
            ]);

            return redirect()->route('admin.credit')->with('success', 'Payment Successful! Your plan has been updated.');

        } catch (Exception $e) {
            return "Verification Failed: " . $e->getMessage();
        }
    }

    public function credit()
    {
        $creditHistory = \App\Models\credit::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('admin.pages.credit', compact('creditHistory'));
    }
}
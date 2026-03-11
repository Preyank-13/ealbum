<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Exception;
use App\Models\credit;
use Illuminate\Support\Facades\Auth;

class RazorpayController extends Controller
{
    public function index()
    {
        return view('admin.pages.razorpay');
    }

    public function payment(Request $request)
    {
        $api = new Api('rzp_test_SPSlUSEJS6hnwx', 'ZfbuH0IAu4MJWy7C4Rtj1m2o');
        $amountInPaise = $request->amount * 100;

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

            // 🟢 LOGIC: Plan Hierarchy (Studio > Pro > Basic)
            if ($amountInRupees == 4999) {
                $creditsToAdd = 0; 
                $isUnlimited = true;
                $currentPlan = 'Studio';
            } elseif ($amountInRupees == 2499) {
                // Agar user pehle se Studio nahi hai, tabhi upgrade karein
                if ($user->active_plan != 'Studio') {
                    $creditsToAdd = 3000;
                    $isUnlimited = false;
                    $currentPlan = 'Pro';
                }
            } elseif ($amountInRupees == 999) {
                // Agar user pehle se Pro ya Studio nahi hai, tabhi upgrade karein
                if (!in_array($user->active_plan, ['Pro', 'Studio'])) {
                    $creditsToAdd = 1000;
                    $isUnlimited = false;
                    $currentPlan = 'Basic';
                }
            } else {
                // Normal top-up (amount >= 200 etc), isse plan change nahi hoga
                $creditsToAdd = $amountInRupees;
                $isUnlimited = $user->is_unlimited; // Purana status maintain rakhein
                $currentPlan = $user->active_plan;   // Purana plan maintain rakhein
            }

            // User Model update
            // Plan tabhi extend hoga jab teeno main plans mein se koi liya ho
            if (in_array($amountInRupees, [999, 2499, 4999])) {
                $user->active_plan = $currentPlan;
                $user->is_unlimited = $isUnlimited;
                $user->plan_expires_at = now()->addYear(); 
            }
            
            if ($creditsToAdd > 0) {
                $user->increment('credits', $creditsToAdd);
            }
            $user->save();

            // Database History Entry
            credit::create([
                'user_id' => $user->id,
                'order_id' => $request->orderid,
                'purchase_date' => now(),
                'album_name' => $currentPlan ? $currentPlan . ' Plan' : 'Credit Top-up',
                'credits' => ($amountInRupees == 4999) ? 0 : $creditsToAdd,
                'amount' => $amountInRupees,
                'payment_type' => 'Razorpay Online',
                'status' => 'Success',
                'message' => ($amountInRupees == 4999) 
                             ? 'Studio Plan Activated (Unlimited Albums for 1 Year)' 
                             : $creditsToAdd . ' credits added successfully',
            ]);

            return redirect()->route('admin.credit')->with('success', 'Payment Successful!');

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
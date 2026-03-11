<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Exception;
use App\Models\credit;
use Illuminate\Support\Facades\Auth;

class RazorpayController extends Controller
{
    // Payment Page dikhane ke liye
    public function index()
    {
        return view('admin.pages.razorpay');
    }

    // Razorpay Order generate karne ke liye
    public function payment(Request $request)
    {
        // 🟢 Tip: Production mein API keys ko .env file se load karein
        $api = new Api('rzp_test_SPSlUSEJS6hnwx', 'ZfbuH0IAu4MJWy7C4Rtj1m2o');

        // Amount ko paise mein convert karna (1 INR = 100 Paise)
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

    // Payment success hone ke baad verification aur DB entry
    public function callback(Request $request)
    {
        $api = new Api('rzp_test_SPSlUSEJS6hnwx', 'ZfbuH0IAu4MJWy7C4Rtj1m2o');

        try {
            $attr = [
                'razorpay_order_id' => $request->orderid,
                'razorpay_payment_id' => $request->payid,
                'razorpay_signature' => $request->sign
            ];

            // Signature verify karna zaroori hai
            $api->utility->verifyPaymentSignature($attr);

            $user = Auth::user();
            $amountInRupees = $request->amount / 100;

            // Database mein entry tabhi hogi jab signature sahi ho
            credit::create([
                'user_id' => $user->id,
                'order_id' => $request->orderid,
                'purchase_date' => now(),
                'album_name' => $request->plan_name ?? 'Credit Purchase',
                'credits' => $amountInRupees,
                'amount' => $amountInRupees,
                'payment_type' => 'Razorpay Online',
                'status' => 'Success',
                // 🟢 FIXED: Dynamic message yahan add kiya hai taaki History mein dikhe
                'message' => $amountInRupees . ' credits added successfully',
            ]);

            // User ka balance increment karein
            $user->increment('credits', $amountInRupees);

            return redirect()->route('admin.credit')->with('success', 'Payment Successful!');

        } catch (Exception $e) {
            return "Verification Failed: " . $e->getMessage();
        }
    }

    // Fetch Credit History
    public function credit()
    {
        // Sirf logged-in user ki history fetch karein aur latest upar dikhayein
        $creditHistory = \App\Models\credit::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('admin.pages.credit', compact('creditHistory'));
    }
}
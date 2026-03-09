<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Exception;
use App\Models\CreditHistory; // CreditHistory Model use karne ke liye
use Illuminate\Support\Facades\Auth;

class RazorpayController extends Controller
{
    public function index()
    {
        return view('admin.pages.razorpay');
    }

    public function payment(Request $request)
    {
        // 1. Request se data nikalna
        $amount = $request->input('amount');
        $plan_name = $request->input('plan_name');
        $user = Auth::user();

        try {
            // 2. Credits table mein entry save karna
            Credit::create([
                'user_id'       => $user->id,
                'order_id'      => 'TEST_ORD_' . rand(1000, 9999),
                'purchase_date' => now(),
                'album_name'    => $plan_name,
                'credits'       => $amount, // 1 Rs = 1 Credit logic
                'amount'        => $amount,
                'payment_type'  => 'Dummy/Test',
                'message'       => 'Credit added successfully via Test Mode',
                'status'        => 'Success',
            ]);

            // 3. User table mein total credits update karna
            // Pakka karein ki User model ke $fillable mein 'credits' hai
            $user->update([
                'credits' => $user->credits + $amount
            ]);

            return redirect()->route('admin.credit')->with('success', 'Payment successful! Credits added to your account.');

        } catch (Exception $e) {
            return "Error while processing payment: " . $e->getMessage();
        }
    }


    public function callback(Request $request)
    {
        // Ye tab kaam aayega jab asli Razorpay chalega
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        try {
            $attr = [
                'razorpay_order_id' => $request->orderid,
                'razorpay_payment_id' => $request->payid,
                'razorpay_signature' => $request->sign
            ];
            $api->utility->verifyPaymentSignature($attr);
            echo "Payment Verified Successfully!";
        } catch (Exception $e) {
            echo "Payment Verification Failed!: " . $e->getMessage();
        }
    }
}
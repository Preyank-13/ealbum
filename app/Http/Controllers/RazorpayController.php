<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Exception; // Exception class use karne ke liye

class RazorpayController extends Controller
{
    public function index()
    {
        // Path corrected: resources/views/admin/pages/razorpay.blade.php
        return view('admin.pages.razorpay');
    }

    public function payment(Request $request)
    {

        $amount = $request->input('amount');


        // env() helper ko sahi se likhein
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $orderData = [
            // Comma ki jagah Dot (.) use karein
            'receipt' => 'order_' . rand(1000, 9999),
            'amount' => $amount * 100,
            'currency' => 'INR',
            'payment_capture' => 1
        ];

        try {
            $order = $api->order->create($orderData);
            // Blade file ka path sahi karein agar wo admin/pages folder mein hai
            return view('admin.pages.razorpay', ['orderId' => $order["id"], 'amount' => $amount * 100]);
        } catch (\Exception $e) {
            return "Razorpay Error: " . $e->getMessage();
        }
    }

    public function callback(Request $request)
    {

        $payid = $request->payid;
        $orderid = $request->orderid;
        $sign = $request->sign;

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        try {
            $attr = [
                'razorpay_order_id' => $orderid,
                'razorpay_payment_id' => $payid,
                'razorpay_signature' => $sign
            ];

            // Signature verify karne ka logic
            $api->utility->verifyPaymentSignature($attr);
            echo "Payment Verified Successfully!";

        } catch (Exception $e) { // Spelling 'Exception' sahi ki gayi aur semicolon lagaya
            echo "Payment Verification Failed!: " . $e->getMessage();
        }
    }
}
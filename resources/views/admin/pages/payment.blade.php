<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Processing Payment...</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="text-center">
        <div class="animate-spin rounded-full h-12 w-12 border-4 border-indigo-500 border-t-transparent mx-auto mb-4"></div>
        <h1 class="text-xl font-bold">Opening Razorpay Checkout...</h1>
    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "rzp_test_SPSlUSEJS6hnwx", 
            "amount": "{{ $amount }}", 
            "currency": "INR",
            "name": "eAlbum Services", 
            "description": "Credits for {{ $plan_name }}",
            "order_id": "{{ $orderId }}", 
            "handler": function (response) {
                // Success hone par data callback route par bhejein
                window.location.href = "{{ route('razorpay.callback') }}?payid=" + response.razorpay_payment_id + 
                                       "&orderid=" + response.razorpay_order_id + 
                                       "&sign=" + response.razorpay_signature +
                                       "&amount={{ $amount }}&plan_name={{ $plan_name }}";
            },
            "prefill": {
                "name": "{{ Auth::user()->name }}",
                "email": "{{ Auth::user()->email }}"
            },
            "theme": { "color": "#4f46e5" }
        };
        var rzp1 = new Razorpay(options);
        window.onload = function() { rzp1.open(); };
    </script>
</body>
</html>
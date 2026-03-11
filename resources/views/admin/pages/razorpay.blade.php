<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buy Credits</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-3xl shadow-lg w-full max-w-md">
        <h1 class="text-2xl font-black text-center mb-6">Enter Amount</h1>
        <form action="{{ route('razorpay.payment') }}" method="post" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs font-bold text-gray-400 uppercase">Amount (INR)</label>
                <input type="number" name="amount" placeholder="2499 Best Plan" required
                    class="w-full border rounded-xl p-3 outline-none focus:ring-2 focus:ring-indigo-400">
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-xl font-bold">
                Proceed to Pay
            </button>
        </form>
    </div>
</body>
</html>
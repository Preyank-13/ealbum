<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eAlbum Access</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black">

    <div id="access-modal" class="fixed inset-0 bg-black flex items-center justify-center p-4 z-50">
        
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden p-8 text-center border-t-4 border-indigo-500 relative">
            
            <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="flex justify-center mb-6">
                <div class="p-4 bg-indigo-50 rounded-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
            </div>

            <h2 class="text-3xl font-bold text-gray-800 mb-2">eAlbum Access</h2>
            <p class="text-gray-500 mb-8 px-4">Please enter your access code to view this album</p>

            <form action="#" method="POST" class="space-y-4">
                @csrf
                <input 
                    type="text" 
                    name="access_code" 
                    placeholder="Enter access code" 
                    class="w-full px-6 py-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-center text-lg focus:outline-none focus:border-indigo-400 focus:bg-white transition-all placeholder:text-gray-400"
                >

                <button 
                    type="submit" 
                    class="w-full py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-2xl text-lg hover:opacity-90 transition-opacity shadow-lg shadow-indigo-200"
                >
                    Unlock Album
                </button>
            </form>
        </div>
    </div>

    <script>
        function closeModal() {
            // Modal ko hide karne ke liye
            document.getElementById('access-modal').style.display = 'none';
            // Redirect to welcome page ya jahan se user aaya tha
            window.location.href = "{{ route('user.pages.welcome') }}";
        }
    </script>

</body>
</html>
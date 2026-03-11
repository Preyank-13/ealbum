<x-guest-layout>
    {{-- Background Wrapper: Photography Related Image --}}
    <div class="fixed inset-0 z-[-1] bg-cover bg-center bg-no-repeat shadow-inner" 
         style="background-image: url('https://images.unsplash.com/photo-1542038784456-1ea8e935640e?q=80&w=2070&auto=format&fit=crop');">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px]"></div>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- Card Title --}}
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-black text-gray-800 tracking-tight uppercase">Welcome Back</h2>
        <p class="text-sm text-gray-500 font-medium">Login to manage your eAlbums</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="group">
            <x-input-label for="email" :value="__('Email')" class="text-xs font-bold uppercase text-gray-600" />
            <x-text-input id="email" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:bg-white transition-all rounded-xl" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-5 group">
            <x-input-label for="password" :value="__('Password')" class="text-xs font-bold uppercase text-gray-600" />
            <x-text-input id="password" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:bg-white transition-all rounded-xl"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded-md border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                <span class="ms-2 text-sm text-gray-500 font-medium">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-blue-600 font-bold hover:text-blue-800 transition-colors" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        {{-- Action Buttons --}}
        <div class="mt-8 space-y-3">
            <x-primary-button class="w-full justify-center py-3 bg-gray-900 hover:bg-black text-white rounded-xl shadow-lg transition-all text-sm font-bold tracking-widest uppercase">
                {{ __('Log in') }}
            </x-primary-button>

            <div class="relative py-4">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-100"></div></div>
                <div class="relative flex justify-center text-xs uppercase"><span class="bg-white px-2 text-gray-400 font-bold">Or continue with</span></div>
            </div>

            <a href="{{ route('auth.google') }}" 
               class="flex items-center justify-center gap-3 w-full px-6 py-3 text-gray-700 bg-white border border-gray-200 rounded-xl shadow-sm hover:bg-gray-50 transition-all font-bold text-sm">
                <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" class="w-5 h-5" alt="Google">
                Login with Google
            </a>
        </div>

        <div class="flex justify-center mt-8">
            <p class="text-sm text-gray-500 font-medium">Don't have an account? 
                <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:underline ms-1">Create an Account</a>
            </p>
        </div>
    </form>
</x-guest-layout>
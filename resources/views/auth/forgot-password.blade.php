<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6 gap-4">
            <a href="{{ route('login') }}"
                class="flex-1 text-center bg-[#111111] hover:bg-black text-white px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest shadow-lg shadow-gray-200 transition-all active:scale-95 border border-white/5">
                {{ __('Login') }}
            </a>

            <button type="submit"
                class="flex-1 bg-[#111111] hover:bg-black text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-gray-200 transition-all active:scale-95 border border-white/5">
                {{ __('Email Reset Link') }}
            </button>
        </div>
    </form>
</x-guest-layout>
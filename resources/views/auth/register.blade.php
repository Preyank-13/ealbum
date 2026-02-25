<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <div class="flex gap-4">
            <div class="flex-1">
                <x-input-label for="name" :value="__('Your Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                    autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="flex-1">
                <x-input-label for="business_name" :value="__('Your Business Name')" />
                <x-text-input id="business_name" class="block mt-1 w-full" type="text" name="business_name"
                    :value="old('business_name')" required autocomplete="organization" />
                <x-input-error :messages="$errors->get('business_name')" class="mt-2" />
            </div>
        </div>

        <div class="flex gap-4 mt-4">
            <div class="flex-1">
                <x-input-label for="email" :value="__('Email (User Id)')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex-1">
                <x-input-label for="contact_no" :value="__('Contact No')" />
                <x-text-input id="contact_no" class="block mt-1 w-full" type="text" name="contact_no"
                    :value="old('contact_no')" required />
                <x-input-error :messages="$errors->get('contact_no')" class="mt-2" />
            </div>
        </div>

        <div class="flex gap-4 mt-4">
            <div class="flex-1">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex-1">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="mt-4">
            <x-input-label for="about" :value="__('About Business/You (Upto 200 Characters)')" />
            <textarea id="about" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
             type="text" name="about" :value="old('about')"
                placeholder="Enter About Details"></textarea>
            <x-input-error :messages="$errors->get('about')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="address" :value="__('Address')" />
            <textarea id="address" name="address" rows="3"
                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Enter Your Address">{{ old('address') }}</textarea>
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <div class="flex gap-4 mt-4">
            <div class="flex-1">
                <x-input-label for="city" :value="__('City')" />
                <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" />
                <x-input-error :messages="$errors->get('city')" class="mt-2" />
            </div>

            <div class="flex-1">
                <x-input-label for="country" :value="__('Country')" />
                <select id="country" name="country"
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">Select Country</option>
                    <option value="Afghanistan">Afghanistan</option>
                    <option value="Australia">Australia</option>
                    <option value="Bangladesh">Bangladesh</option>
                    <option value="Canada">Canada</option>
                    <option value="China">China</option>
                    <option value="France">France</option>
                    <option value="Germany">Germany</option>
                    <option value="India" selected>India</option>
                    <option value="Indonesia">Indonesia</option>
                    <option value="Italy">Italy</option>
                    <option value="Japan">Japan</option>
                    <option value="Malaysia">Malaysia</option>
                    <option value="Nepal">Nepal</option>
                    <option value="Netherlands">Netherlands</option>
                    <option value="New Zealand">New Zealand</option>
                    <option value="Pakistan">Pakistan</option>
                    <option value="Russia">Russia</option>
                    <option value="Singapore">Singapore</option>
                    <option value="South Africa">South Africa</option>
                    <option value="Spain">Spain</option>
                    <option value="Sri Lanka">Sri Lanka</option>
                    <option value="Thailand">Thailand</option>
                    <option value="United Arab Emirates">United Arab Emirates</option>
                    <option value="United Kingdom">United Kingdom</option>
                    <option value="United States">United States</option>
                    <option value="Vietnam">Vietnam</option>
                </select>
                <x-input-error :messages="$errors->get('country')" class="mt-2" />
            </div>
        </div>

        <div class="mt-4">
            <x-input-label for="zip_code" :value="__('Zip Code')" />
            <x-text-input id="zip_code" class="block mt-1 w-full" type="text" name="zip_code"
                :value="old('zip_code')" />
            <x-input-error :messages="$errors->get('zip_code')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label :value="__('Logo (200px x 200px)')" />
            <div class="flex items-center gap-4 mt-1">
                <input type="file" id="logoInput" name="logo" accept="image/*"
                    class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">

                <div id="logoPreviewContainer" class="relative hidden">
                    <img id="logoPreview" src="#" alt="Logo Preview"
                        class="w-16 h-16 object-cover rounded-md border border-gray-300">
                    <button type="button" id="removeLogo"
                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600 shadow-sm">&times;</button>
                </div>
            </div>
            <x-input-error :messages="$errors->get('logo')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>

    </form>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function () {
            // Real-time Preview with 4MB Check
            $('#logoInput').change(function () {
                const file = this.files[0];
                const maxSize = 4 * 1024 * 1024; // 4MB in bytes

                if (file) {
                    // Check file size
                    if (file.size > maxSize) {
                        alert("Bhai, image bahut badi hai! Max 4MB allowed hai.");
                        $(this).val(''); // Reset input
                        $('#logoPreviewContainer').addClass('hidden');
                        return;
                    }

                    let reader = new FileReader();
                    reader.onload = function (event) {
                        $('#logoPreview').attr('src', event.target.result);
                        $('#logoPreviewContainer').removeClass('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Remove Logo Logic
            $('#removeLogo').click(function () {
                $('#logoInput').val(''); // Clear file input
                $('#logoPreviewContainer').addClass('hidden'); // Hide preview
                $('#logoPreview').attr('src', '#');
            });
        });
    </script>
</x-guest-layout>
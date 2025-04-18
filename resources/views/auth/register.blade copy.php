<x-guest-layout>

    <div class="mt-4">
        <x-input-label for="phone_no" :value="__('Phone Number')" />
        <x-text-input id="phone_no" class="block mt-1 w-full" type="text" name="phone_no" :value="old('phone_no')"
            required autocomplete="phone_no" />
        <x-input-error :messages="$errors->get('phone_no')" class="mt-2" />
        <button type="button" onclick="sendOtp()"
            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
            Send OTP
        </button>
    </div>

    <form method="POST" id="registerForm" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        
        <!-- OTP -->
        <div class="mt-4">
            <x-input-label for="otp" :value="__('OTP')" />
            <x-text-input id="otp" class="block mt-1 w-full" type="text" name="otp" required />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button onclick="verifyOtp()" type="button">
                    Verify OTP & Register
                </x-primary-button>
            </div>
        </div>
    </form>

    <script>
        async function sendOtp() {
            let phone = document.querySelector("#phone_no").value;
            if (!phone) {
                alert("Please enter a phone number.");
                return;
            }

            let response = await fetch("/api/send-otp", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    phone_no: phone
                })
            });

            let data = await response.json();

            if (response.ok) {
                alert(data.message);
            } else {
                alert("Failed to send OTP. " + (data.error || "Please try again."));
            }
        }


        async function verifyOtp() {
            let phone = document.querySelector("#phone_no").value;
            let otp = document.querySelector("#otp").value;

            if (!phone || !otp) {
                alert("Please enter both phone number and OTP.");
                return;
            }

            let response = await fetch("/api/verify-otp", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    phone_no: phone,
                    otp: otp
                })
            });

            let data = await response.json();

            if (response.ok) {
                alert(data.message);
                document.querySelector("#registerForm").submit(); // OTP ভেরিফাই হলে ফর্ম সাবমিট করবে
            } else {
                alert("OTP verification failed: " + (data.error || "Invalid OTP."));
            }
        }
    </script>
</x-guest-layout>

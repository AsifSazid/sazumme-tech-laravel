<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Thanks for signing up! Your primary phone no is')}} <strong> {{Auth::user()->phone_no}} </strong> {{ __('Before getting started, could you verify your phone no by clicking on the send OTP we just sent to you? If you didn\'t receive the message, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'otp-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ __('A new OTP has been sent to the primary phone number you provided during registration.') }}

            {{session('code')}}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <x-primary-button onclick="sendOtp(event)" type="button">
            {{ __('Send OTP') }}
        </x-primary-button>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>

        
    <!-- Add this below your Send OTP button -->
    <p id="otp-status" class="text-green-500 mt-2"></p>

    <form method="POST" action="{{ route('verify-otp') }}">
        @csrf
        <div class="mt-4">
            <x-input-label for="otp" :value="__('Your OTP Number')" />
            <x-text-input id="otp" class="block mt-1 w-full" type="text" name="otp" :value="old('otp')"
                required autocomplete="otp" />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <x-primary-button class="mt-4 w-full justify-center">
            Verify OTP
        </x-primary-button>
    </form>
    
    <script>
        function sendOtp(event) {
            event.preventDefault(); // Prevent form from submitting normally
    
            fetch("{{ route('phone-no.verification.send') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({}), // No extra data needed, just trigger OTP send
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "otp-sent") {
                    alert("OTP Sent Successfully: " + data.code); // Display OTP (for testing)
                    document.getElementById("otp-status").innerText = data.code;
                }
            })
            .catch(error => console.error("Error sending OTP:", error));
        }
    </script>
    

</x-guest-layout>

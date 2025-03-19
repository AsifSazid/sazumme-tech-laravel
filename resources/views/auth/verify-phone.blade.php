<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Thanks for signing up! Your primary phone no is') }} <strong> {{ Auth::user()->phone_no }} </strong>
        {{ __('Before getting started, could you verify your phone no by clicking on the send OTP we just sent to you? If you didn\'t receive the message, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'otp-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ __('A new OTP has been sent to the primary phone number you provided during registration.') }}

            {{ session('code') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <x-primary-button id="sendOtpButton" onclick="sendOtp(event)" type="button">
            {{ __('Send OTP') }}
        </x-primary-button>

        <span id="timer" class="text-sm text-gray-600 dark:text-gray-400 hidden">
            {{ __('Please wait') }} <span id="timeLeft">5:00</span>
        </span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
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
        let otpTimeout = null; // Timer reference to control the countdown

        // Function to handle sending OTP
        function sendOtp(event) {
            event.preventDefault(); // Prevent default form submission

            // Disable the button
            let sendOtpButton = document.getElementById("sendOtpButton");
            sendOtpButton.disabled = true;

            // Show the timer countdown
            let timerElement = document.getElementById("timer");
            timerElement.classList.remove("hidden"); // Show the timer
            let timeLeft = 5 * 60; // 5 minutes in seconds

            // Update the timer display every second
            otpTimeout = setInterval(function() {
                let minutes = Math.floor(timeLeft / 60);
                let seconds = timeLeft % 60;
                document.getElementById("timeLeft").innerText = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

                if (timeLeft <= 0) {
                    clearInterval(otpTimeout); // Stop the timer
                    sendOtpButton.disabled = false; // Re-enable the button
                    timerElement.classList.add("hidden"); // Hide the timer
                }

                timeLeft--;
            }, 1000);

            // Send the OTP request to the server
            fetch("{{ route('phone-no.verification.send') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        // You can include other parameters like phone number if necessary
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error); // Show an error message if the OTP is already sent or any issue occurs
                    } else {
                        alert(data.code); // Show the OTP sent to the user
                    }
                })
                .catch(error => console.error("Error sending OTP:", error));
        }
    </script>


</x-guest-layout>

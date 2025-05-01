<div class="msgBody">
    <h1>🚧 We're Working On this page!</h1>
    <p class="message">
        This page is currently undergoing scheduled maintenance.<br>
        We’re making improvements to serve you better.<br>
        Stay tuned — we’ll be back online shortly!
    </p>
    {{-- <div id="countdown"></div> --}}
    <div class="footer-note">Thank you for your patience and support ❤️</div>
</div>

@push('css')
    <style>
        .msgBody {
            margin: 20px;
            padding: 20px;
            font-family: 'Roboto', sans-serif;
            justify-content: center;
            align-items: center;
            text-align: center;
            flex-direction: column;
            gap: 1.5rem;
        }

        h1 {
            font-size: 3rem;
            margin: 20px;
        }

        p.message {
            font-size: 1.3rem;
            max-width: 500px;
            margin: 0 auto;
            opacity: 0.85;
        }

        #countdown {
            font-family: 'Orbitron', sans-serif;
            font-size: 2.2rem;
            color: #00ffc8;
            background: rgba(255, 255, 255, 0.05);
            padding: 1rem 2rem;
            border-radius: 16px;
            border: 2px solid #00ffc8;
            box-shadow: 0 0 15px #00ffc8;
            letter-spacing: 2px;
        }

        .footer-note {
            margin-top: 3rem;
            font-size: 0.9rem;
            color: #4f5357;
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 2rem;
            }

            #countdown {
                font-size: 1.5rem;
            }
        }
    </style>
@endpush

@push('js')
@endpush

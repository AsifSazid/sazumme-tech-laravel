<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>SazUmme - IT Solutions Consultancy</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('ui/frontend/assets') }}/images/logos/favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&family=Roboto&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #f8fafc;
            text-align: center;
            flex-direction: column;
            gap: 1.5rem;
        }

        h1 {
            font-size: 3rem;
            margin: 0;
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
            color: #cbd5e1;
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
</head>

<body>
    <h1>🚧 We're Working On Something Great!</h1>
    <p class="message">
        Our website is currently undergoing scheduled maintenance.<br>
        We’re making improvements to serve you better.<br>
        Stay tuned — we’ll be back online shortly!
    </p>
    <div id="countdown"></div>
    <div class="footer-note">Thank you for your patience and support ❤️</div>

    <script>
        const targetDate = new Date("2025-04-14T06:00:00Z").getTime();
        const countdown = document.getElementById("countdown");

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = targetDate - now;

            if (distance < 0) {
                countdown.innerHTML = "We're Back Online!";
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            countdown.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
        }

        setInterval(updateCountdown, 1000);
        updateCountdown();
    </script>
</body>

</html>

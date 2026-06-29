<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jaringan Terputus - Mediction</title>
    <style>
        :root {
            --bg-blue-50: #eff6ff;
            --text-primary: #1E3A8A;
            --text-muted: rgba(30, 58, 138, 0.7);
            --blue-400: #60a5fa;
            --red-400: #f87171;
            --blue-800: #1e40af;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg-blue-50);
            color: var(--text-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1.5rem;
            overflow: hidden;
        }

        .container {
            max-width: 28rem;
            width: 100%;
            text-align: center;
            position: relative;
            z-index: 10;
        }

        .space-y-8 > * + * { margin-top: 2rem; }
        .space-y-4 > * + * { margin-top: 1rem; }

        .logo-wrapper {
            position: relative;
            display: inline-block;
        }

        .logo-circle {
            width: 8rem;
            height: 8rem;
            background-color: #fff;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            margin: 0 auto;
            position: relative;
            z-index: 10;
        }

        .logo-bg-icon {
            width: 4rem;
            height: 4rem;
            color: var(--blue-400);
            opacity: 0.2;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .logo-img {
            width: 5rem;
            height: 5rem;
            object-fit: contain;
            position: relative;
            z-index: 20;
        }

        .orbit-icon {
            position: absolute;
            top: -0.25rem;
            right: -0.25rem;
            width: 1rem;
            height: 1rem;
            background-color: var(--red-400);
            border-radius: 9999px;
            border: 2px solid #fff;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            animation: orbit 4s linear infinite;
        }

        @keyframes orbit {
            0% { transform: rotate(0deg) translateX(10px) rotate(0deg); }
            100% { transform: rotate(360deg) translateX(10px) rotate(-360deg); }
        }

        h1 {
            font-size: 1.875rem;
            font-weight: 700;
            letter-spacing: -0.025em;
            margin-bottom: 0.5rem;
        }

        p {
            color: var(--text-muted);
            line-height: 1.625;
            font-size: 1rem;
        }

        .btn-reload {
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 2rem;
            background-color: var(--text-primary);
            color: #fff;
            font-weight: 600;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transition: all 0.2s;
            cursor: pointer;
            border: none;
            text-decoration: none;
            font-size: 1rem;
        }

        .btn-reload:hover { background-color: var(--blue-800); }
        .btn-reload:active { transform: scale(0.95); }

        .btn-icon {
            width: 1.25rem;
            height: 1.25rem;
            margin-right: 0.5rem;
            transition: transform 0.5s;
        }

        .btn-reload:hover .btn-icon { transform: rotate(180deg); }

        .footer {
            margin-top: 2rem;
            font-size: 0.75rem;
            color: var(--blue-400);
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .bg-pattern {
            position: fixed;
            inset: 0;
            pointer-events: none;
            opacity: 0.03;
            z-index: 0;
        }
    </style>
</head>
<body>
    <div class="container space-y-8">
        <div class="logo-wrapper">
            <div class="logo-circle">
                <svg class="logo-bg-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.345 6.347c5.858-5.857 15.352-5.857 21.213 0"></path>
                </svg>
                <img src="data:image/webp;base64,UklGRsoDAABXRUJQVlA4IL4DAACQHgCdASrAAMAAPpFGoEqlpCOiJlSZYLASCWNu3V7xm9+S1peVbx3HTHv6X8bH/C9lPmAc6PzF/930jf9d6kPQA6U30APLP9qrIadklwGSAJgSsBwXTi4czMzMzMzMzMzMy73cHxAsMnFwa9JNxi75schgou9z+g27NVsiv6El/G0HCTiTK7CwGTwMtJyaczZlJZ5B1VJfKfhiB0YR5y6bgXAgmYVx/Y6trTn7Eq2jcdAPwcJvn84wOPMc6toPgyrnj1ulh6ECdjZIZ0YXEwkKbP7raMH0jBCb64SS3SFa6a5UpRRW52o4vJfVG1wN+q4wRTigxzuHPoqrVpgAAP75sQAAAAEZp1aW1FQZUyaYUuqJbcz76K/vXgHCJn5uT/QmHwDPmDzK8B/WRbLnhPDWIp9IOAMGI91TCyv5xw5vMFWbKtPAjY9jIfpYSEHPT43Owi2LsVe4VjMs/PUp2uY+QJSVB9iQ2gYgrzszEQVOe3yygbjrVh+edzfCsl7HyXYLco7rYlmn+4W6pLr4i1d0fDweY8hDeoq0Ax6tp0q7fKE8xod8SQPqZINnSn9Ir2qKiYUWe0hbgBurrKH5gf7qqZA3iD7KrZhk+ZBf2fge66iJLmuuZDYh8G5LAQTRcIxTxrTUjt28HG2bOMpMwQDO1/Bo5IVHNiAs7Lvm5u2KjQjHqbSHRDz/cGZrIoXFkDyk6K9DibdBoWDCYYAEGBnDX5f39Eve1hVd1um2htGjDKWampbQ2V+7fv/81eNOsxfrn7+19Zpfd2xlmApBgLkDeyKqGZoum/rfk9pC/jWL79rSKJ4Iw7N6HPtpPlrCiPN/dQMUCwacPxjNGWaxLnevzWX24Gzdtd8TA4R8lp2++GOTVVzffzV0FByG8lyAoaxwri3sQ4LOWwHjsqVpDfIyhZY6tZJaT36PTeSx7NtDI3/tix5MIXa4HP2CwRrZ2mYE9TziFgn1ObKZHGqSGstZPU6NeegZ7vSRM7ePJ2Dr1yViZ8+lAl+D/hcp+y46Y68c8rlFber24uSEIQLP40nh36eAJ86mKJDhodsbunmXxAM05ps0B13lw3ZEIu/625mGkLWIfoSulYWWgc4OFfNIusydPW6JiGZrVDjHEgxDwfsvcTXDR3OUBMlqoTeRvumhka0d9yUg8IohwSnEH0pbiQGbiDvZZ6iQ4kc7yXbJspP5BaaGJIM2DlgJwDmEju++iR5KUzmovgsvI0q4/v+gcHEUecd0NnICTgCWAA8oA6b9iXy3ZZ7OgAAAAAAA" alt="Starkids Logo" class="logo-img">
            </div>
            <div class="orbit-icon"></div>
        </div>

        <div class="space-y-4">
            <h1>Koneksi Terputus</h1>
            <p>Sepertinya Anda kehilangan koneksi internet. Halaman ini memerlukan jaringan aktif untuk menampilkan data medis Starkids.</p>
        </div>

        <div style="padding-top: 1rem;">
            <button onclick="window.location.reload()" class="btn-reload">
                <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Coba Muat Ulang
            </button>
        </div>

        <p class="footer">Mediction &bull; Offline Mode</p>
    </div>

    <div class="bg-pattern">
        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
            <rect width="100%" height="100%" fill="none"/>
            <path d="M0 0l100 100M100 0L0 100" stroke="#1E3A8A" stroke-width="0.5" vector-effect="non-scaling-stroke"/>
        </svg>
    </div>

    <script>
        // Auto-reload check when back online
        window.addEventListener('online', () => {
            window.location.reload();
        });
    </script>
</body>
</html>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/errors/offline.blade.php ENDPATH**/ ?>
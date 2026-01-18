<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Failure</title>
    <style>
        :root {
            --bg: #111827;
            --text: #e5e7eb;
            --accent: #ef4444;
            --card: #1f2937;
            --border: #374151;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: system-ui, -apple-system, sans-serif;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .container {
            background: var(--card);
            border: 1px solid var(--border);
            padding: 2.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            width: 90%;
            max-width: 32rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--accent);
        }

        h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #fff;
        }

        p {
            color: #d1d5db;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .meta {
            font-family: monospace;
            font-size: 0.75rem;
            color: #6b7280;
            background: rgba(0, 0, 0, 0.2);
            padding: 1rem;
            border-radius: 0.375rem;
            text-align: left;
            margin-bottom: 2rem;
        }

        .footer {
            margin-top: 3rem;
            font-size: 0.875rem;
            color: #6b7280;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .separator {
            width: 1px;
            height: 1rem;
            background: #374151;
        }
    </style>
</head>

<body>
    <div class="container">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
            stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            style="margin: 0 auto 1rem auto;">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12.01" y2="16"></line>
        </svg>

        <h1>System Failure</h1>

        <p>{{ $message ?? 'Service Unavailable' }}</p>

        <div class="meta">
            <div><strong>Error Code:</strong> 503_PAYMENT_REQUIRED</div>
            <div><strong>Reference:</strong> UNKNOWN</div>
            <div><strong>Request ID:</strong> {{ $reqId ?? uniqid() }}</div>
        </div>
    </div>

    <div class="footer">
        <div style="display:flex; align-items:center; gap:0.5rem;">
            <svg viewBox="0 0 24 24" fill="currentColor" style="width:1.25rem;height:1.25rem;color:#ef4444;">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
            </svg>
            <span>Laravel v{{ app()->version() }} (PHP v{{ phpversion() }})</span>
        </div>
        <div class="separator"></div>
        <span>{{ date('Y-m-d H:i:s T') }}</span>
    </div>
</body>

</html>

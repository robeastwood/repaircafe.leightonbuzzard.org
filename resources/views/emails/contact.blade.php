<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .content {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #e9ecef;
            border-radius: 8px;
        }
        .field {
            margin-bottom: 15px;
        }
        .field-label {
            font-weight: bold;
            color: #495057;
            margin-bottom: 5px;
        }
        .field-value {
            color: #212529;
        }
        .message-content {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            white-space: pre-wrap;
        }
        .footer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            font-size: 0.875rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="margin: 0; color: #212529;">New Contact Form Submission</h2>
    </div>

    <div class="content">
        <div class="field">
            <div class="field-label">From:</div>
            <div class="field-value">{{ $name }}</div>
        </div>

        <div class="field">
            <div class="field-label">Email:</div>
            <div class="field-value">
                <a href="mailto:{{ $email }}">{{ $email }}</a>
            </div>
        </div>

        <div class="field">
            <div class="field-label">Subject:</div>
            <div class="field-value">{{ $contactSubject }}</div>
        </div>

        <div class="field">
            <div class="field-label">Message:</div>
            <div class="message-content">{{ $contactMessage }}</div>
        </div>
    </div>

    <div class="footer">
        <p>This message was sent from the Repair Cafe contact form at {{ now()->format('d/m/Y H:i') }}.</p>
    </div>
</body>
</html>

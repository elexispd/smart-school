<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f3f4f6; }
        .email-wrapper { width: 100%; background-color: #f3f4f6; padding: 40px 0; }
        .email-container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        .email-header { background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 40px 30px; text-align: center; }
        .email-header h1 { color: #ffffff; margin: 0; font-size: 28px; font-weight: 700; }
        .email-header p { color: #d1fae5; margin: 10px 0 0 0; font-size: 14px; }
        .email-body { padding: 40px 30px; color: #374151; line-height: 1.6; }
        .email-body h2 { color: #111827; font-size: 22px; margin: 0 0 20px 0; font-weight: 600; }
        .email-body p { margin: 0 0 15px 0; font-size: 15px; }
        .info-box { background-color: #f9fafb; border-left: 4px solid #10b981; padding: 20px; margin: 25px 0; border-radius: 6px; }
        .info-box h3 { color: #059669; margin: 0 0 15px 0; font-size: 16px; font-weight: 600; }
        .info-row { display: flex; margin-bottom: 10px; }
        .info-label { font-weight: 600; color: #6b7280; min-width: 120px; }
        .info-value { color: #111827; }
        .button { display: inline-block; padding: 14px 32px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff !important; text-decoration: none; border-radius: 8px; font-weight: 600; margin: 20px 0; transition: transform 0.2s; }
        .status-badge { display: inline-block; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .status-approved { background-color: #d1fae5; color: #065f46; }
        .status-rejected { background-color: #fee2e2; color: #991b1b; }
        .email-footer { background-color: #f9fafb; padding: 30px; text-align: center; border-top: 1px solid #e5e7eb; }
        .email-footer p { color: #6b7280; font-size: 13px; margin: 5px 0; }
        .divider { height: 1px; background-color: #e5e7eb; margin: 30px 0; }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            @yield('content')
        </div>
    </div>
</body>
</html>

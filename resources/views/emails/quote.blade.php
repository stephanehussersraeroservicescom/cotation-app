<!-- resources/views/emails/quote.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Your Quote from Tapis Corporation</title>
</head>
<body>
    <p>Dear {{ $quote->customer_name }},</p>
    <p>Please find attached the quote you requested.</p>
    <p>Thank you for choosing Tapis Corporation.</p>
    <p>Best regards,</p>
    <p>Tapis Corporation</p>
</body>
</html>
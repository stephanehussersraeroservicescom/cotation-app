<!-- resources/views/quotes/preview.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Preview Quote Email</title>
</head>
<body>
    <h1>Preview Quote Email</h1>
    <p>Dear {{ $quote->customer_name }},</p>
    <p>Please find attached the quote you requested.</p>
    <p>Thank you for choosing Tapis Corporation.</p>
    <p>Best regards,</p>
    <p>Tapis Corporation</p>

    <h2>Attachment</h2>
    <embed src="data:application/pdf;base64,{{ base64_encode($pdf) }}" width="1200" height="800" type="application/pdf">

    <form action="{{ route('quote.send', $quote->id) }}" method="POST">
        @csrf
        <button type="submit">Send Email</button>
    </form>
</body>
</html>
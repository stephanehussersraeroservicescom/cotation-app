<!-- resources/views/quotes/preview.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Preview Quote Email</title>
</head>
<body>
    <form action="{{ route('quote.send', $quote->id) }}" method="POST">
        @csrf
        <x-button type="submit">Send Email</x-button>
    </form>
    <div class=>
        <h1>Your Quote</h1>
            <p>Dear {{ $quote->customer_name }},</p>
            <p>Thank you for your interest in Tapis products. </p>
            <p>Please find attached the quote you requested.</p>
            <p>Thank you for choosing Tapis Corporation.</p>
            <p>Best regards, MFG</p>
            <p>Tapis Corporation</p>
            <br />
            <p>Best regards</p>
            <br>
            <p>{{ Auth::user()->name }}</p>
            <img src="{{ asset('storage/images/tapis-logo.png') }}" alt="Tapis Logo" style="width: 200px; height: auto;">
    </div>

    <h2>Attachment</h2>
    <embed src="data:application/pdf;base64,{{ base64_encode($pdf) }}" width="1200" height="800" type="application/pdf">





</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>Quote PDF</title>
    <style>
        @page {
            margin-top: 20px; /* Adds space for the header */
            margin-bottom: 20px; /* Adds space for the footer, if needed */
            
        }


        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            position: relative;
        }
        .header img {
            position: absolute;
            top: 0;
            right: 0;
            width: 210px;
        }
        .header h1 {
            margin-top: 80px;
            padding: 0;
            font-size: 120%;
        }
        .info {
            margin-top: 25px;
            line-height: 2;
        }
        .adresse p {
            margin: 0;
            padding: 0;
            line-height: 1.2;
            font-size: 100%;
            text-align: left;
            top: -60px;
        }
        .info p {
            margin: 0;
            padding: 0;
            font-size:90%;
        }
        .table-container {
            margin-top: 20px;
        }
        .table {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
            border-radius: 5px;
            overflow: hidden;
            font-size: 70%;
        }
        .table th, .table td {
            padding: 5px;
            text-align: left;
        }
        .table th {
            background-color: #bebcbc;
            color:black;
            text-align: left;
            border: none;
        }
        .table td {
            background-color: white;
            color: black;
            text-align: left;
            border: 1px solid black;
        }
        .footer {
            margin-top: 20px;
            font-size: 70%; 
        }
        .page-break {
            page-break-after: always;
        }
        .footnote {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 60%;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .fntext p {
            align-items: left;
        }
        .footnote img { 
            align-items: right;
            width: 100px;
            height: 100px; 
        }
        .header-image {
            position: fixed;
            top: 25px; /* Position it above the page's content */
            left: 0;
            right: 0;
            height: 50px;
            text-align: right;
        }

        </style>
    </head>
    <body>
        <header>
        <div class="header-image"><img src="{{ public_path('storage/images/tapis-logo.png') }}" alt="Tapis Corporation Logo" style=" height: 70px;" class="block h-9 w-auto"></div>
        
            <div class="adresse">
            <p>Tapis Corporation</p>
            <p>53 Old Route 22</p>
            <p>Armonk, NY, 10504</p>
            <p>Phone: +1 9142732737</p>
            </div>
        </br>
    </br>
            <h1>Tapis Quote Reference: {{ $quote->user->initials}}-{{ $quote->id }}</h1>
        </div>
    </header>


    <div class="info">
        <p><strong>Date Quoted:</strong> {{ $quote->date_entry }}</p>
        <p><strong>Date Valid:</strong> {{ $quote->date_valid }}</p>
        <p><strong>Customer Name:</strong> {{ $quote->customer_name }}</p>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
            <tr>
                <th style="width: 3%; border-radius: 10px 0 0 0;">ID</th>
                <th style="width: 15%;">Product</th>
                <th style="width: 37%;">Part Number</th>
                <th style="width: 6%;">MOQ</th>
                <th style="width: 6%;">UOM</th>
                <th style="width: 17%;">Lead Time</th>
                <th style="width: 16%; border-radius: 0 10px 0 0;">Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quote->quoteLines as $line)
                <tr>
                    <td>{{ $line->id }}</td>
                    <td>{{ $line->product->name }}</td>
                    <td>{{ $line->part_number }}</td>
                    <td>{{ $line->MOQ }}</td>
                    <td>{{ $line->UOM }}</td>
                    <td>12 to 15 weeks</td>
                    {{-- <td>{{ $line->lead_time }}</td> --}}
                    <td>USD {{ number_format($line->price / 100, 2) }} / {{ $line->UOM }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
    </br>
        <div style="font-size:70%">Payment Terms : {{ $quote->payment_terms }}</div>
        <div style="font-size:70%" >Shipping Terms : {{ $quote->shipping_terms }}</div>
        @if ($quote->comments)
            <p style="font-size:70%">Notes : {{ $quote->comments }}</p>
        @endif

    </div>
    <div class="footer">
        @foreach($quote->quoteLines as $line)
           <div></br>Line {{ $line->id }} - {{ $line->product->product}} - {{ $line->part_number }} </div> 
           @if ($line->UOM ==="LY")
                {!!$line->product->description_LY!!}         
           @else
                {!!$line->product->description_LM!!}   
           @endif
           <div></div>
        @endforeach
    </div>

    <div class="footnote">
        <div class="qrc" style="flex: 0; text-align: right; display: flex; align-items: center;">
            <img src="{{ public_path('storage/images/qr-code.png') }}" alt="Tapis Corporation Logo" class="block h-9 w-auto">
        </div>
        <div class="fntext" style="flex: 1; text-align: left; display: flex; align-items: center;">
            <p>Please refer to our terms and conditions on our website or by scanning the QR-Code</p>
        </div>

    </div>
</body>
</html>
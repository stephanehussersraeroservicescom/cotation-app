<!DOCTYPE html>
<html>
<head>
    <title>Quote PDF</title>
    <style>
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
            margin-top: 90px;
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
            text-align: left;
        }
        .info p {
            margin: 0;
            padding: 0;
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
            padding: 8px;
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
    </style>
</head>
<body>
    <div class="header">
        <div class="adresse">
            <p>Tapis Corporation</p>
            <p>28 Kaysal Court</p>
            <p>Armonk, NY, 10504</p>
            <p>Phone: +1 9142732737</p>
        </div>
        <img src="{{ public_path('storage/tapis-logo.png') }}" alt="Tapis Corporation Logo">
        <h1>Tapis Quote Reference: {{ $quote->SAE }}-{{ $quote->id }}</h1>
    </div>

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
                    <td>USD {{ $line->price /100 }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="footer">
        @foreach($quote->quoteLines as $line)
           <div>Line : {{ $line->id }} - {{ $line->product->name }} - {{ $line->part_number }} </div> 
           @if ($line->MOQ ==="LY")
                {{$line->product->description_LY}}         
           @else
                {{$line->product->description_LM}}   
           @endif
           <div></div>
        @endforeach
    </div>
    <div class="footnote">
        <div class="qrc" style="flex: 0; text-align: right; display: flex; align-items: center;">
            <img src="{{ public_path('storage/qr-code.png') }}" alt="QR Code">
        </div>
        <div class="fntext" style="flex: 1; text-align: left; display: flex; align-items: center;">
            <p>Please refer to our terms and conditions on our website or by scanning the QR-Code</p>
        </div>

    </div>
</body>
</html>
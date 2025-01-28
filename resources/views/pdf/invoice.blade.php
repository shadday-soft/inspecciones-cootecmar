<!doctype html>
<html lang='en'>

<head>
    <title>Invoice for {{ $to }}</title>
    <meta charset='utf-8'>

    {{-- Use an absolute path when specifying the CSS so it works in the PDF --}}
    <link href='{{ public_path('css/invoice.css') }}' rel='stylesheet'>
</head>

<body>
    <h1>Invoice</h1>

    <div>
        <p class='label'>Billed to:</p>
        <p>{{ $to }}</p>
    </div>
    <p><span class='label'>Subtotal:</span> ${{ $subtotal }}</p>
    <p><span class='label'>Tax:</span> ${{ $tax }}</p>
    <p><span class='label'>Total:</span> ${{ $total }}</p>
</body>

</html>

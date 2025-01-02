<!DOCTYPE html>
<html>
<head>
    <title>Nota Service - {{ $service->services_id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .service-details {
            margin-bottom: 20px;
        }
        .transactions {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .transactions th, .transactions td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .total {
            text-align: right;
            font-weight: bold;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PHICOM SERVICE NOTA</h1>
        <p>Service ID: {{ $service->services_id }}</p>
    </div>

    <div class="service-details">
        <h2>Service Information</h2>
        <p><strong>Customer:</strong> {{ $service->customer->name }}</p>
        <p><strong>Service Details:</strong> {{ $service->service_details }}</p>
        <p><strong>Status:</strong> {{ $service->status }}</p>
    </div>

    <table class="transactions">
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->item->name }}</td>
                <td>{{ $transaction->quantity }}</td>
                <td>Rp {{ number_format($transaction->price, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <h3>Total: Rp {{ number_format($service->total, 0, ',', '.') }}</h3>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
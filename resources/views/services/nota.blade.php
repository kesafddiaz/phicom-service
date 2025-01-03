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
        .header-left {
            float: left;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header-right {
            float: right;
            padding-bottom: 10px;
            margin-top: 15px;
            margin-bottom: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-top: 180px;
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
    <div class="header-left">
        <h1>PHICOM LAPTOP SERVICE</h1>
        <p>Jl. Terusan Buahbatu Bojongsoang 234C Bandung</p>
        <p>Telp./Whatsapp 081211667899 - IG : phicom_laptop</p>
    </div>

    <div class="header-right">
        <p><strong>Nota No:</strong> {{ $service->services_id }}</p>
        <p><strong>Nama:</strong> {{ $service->customer->name }}</p>
        <p><strong>Telp:</strong> {{ $service->customer->phone }}</p>
        <p><strong>Tanggal:</strong> {{ $service->created_at }}</p>
    </div>

    <div class="header"></div>

    <table class="transactions">
        <thead>
            <tr>
                <th>Banyaknya</th>
                <th>Deskripsi</th>
                <th>Satuan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->quantity }}</td>
                <td>{{ $transaction->item->name }}</td>
                <td>Rp {{ number_format($transaction->price, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Total</td>
                <td>Rp {{ number_format($service->total, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div style="text-align: right">
        <p>Hormat kami:</p>
        <br>
        <p>Phicom Laptop Service</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
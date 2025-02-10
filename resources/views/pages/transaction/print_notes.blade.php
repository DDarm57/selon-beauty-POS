<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Nota</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .nota {
            width: 88mm;
            max-width: 100%;
            padding: 10px;
            border: 1px solid #000;
            margin: auto;
            text-align: left;
        }

        .nota h2,
        .nota p {
            margin: 5px 0;
        }

        .header-note {
            text-align: center;
            width: 100%;
            border-bottom: 1px dashed #000;
        }

        .nota .items {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 5px 0;
        }

        .nota .total {
            text-align: right;
            font-weight: bold;
            font-size: 15px;
            margin-top: 10px;
        }

        p {
            font-size: 12px;
        }

        .footer-note {
            border-top: 1px dashed #000;
            text-align: center;
            padding-top: 5px;
            font-size: 12px;
        }

        .action-button {
            margin-top: 10px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .action-button button {
            text-decoration: none;
            padding: 10px 20px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .nota {
                border: none;
                width: 58mm;
                max-width: 100%;
            }

            button {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="nota">
        <div class="header-note">
            <h4 style="margin-bottom: 0px;">{{ $profile_store->name }}</h4>
            <p>{{ $profile_store->address }} <br> Email: {{ $profile_store->email }}</p>
        </div>
        <p><strong>Kode Transaksi</strong> : {{ $transaction->transaction_code }}</p>
        <p><strong>Tgl/Waktu</strong> : {{ $transaction->created_at }}</p>
        <p style="margin-bottom: 10px;"><strong>Kasir</strong> : {{ $transaction->name }}</p>
        <div class="items">
            @foreach ($transaction_details as $item)
            <p>{{ $item->name }}</p>
            <div style="display: flex; justify-content: space-between;">
                <p>Rp.{{ number_format($item->price_product) }} {{ $item->qty }}x {{ ($item->product_discount != 0 ? 'Diskon ' . $item->product_discount . '%' : '') }}</p>
                <p>Rp.{{ number_format($item->total_product_price_after_discount) }}</p>
            </div>
            @endforeach
        </div>
        @php
        $total_potongan = $transaction->total_price - $transaction->total_price_after_discount;
        @endphp
        @if($total_potongan > 0)
        <p><strong>Total Potongan</strong> : Rp.{{ number_format($total_potongan) }}</p>
        @endif
        <p class="total">Total : Rp.{{ number_format($transaction->total_price_after_discount) }}</p>
        <p><strong>Bayar</strong> : Rp.{{ number_format($transaction->pay) }}</p>
        <p><strong>Kembali</strong> : Rp.{{ number_format($transaction->change) }}</p>
        <div class="footer-note">
            <p style="text-align: center; font-size:14px; font-weight: bolder;">Terima kasih!</p>
            <p>Instagram: {{ $profile_store->instagram }}</p>
            <p>tiktok: {{ $profile_store->tiktok }}</p>
        </div>
    </div>
    <div class="action-button">
        <a
            href="{{ $role == 1 ? route('transaction_details', $transaction->id_transaction) : route('transaction') }}">
            <button>Kembali</button>
        </a>
        <button onclick="window.print()">Cetak Nota</button>

    </div>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bukti Pembelian - Bengkel</title>
    <style>
        #back-wrap {
            margin: 30px auto 0 auto;
            width: 500px;
            display: flex;
            justify-content: flex-end;
        }

        .btn-back {
            width: fit-content;
            padding: 8px 15px;
            color: #fff;
            background: #666;
            border-radius: 5px;
            text-decoration: none;
        }

        #receipt {
            box-shadow: 5px 10px 15px rgba(0, 0, 0, 0.5);
            padding: 20px;
            margin: 30px auto 0 auto;
            width: 500px;
            background: #FFF;
        }

        h2 {
            font-size: .9rem;
        }

        p {
            font-size: .8rem;
            color: #666;
            line-height: 1.2rem;
        }

        #top {
            margin-top: 25px;
        }

        #top .info {
            text-align: left;
            margin: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 5px 0 5px 15px;
            border: 1px solid #EEE;
        }

        .tabletitle {
            font-size: .5rem;
            background: #EEE;
        }

        .service {
            border-bottom: 1px solid #EEE;
        }

        .itemtext {
            font-size: .7rem;
        }

        #legalcopy {
            margin-top: 15px;
        }

        .btn-print {
            float: right;
            color: #333;
        }
    </style>
</head>

<body>
    {{-- <div id="back-wrap">
        <a href="{{ route('orders') }}" class="btn-back">Kembali</a>
    </div> --}}

    <div id="receipt">
        {{-- <a href="#" class="btn-print">Cetak (.pdf)</a> --}}
        <center id="top">
            <div class="info">
                <h2>Bengkel</h2>
            </div>
        </center>

        <div id="mid">
            <div class="info">
                <p>
                    Alamat: sejalan jalan kenangan<br>
                    Email: bengkel@gmail.com<br>
                    Telepon: 000-111-2222<br>
                </p>
            </div>
        </div>
        <div id="bot">
            <div id="table">
                <table>
                    <tr class="tabletitle">
                        <td class="item">
                            <h2>Item</h2>
                        </td>
                        <td class="item">
                            <h2>Total</h2>
                        </td>
                        <td class="Rate">
                            <h2>Harga</h2>
                        </td>
                    </tr>

                    @if (!empty($order) && isset($order['bengkels']) && count($order['bengkels']) > 0)
                        @foreach ($order['bengkels'] as $bengkel)
                            <tr class="service">
                                <td class="tableitem">
                                    <p class="itemtext">{{ $bengkel['name_bengkel'] }}</p>
                                </td>
                                <td class="tableitem">
                                    <p class="itemtext">{{ $bengkel['qty'] }}</p>
                                </td>   
                                <td class="tableitem">
                                    <p class="itemtext">Rp. {{ number_format($bengkel['price'], 0, ',', '.') }}</p>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada Item yang ditemukan untuk pesanan ini.</td>
                        </tr>
                    @endif

                    @php
                        $ppn = !empty($order['total_price']) ? $order['total_price'] * 0.1 : 0;
                    @endphp
                    <tr class="tabletitle">
                        <td></td>
                        <td class="Rate">
                            <h2>PPN (10%)</h2>
                        </td>
                        <td class="payment">
                            <h2>Rp. {{ number_format($ppn, 0, ',', '.') }}</h2>
                        </td>
                    </tr>
                    <tr class="tabletitle">
                        <td></td>
                        <td class="Rate">
                            <h2>Total Harga</h2>
                        </td>
                        <td class="payment">
                            <h2>Rp.
                                {{ number_format((!empty($order['total_price']) ? $order['total_price'] : 0) + $ppn, 0, ',', '.') }}
                            </h2>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="legalcopy">
                <p class="legal"><strong>Terimakasih atas pembelian anda!</strong> Silahkan berkunjung lagi!</p>
            </div>
        </div>
    </div>
</body>
</html>
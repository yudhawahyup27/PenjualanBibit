<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi</title>
    <style>
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 class="text-center">Struk Transaksi</h2>

            <div>
                <h2>Republik Bibit</h2>
                <h3>
                    081216146400
                </h3>
                <p>
                    Jl.Welirang Ds. Tanjung Kec. Kertosono
                </p>
            </div>
        </div>
        <div class="content">
            @if($transaksi)
                <p><strong>Kode Transaksi:</strong> {{ $transaksi->kode_transaksi }}</p>

                <table class="table">
                    <tr>
                        <th>Quantity</th>
                        <th>Nama Bibit</th>
                        <th>Harga</th>
                    </tr>


                    @foreach ($cart as $item)
                        <tr>
                            <td>{{ $item->kuantitas_bibit }}</td>
                            <td>{{ $item->nama_bibit }}</td>

                            <td>      Rp. {{          number_format($item->harga_borong, 0,',','.') }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td style="border-style:hidden" colspan="2">
                            Total
                        </td>
                        <td>
                          Rp.  {{          number_format( $transaksi->total_transaksi , 0,',','.')}}
                        </td>
                    </tr>
                </table>
            @else
                <p>Transaksi tidak ditemukan.</p>
            @endif
        </div>

    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi</title>
    <style>    .table {
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
            <div>

            </div>
        </div>
        <div class="content">
            @if($transaksi)
                <p><strong>Kode Transaksi:</strong> {{ $transaksi->kode_transaksi }}</p>



<table class="table" style="width:100%">
    <tr>
      <th>Quantity</th>
      <th>Nama bibit</th>
      <th>Harga</th>
    </tr>
    @foreach ($cart as $item)
    <tr>
      <td>{{ $item ->Qty_beli }}</td>
      <td>{{ $item->nama_bibit }}s</td>
      <td>{{ $item->harga_bibit }}</td>
    </tr>
    @endforeach
    <tr>
    <td  style="border-style:hidden" colspan="2">
    Total
    </td>

    <td>
{{ $transaksi->total_transaksi }}
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

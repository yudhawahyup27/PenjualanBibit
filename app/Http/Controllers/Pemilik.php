<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Carbon;

class Pemilik extends Controller
{
    //
    public function redirectdashboard()
    {
        return redirect()->to('/pemilik/dashboard22');
    }
    public function dashboard(Request $request)
{
    try {
        $allTransactionsEceran = DB::table('tb_transaksi')
            ->orderBy('created_transaksi', 'desc')
            ->get();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($startDate) {
            $startDate = Carbon::parse($startDate);
            $allTransactionsEceran = $allTransactionsEceran->filter(function ($transaction) use ($startDate) {
                return Carbon::parse($transaction->created_transaksi)->greaterThanOrEqualTo($startDate);
            });
        }

        if ($endDate) {
            $endDate = Carbon::parse($endDate);
            $allTransactionsEceran = $allTransactionsEceran->filter(function ($transaction) use ($endDate) {
                return Carbon::parse($transaction->created_transaksi)->lessThanOrEqualTo($endDate);
            });
        }

        if ($request->ajax()) {
            if ($startDate || $endDate) {
                $groupedTransactions = $allTransactionsEceran->groupBy(function ($date) {
                    return Carbon::parse($date->created_transaksi)->format('d-m-Y');
                });
            } else {
                $groupedTransactions = $allTransactionsEceran->groupBy(function ($date) {
                    return Carbon::parse($date->created_transaksi)->format('m-Y');
                });
            }

            $groupedTransactions = $groupedTransactions->map(function ($group) {
                return [
                    'total_transaksi' => $group->sum('total_transaksi'),
                    'created_transaksi' => $group->first()->created_transaksi
                ];
            });

            return response()->json([
                'transactions' => $groupedTransactions->values()
            ]);
        }

        $transactionsPerDate = $allTransactionsEceran->groupBy(function ($date) {
            return Carbon::parse($date->created_transaksi)->format('d-m-Y');
        });

        $menu = "Dashboard";
        $submenu = "Pemilik";
        $monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        return view('pemilik.dashboard', compact(
            "menu", "submenu",
            'transactionsPerDate',
            'startDate',
            'endDate',
            'monthNames'
        ));
    } catch (\Exception $e) {
        Log::error('Error fetching data: ' . $e->getMessage());
        if ($request->ajax()) {
            return response()->json(['error' => 'Unable to fetch data'], 500);
        }
        return back()->with('error', 'Unable to fetch data');
    }
}

public function dashboard2(Request $request)
{
    try {
        $borongTransactions = DB::table('tb_transaksi_borong')->orderBy('created_at', 'desc')->get();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($startDate) {
            $startDate = Carbon::parse($startDate);
            $borongTransactions = $borongTransactions->filter(function ($transaction) use ($startDate) {
                return Carbon::parse($transaction->created_at)->greaterThanOrEqualTo($startDate);
            });
        }

        if ($endDate) {
            $endDate = Carbon::parse($endDate);
            $borongTransactions = $borongTransactions->filter(function ($transaction) use ($endDate) {
                return Carbon::parse($transaction->created_at)->lessThanOrEqualTo($endDate);
            });
        }

        if ($request->ajax()) {
            if ($startDate || $endDate) {
                $groupedTransactions = $borongTransactions->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('d-m-Y');
                });
            } else {
                $groupedTransactions = $borongTransactions->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('m-Y');
                });
            }

            $groupedTransactions = $groupedTransactions->map(function ($group) {
                return [
                    'total_transaksi' => $group->sum('total_transaksi'),
                    'created_at' => $group->first()->created_at
                ];
            });

            return response()->json([
                'transactions' => $groupedTransactions->values()
            ]);
        }

        $transactionsPerDate = $borongTransactions->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('d-m-Y');
        });

        $menu = "Dashboard";
        $submenu = "Pemilik";
        $monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        return view('pemilik.dashboard2', compact(
            "menu", "submenu",
            'transactionsPerDate',
            'startDate',
            'endDate',
            'monthNames'
        ));
    } catch (\Exception $e) {
        Log::error('Error fetching data: ' . $e->getMessage());
        if ($request->ajax()) {
            return response()->json(['error' => 'Unable to fetch data'], 500);
        }
        return back()->with('error', 'Unable to fetch data');
    }
}






private function filterTransactions($transactions, $selectedDay, $selectedMonth, $selectedYear)
{
    return $transactions->filter(function ($transaction) use ($selectedDay, $selectedMonth, $selectedYear) {
        return ($selectedYear === 'all' || $transaction->year == $selectedYear) &&
               ($selectedMonth === 'all' || $transaction->month == $selectedMonth) &&
               ($selectedDay === 'all' || $transaction->day == $selectedDay);
    });
}

private function fillMissingMonths($transactionsPerMonth)
{
    $months = range(1, 12);
    $years = $transactionsPerMonth->pluck('year')->unique();

    foreach ($years as $year) {
        foreach ($months as $month) {
            $key = $month . '-' . $year;
            if (!isset($transactionsPerMonth[$key])) {
                $transactionsPerMonth[$key] = collect([
                    (object) ['month' => $month, 'year' => $year, 'total' => 0]
                ]);
            }
        }
    }

    return $transactionsPerMonth;
}


    public function produkbibit2(Request $request)
    {

        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 2) {
            return redirect()->to('/pegawai');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }
        // Retrieve data produk
        $tblProduk = DB::table('tb_produk')->get();

        $data = [
            'menu' => 'bibit',
            'submenu' => 'pemilik',
            'dataproduk' => $tblProduk,
        ];

        return view('pemilik/produk', $data);
    }
    public function add_bibit(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 2) {
            return redirect()->to('/pegawai');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $data = [
            'menu'              =>  'bibit',
            'submenu'           =>  'pemilik',
        ];
        return view('pemilik.tambah_bibit', $data);
    }

    public function create_bibit(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 2) {
            return redirect()->to('/pegawai');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $getProdukById = DB::table('tb_produk')->orderBy('id_produk', 'DESC')->limit(1)->first();
        if ($getProdukById) {
            $urutan = (int) substr($getProdukById->kode_bibit, 3, 3);
            $urutan++;
            $huruf = "A";
            $kodeBarang = $huruf . sprintf("%03s", $urutan);
        } else {
            $kodeBarang = 'A001';
        }

        if ($request->image1) {
            $imageName = rand(1000, 9999) . time() . '.' . $request->image1->extension();
            $request->image1->move(public_path('images'), $imageName);
            $getCount_fromNama = DB::table('tb_produk')->where('nama_bibit', $request->nama)->count();
            if ($getCount_fromNama < 1) {
                DB::table('tb_produk')->insert([
                    'kode_bibit'        => $kodeBarang,
                    'produk_id_user'    => $request->session()->get('id'),
                    'nama_bibit'        => $request->nama,
                    'detail_bibit'      => $request->detail,
                    'harga_bibit'       => $request->harga,
                    'stok_bibit'        => $request->stok,
                    'gambar_bibit'      => $imageName,
                    'status_bibit'      => '1',
                    'created_produk'    => date('Y-m-d H:i:s'),
                ]);
                DB::table('tb_stok')->insert([
                    'stok_kode_barang'      => $kodeBarang,
                    'stok_jumlah'           => $request->stok,
                    'created_at'            => date('Y-m-d H:i:s'),
                ]);
            } else {
                $getData_fromNama = DB::table('tb_produk')->where('nama_bibit', $request->nama)->first();
                $getDataStok = DB::table('tb_stok')->where('stok_kode_barang', $getData_fromNama->kode_bibit)->first();
                DB::table('tb_produk')->insert([
                    'kode_bibit'        => $getData_fromNama->kode_bibit,
                    'produk_id_user'    => $request->session()->get('id'),
                    'nama_bibit'        => $request->nama,
                    'detail_bibit'      => $request->detail,
                    'harga_bibit'       => $request->harga,
                    'stok_bibit'        => $request->stok,
                    'gambar_bibit'      => $imageName,
                    'status_bibit'      => '1',
                    'created_produk'    => date('Y-m-d H:i:s'),
                ]);
                DB::table('tb_stok')->where('stok_kode_barang', $getData_fromNama->kode_bibit)->update([
                    'stok_jumlah'           => $getDataStok->stok_jumlah + $request->stok,
                    'updated_at'            => date('Y-m-d H:i:s'),
                ]);
            }
        } else {
            $getCount_fromNama = DB::table('tb_produk')->where('nama_bibit', $request->nama)->count();
            if ($getCount_fromNama < 1) {
                DB::table('tb_produk')->insert([
                    'kode_bibit'        => $kodeBarang,
                    'produk_id_user'    => $request->session()->get('id'),
                    'nama_bibit'        => $request->nama,
                    'detail_bibit'      => $request->detail,
                    'harga_bibit'       => $request->harga,
                    'stok_bibit'        => $request->stok,
                    'status_bibit'      => '1',
                    'created_produk'    => date('Y-m-d H:i:s'),
                ]);
                DB::table('tb_stok')->insert([
                    'stok_kode_barang'      => $kodeBarang,
                    'stok_jumlah'           => $request->stok,
                    'created_at'            => date('Y-m-d H:i:s'),
                ]);
            } else {
                $getData_fromNama = DB::table('tb_produk')->where('nama_bibit', $request->nama)->first();
                $getDataStok = DB::table('tb_stok')->where('stok_kode_barang', $getData_fromNama->kode_bibit)->first();
                DB::table('tb_produk')->insert([
                    'kode_bibit'        => $getData_fromNama->kode_bibit,
                    'produk_id_user'    => $request->session()->get('id'),
                    'nama_bibit'        => $request->nama,
                    'detail_bibit'      => $request->detail,
                    'harga_bibit'       => $request->harga,
                    'stok_bibit'        => $request->stok,
                    'status_bibit'      => '1',
                    'created_produk'    => date('Y-m-d H:i:s'),
                ]);
                DB::table('tb_stok')->where('stok_kode_barang', $getData_fromNama->kode_bibit)->update([
                    'stok_jumlah'           => $getDataStok->stok_jumlah + $request->stok,
                    'updated_at'            => date('Y-m-d H:i:s'),
                ]);
            }
        }
        return redirect()->to('/pemilik/bibit');
    }

    public function delete_bibit(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 2) {
            return redirect()->to('/pegawai');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $uri_one = request()->segment(4);
        $getProdukById = DB::table('tb_produk')->where('id_produk', $uri_one)->first();
        $getStokByKode = DB::table('tb_stok')->where('stok_kode_barang', $getProdukById->kode_bibit)->first();
        $numProdukInProduk = DB::table('tb_produk')->where('kode_bibit', $getProdukById->kode_bibit)->count();
        $numProdukInStok = DB::table('tb_stok')->where('stok_kode_barang', $getProdukById->kode_bibit)->count();

        DB::table('tb_produk')->where('id_produk', $uri_one)->delete();
        if ($numProdukInProduk == 1) {
            DB::table('tb_stok')->where('stok_kode_barang', $getProdukById->kode_bibit)->delete();
        }else {
            DB::table('tb_stok')->where('stok_kode_barang', $getProdukById->kode_bibit)->update([
                'stok_jumlah'           => $getStokByKode->stok_jumlah - $getProdukById->stok_bibit,
                'updated_at'            => date('Y-m-d H:i:s'),
            ]);
        }
        return redirect()->to('/pemilik/bibit');
    }

    public function edit_bibit(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 2) {
            return redirect()->to('/pegawai');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $uri_one = request()->segment(4);
        $tblProduk = DB::table('tb_produk')->where('id_produk', $uri_one)->first();
        $getuserpemilik = DB::table('tb_user')->where('role_user', '3')->get();

        $data = [
            'menu'              =>  'bibit',
            'submenu'           =>  'pemilik',
            'get_produk'        =>  $tblProduk,
            'getuserpemilik'    =>  $getuserpemilik,
        ];
        return view('pegawai/ubah_bibit', $data);
    }

    public function update_bibit(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 2) {
            return redirect()->to('/pegawai');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $uri_one = request()->segment(4);
        if ($request->image1) {
            $imageName = rand(1000, 9999) . time() . '.' . $request->image1->extension();
            $request->image1->move(public_path('images'), $imageName);

            $tblProduk = DB::table('tb_produk')->where('id_produk', $uri_one)->first();
            unlink(public_path('images/') . $tblProduk->gambar_bibit);
            DB::table('tb_produk')->where('id_produk', $uri_one)->update([
                'nama_bibit'        => $request->nama,
                'detail_bibit'      => $request->detail,
                'harga_bibit'       => $request->harga,
                'stok_bibit'        => $request->stok,
                'gambar_bibit'      => $imageName,
                'status_bibit'      => '1',
                'created_produk'    => date('Y-m-d H:i:s'),
            ]);
        } else {
            DB::table('tb_produk')->where('id_produk', $uri_one)->update([
                'nama_bibit'        => $request->nama,
                'detail_bibit'      => $request->detail,
                'harga_bibit'       => $request->harga,
                'stok_bibit'        => $request->stok,
                'status_bibit'      => '1',
                'created_produk'    => date('Y-m-d H:i:s'),
            ]);
        }
        return redirect()->to('/pemilik/bibit');
    }

    public function stokbibit(Request $request)
    {
        $session_role = $request->session()->get('role');
        if ($session_role == 1) {
            return redirect()->to('/admin');
        } elseif ($session_role == 2) {
            return redirect()->to('/pegawai');
        } elseif ($session_role == 4) {
            return redirect()->to('/');
        } elseif ($session_role == '') {
            return redirect()->to('/');
        }

        $tblStok = DB::table('tb_produk')->get();
        $data = [
            'menu'          =>  'stokbibit2',
            'submenu'       =>  'pemilik',
            'dataproduk'    =>  $tblStok,
        ];
        return view('pemilik/stokbibit', $data);
    }

    public function laporanpenjualan(Request $request)
    {
        // Ambil nilai filter dari request atau default ke null
        $start = $request->input('start', null);
        $end = $request->input('end', null);

        // Query untuk data laporan penjualan tanpa filter
        $query = DB::table('tb_transaksi as tk')
            ->select(
                'tk.kode_transaksi as kode_transaksi',
                'tb_produk.kode_bibit',
                'tb_produk.nama_bibit',
                'tk.total_transaksi as harga_beli',
                'tk.Qty_beli as terjual',
                'tk.created_transaksi as tanggal_transaksi'
            )
            ->join('tb_produk', 'tk.id_produk', '=', 'tb_produk.id_produk');

        // Terapkan filter jika ada input dari pengguna
        if ($start) {
            $query->whereDate('tk.created_transaksi', '>=', $start);
        }
        if ($end) {
            $query->whereDate('tk.created_transaksi', '<=', $end);
        }

        $laporanData = $query->paginate(10);

        // Definisikan variabel menu untuk navigasi
        $menu = 'laporanpenjualan';

        // Data yang akan dikirimkan ke view
        $data = [
            'menu' => $menu,
            'submenu' => 'pemilik',
            'data' => $laporanData,
            'start' => $start,
            'end' => $end,
        ];

        return view('pemilik.laporanpenjualan', $data);
    }



    public function laporanpenjualanborongan(Request $request)
    {
        // Get filter values from request or set to null if not present
   // Ambil nilai filter dari request atau default ke null
   $start = $request->input('start', null);
   $end = $request->input('end', null);

        // Start building the query
        $query = DB::table('tb_transaksi_borong as tb')
            ->select(
                'tb.kode_transaksi as kode_transaksi',
                'tb.nama_bibit as nama_bibit',
                'tb.total_transaksi as harga_beli',
                'tb.kuantitas_bibit as terjual',
                'tb.created_at as tanggal_transaksi'
            );
            if ($start) {
                $query->whereDate('tb.created_at', '>=', $start);
            }
            if ($end) {
                $query->whereDate('tb.created_at', '<=', $end);
            }


        // Get the paginated result
        $laporanData = $query->paginate(10);

        // Definisikan variabel menu untuk navigasi
        $menu = 'laporanpenjualan';

        // Data yang akan dikirimkan ke view
        $data = [
            'menu' => $menu,
            'submenu' => 'pemilik',
            'data' => $laporanData,
            'start' => $start,
            'end' => $end,
        ];

        return view('pemilik.laporanpenjualanborongan', $data);
    }

    public function terlaris(Request $request){
        $topSales = DB::table('tb_produk')
        ->orderBy('terjual_bibit', 'desc')
        ->take(10)
        ->get(['nama_bibit', 'terjual_bibit']);

        $menu='terlaris';
        $data = [
            'menu' => $menu,
            'submenu' => 'pemilik',
            'topSales' => $topSales,
        ];
        return view('pemilik.terlaris', $data);
    }

}

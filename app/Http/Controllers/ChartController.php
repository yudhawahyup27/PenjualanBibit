<?php

// app/Http/Controllers/ChartController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ChartController extends Controller
{
    public function index()
    {
        $menu = 'charts';
        return view('chart.index', compact('menu'));
    }

    public function getChartData(Request $request)
    {
        try {
            $year = $request->input('year', Carbon::now()->year);
            $month = $request->input('month', null);
            $day = $request->input('day', null);

            $query = DB::table('tb_transaksi');

            if ($year) {
                $query->whereYear('created_at', $year);
            }
            if ($month) {
                $query->whereMonth('created_at', $month);
            }
            if ($day) {
                $query->whereDay('created_at', $day);
            }

            $transactions = $query->get();

            return response()->json($transactions);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Server Error'], 500);
        }
    }
}

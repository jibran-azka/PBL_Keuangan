<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::where('user_id', auth()->id());

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
        } elseif ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_awal);
        } elseif ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }


        $transactions = $query->orderBy('tanggal', 'desc')->get();

        return view('laporan.index', compact('transactions'));
    }



    public function exportPdf(Request $request)
    {
        $query = Transaction::where('user_id', auth()->id());

        if ($request->filled('start_date')) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }

        $transactions = $query->orderBy('tanggal', 'desc')->get();

        $pdf = Pdf::loadView('laporan.pdf', compact('transactions'));

        return $pdf->download('laporan_transaksi.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new TransactionsExport($request), 'laporan_transaksi.xlsx');
    }
}

<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransactionsExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $query = Transaction::where('user_id', auth()->id());

        if ($this->request->filled('start_date')) {
            $query->whereDate('tanggal', '>=', $this->request->start_date);
        }

        if ($this->request->filled('end_date')) {
            $query->whereDate('tanggal', '<=', $this->request->end_date);
        }

        $transactions = $query->orderBy('tanggal', 'desc')->get();

        return view('laporan.excel', compact('transactions'));
    }
}

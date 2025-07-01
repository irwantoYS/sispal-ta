<?php

namespace App\Http\Controllers;

use App\Models\DcuRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class DcuController extends Controller
{
    public function create()
    {
        return view('driver.dcu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'shift' => 'required|in:Pagi,Malam',
            'sistolik' => 'required|integer',
            'diastolik' => 'required|integer',
            'nadi' => 'required|integer',
            'pernapasan' => 'required|integer',
            'spo2' => 'required|numeric',
            'suhu_tubuh' => 'required|numeric',
            'mata' => 'required|in:Normal,Tidak Normal',
            'kesimpulan' => 'required|in:Fit,Unfit',
        ]);

        DcuRecord::create([
            'user_id' => Auth::id(),
            'shift' => $request->shift,
            'sistolik' => $request->sistolik,
            'diastolik' => $request->diastolik,
            'nadi' => $request->nadi,
            'pernapasan' => $request->pernapasan,
            'spo2' => $request->spo2,
            'suhu_tubuh' => $request->suhu_tubuh,
            'mata' => $request->mata,
            'kesimpulan' => $request->kesimpulan,
        ]);

        return redirect()->route('driver.dcu.history')->with('success', 'Data DCU berhasil disimpan.');
    }

    public function historyDriver()
    {
        $dcurecords = DcuRecord::with('user')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('driver.dcu.history', compact('dcurecords'));
    }

    public function historyHsse()
    {
        $dcurecords = DcuRecord::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('hsse.dcu.history', compact('dcurecords'));
    }

    public function historyManagerArea()
    {
        $dcurecords = DcuRecord::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('managerarea.dcu.history', compact('dcurecords'));
    }

    public function generatePdf($id)
    {
        $dcu = DcuRecord::with('user')->findOrFail($id);
        $pdf = Pdf::loadView('pdf.dcu_report', compact('dcu'));
        $fileName = 'dcu-report-' . $dcu->user->nama . '-' . $dcu->created_at->format('Y-m-d') . '.pdf';
        return $pdf->download($fileName);
    }
}

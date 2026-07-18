<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use App\Models\Desa;
use App\Traits\UsesYearSql;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OpenSpout\Writer\XLSX\Writer;
use OpenSpout\Common\Entity\Row;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    use UsesYearSql;
    public function index(Request $request)
    {
        $desas = Desa::all();
        $tahuns = Sertifikat::selectRaw($this->yearSql() . ' as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $query = Sertifikat::with(['pemilik', 'jenis_hak', 'status', 'desa']);

        if ($request->filled('desa_id')) {
            $query->where('desa_id', $request->desa_id);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        if ($request->filled('luas_min')) {
            $query->where('luas', '>=', $request->luas_min);
        }

        if ($request->filled('luas_max')) {
            $query->where('luas', '<=', $request->luas_max);
        }

        if ($request->anyFilled(['desa_id', 'tahun', 'luas_min', 'luas_max'])) {
            $sertifikats = $query->orderBy('created_at', 'asc')->get();
        } else {
            $sertifikats = collect();
        }

        return view('admin.laporan.index', compact('desas', 'tahuns', 'sertifikats'));
    }

    public function exportPdf(Request $request)
    {
        $sertifikats = $this->getFilteredData($request);

        $pdf = Pdf::loadView('admin.laporan.pdf', [
            'sertifikats' => $sertifikats,
            'filters' => $request->only(['desa_id', 'tahun', 'luas_min', 'luas_max']),
            'desa' => $request->filled('desa_id') ? Desa::find($request->desa_id) : null,
        ]);

        return $pdf->download('laporan-aset-tanah-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request): StreamedResponse
    {
        $sertifikats = $this->getFilteredData($request);
        $filename = 'laporan-aset-tanah-' . now()->format('Y-m-d') . '.xlsx';

        return new StreamedResponse(function () use ($sertifikats) {
            $writer = new Writer();
            $writer->openToFile('php://output');

            $header = Row::fromValues([
                'No', 'Alas Hak / Bukti Kepemilikan', 'NIB', 'Luas (M²)',
                'Pemilik', 'Jenis Hak', 'Status', 'Dusun', 'Alamat', 'Tgl Input'
            ]);
            $writer->addRow($header);

            $no = 1;
            foreach ($sertifikats as $s) {
                $row = Row::fromValues([
                    $no++,
                    $s->nomor_sertifikat,
                    $s->nib ?? '-',
                    number_format($s->luas, 0, ',', '.'),
                    $s->pemilik->nama ?? '-',
                    $s->jenis_hak->nama ?? '-',
                    $s->status->nama ?? '-',
                    $s->desa->dusun ?? '-',
                    $s->alamat ?? '-',
                    $s->created_at->format('d/m/Y'),
                ]);
                $writer->addRow($row);
            }

            $writer->close();
        }, Response::HTTP_OK, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    private function getFilteredData(Request $request)
    {
        $query = Sertifikat::with(['pemilik', 'jenis_hak', 'status', 'desa']);

        if ($request->filled('desa_id')) {
            $query->where('desa_id', $request->desa_id);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        if ($request->filled('luas_min')) {
            $query->where('luas', '>=', $request->luas_min);
        }

        if ($request->filled('luas_max')) {
            $query->where('luas', '<=', $request->luas_max);
        }

        return $query->orderBy('created_at', 'asc')->get();
    }
}

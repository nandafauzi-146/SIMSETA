<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use App\Models\Desa;
use Illuminate\Support\Facades\Cache;
use App\Traits\UsesYearSql;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Border;
use OpenSpout\Common\Entity\Style\BorderName;
use OpenSpout\Common\Entity\Style\BorderPart;
use OpenSpout\Common\Entity\Style\BorderStyle;
use OpenSpout\Common\Entity\Style\BorderWidth;
use OpenSpout\Common\Entity\Style\CellAlignment;
use OpenSpout\Common\Entity\Style\CellVerticalAlignment;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Writer\XLSX\Writer;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    use UsesYearSql;

    public function index(Request $request)
    {
        $desas = Cache::remember('desas_all', 3600, function () {
            return Desa::all()->toArray();
        });
        $desas = collect($desas)->map(fn($d) => is_array($d) ? (object) $d : $d);
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

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('luas_min')) {
            $query->where('luas', '>=', $request->luas_min);
        }

        if ($request->filled('luas_max')) {
            $query->where('luas', '<=', $request->luas_max);
        }

        if ($request->anyFilled(['desa_id', 'tahun', 'kategori', 'luas_min', 'luas_max'])) {
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
            'filters' => $request->only(['desa_id', 'tahun', 'kategori', 'luas_min', 'luas_max']),
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

            $headerStyle = new Style(
                fontBold: true,
                fontSize: 12,
                fontColor: Color::WHITE,
                fontName: 'Calibri',
                backgroundColor: Color::rgb(46, 125, 50),
                cellAlignment: CellAlignment::CENTER,
                cellVerticalAlignment: CellVerticalAlignment::CENTER,
                border: new Border(
                    new BorderPart(BorderName::BOTTOM, Color::rgb(27, 94, 32), BorderWidth::MEDIUM, BorderStyle::SOLID),
                ),
            );

            $header = Row::fromValuesWithStyle([
                'No',
                'Kategori',
                'Alas Hak / Bukti Kepemilikan',
                'NIB',
                'Luas (M²)',
                'Pemilik',
                'Pemanfaatan',
                'Jenis Hak',
                'Status',
                'Dusun',
                'Alamat',
                'Tgl Input',
            ], $headerStyle, 30);
            $writer->addRow($header);

            $evenStyle = new Style(
                fontSize: 11,
                fontName: 'Calibri',
                fontColor: Color::rgb(31, 41, 55),
                backgroundColor: Color::WHITE,
                border: new Border(
                    new BorderPart(BorderName::BOTTOM, Color::rgb(226, 232, 240), BorderWidth::THIN, BorderStyle::SOLID),
                ),
            );

            $oddStyle = new Style(
                fontSize: 11,
                fontName: 'Calibri',
                fontColor: Color::rgb(31, 41, 55),
                backgroundColor: Color::rgb(248, 250, 252),
                border: new Border(
                    new BorderPart(BorderName::BOTTOM, Color::rgb(226, 232, 240), BorderWidth::THIN, BorderStyle::SOLID),
                ),
            );

            $no = 1;
            foreach ($sertifikats as $s) {
                $style = $no % 2 === 0 ? $evenStyle : $oddStyle;

                $row = Row::fromValuesWithStyle([
                    $no++,
                    $s->kategori_label,
                    $s->nomor_sertifikat,
                    $s->nib ?? '-',
                    number_format($s->luas, 0, ',', '.'),
                    $s->pemilik->nama ?? '-',
                    $s->status_pemanfaatan ?? '-',
                    $s->jenis_hak->nama ?? '-',
                    $s->status->nama ?? '-',
                    $s->desa->dusun ?? '-',
                    $s->alamat ?? '-',
                    $s->created_at->format('d/m/Y'),
                ], $style, 22);
                $writer->addRow($row);
            }

            $writer->close();
        }, Response::HTTP_OK, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
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

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
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

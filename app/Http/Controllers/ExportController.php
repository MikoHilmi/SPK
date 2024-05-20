<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Exports\SiswaExport;
use App\Exports\NilaiExport;
use App\Models\Siswa;
use App\Models\Periode;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportSiswa($periode_id)
    {
        $periode = Periode::find($periode_id);
        $tahun_ajaran = str_replace(['/', '\\'], '-', $periode->tahun_ajaran);
        $fileName = "siswa_" . $tahun_ajaran . ".xlsx";

        return Excel::download(new SiswaExport($periode_id), $fileName);
    }

    public function exportNilai($periode_id)
    {
        return Excel::download(new NilaiExport($periode_id), 'nilai.xlsx');
    }
}

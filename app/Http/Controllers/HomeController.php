<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Crips;
use App\Models\Kriteria;
use App\Models\Periode;
use App\Charts\JumlahSiswaChart;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    protected $jumlahSiswaChart;

    public function __construct(JumlahSiswaChart $jumlahSiswaChart)
    {
        $this->jumlahSiswaChart = $jumlahSiswaChart;
    }

    public function index()
    {

        $total_periode = Periode::all()->count();
        $total_siswa = Siswa::all()->count();
        $kriteria = Kriteria::all()->count();
        $crips = Crips::all()->count();
        $jumlahSiswaChart = $this->jumlahSiswaChart->jumlahSiswa();

        $periodes = Periode::orderBy('tahun_ajaran', 'desc')->get();
        $siswaTerbaik = [];

        foreach ($periodes as $periode) {
            $nilaiSiswa = DB::table('penilaians')
                ->join('siswas', 'penilaians.siswa_id', '=', 'siswas.id')
                ->join('crips', 'penilaians.crips_id', '=', 'crips.id')
                ->where('penilaians.periode_id', $periode->id)
                ->select('siswas.id', 'siswas.name', 'siswas.nis', DB::raw('SUM(crips.bobot) as total_nilai'))
                ->groupBy('siswas.id', 'siswas.name', 'siswas.nis')
                ->orderByDesc('total_nilai')
                ->first();

            if ($nilaiSiswa) {
                $siswaTerbaik[$periode->tahun_ajaran] = [
                    'name' => $nilaiSiswa->name,
                    'nis' => $nilaiSiswa->nis,
                    'total_nilai' => $nilaiSiswa->total_nilai,
                ];
            }
        }

        return view('home', compact(
            'total_periode',
            'total_siswa',
            'kriteria',
            'crips',
            'jumlahSiswaChart',
            'siswaTerbaik'
        ));
    }
}

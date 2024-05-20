<?php

namespace App\Exports;

use App\Models\Siswa;
use App\Models\Kriteria;
use App\Models\Periode;
use App\Models\Penilaian;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;

class NilaiExport implements FromView, ShouldAutoSize
{
    protected $periode_id;

    public function __construct($periode_id)
    {
        $this->periode_id = $periode_id;
    }

    public function view(): View
    {
        $periode = Periode::find($this->periode_id);
        $siswa = Siswa::with('penilaian.crips')->where('periode_id', $this->periode_id)->get();
        $kriteria = Kriteria::with('crips')->orderBy('name', 'ASC')->get();
        $penilaian = Penilaian::with('crips', 'siswa')->get();

        // get min max
        $minMax = [];

        foreach ($kriteria as $keyKriteria => $valueKriteria) {
            foreach ($penilaian as $keyPenilaian => $valuePenilaian) {
                if ($valueKriteria->id == $valuePenilaian->crips->kriteria_id) {
                    if ($valueKriteria->attribute == 'Benefit') {
                        $minMax[$valuePenilaian->crips->kriteria_id][] = $valuePenilaian->crips->bobot;
                    } elseif ($valueKriteria->attribute == 'Cost') {
                        $minMax[$valuePenilaian->crips->kriteria_id][] = $valuePenilaian->crips->bobot;
                    }
                }
            }
        }

        // get normalisasi
        $normalisasi = [];

        foreach ($siswa as $keySiswa => $valueSiswa) {
            foreach ($penilaian as $keyPenilaian => $valuePenilaian) {
                foreach ($kriteria as $keyKriteria => $valueKriteria) {
                    if ($valueKriteria->id == $valuePenilaian->crips->kriteria_id && $valueSiswa->id == $valuePenilaian->siswa_id) {
                        if ($valueKriteria->attribute == 'Benefit') {
                            $normalisasi[$valueSiswa->name][$valueKriteria->id] = $valuePenilaian->crips->bobot / max($minMax[$valuePenilaian->crips->kriteria_id]);
                        } elseif ($valueKriteria->attribute == 'Cost') {
                            $normalisasi[$valueSiswa->name][$valueKriteria->id] = min($minMax[$valuePenilaian->crips->kriteria_id]) / $valuePenilaian->crips->bobot;
                        }
                    }
                }
            }
        }

        $rank = [];
        $ranking = [];

        // perangkingan
        foreach ($normalisasi as $keyNormalisasi => $valueNormalisasi) {
            foreach ($kriteria as $keyKriteria => $valueKriteria) {
                $kriteriaId = $valueKriteria->id;

                if (isset($valueNormalisasi[$kriteriaId])) {
                    $rank[$keyNormalisasi][] = $valueNormalisasi[$kriteriaId] * $valueKriteria->bobot;
                }
            }
        }

        $ranking = $normalisasi;

        foreach ($normalisasi as $keyNormalisasi => $valueNormalisasi) {
            $ranking[$keyNormalisasi][] = array_sum($rank[$keyNormalisasi]);
        }

        arsort($ranking);

        return view('exports.nilai', [
            'ranking' => $ranking,
            'periode' => $periode,
            'kriteria' => $kriteria,
            'siswa' => $siswa,
        ]);
    }
}

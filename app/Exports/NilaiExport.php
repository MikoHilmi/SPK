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
        $jumlah_siswa = Siswa::count();

        // Perangkingan
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

        // Sort the ranking by total scores in descending order
        uasort($ranking, function ($a, $b) {
            return end($b) <=> end($a);
        });

        // Calculate the number of students for each performance status
        $jumlah_sangat_baik = intval($jumlah_siswa * 0.2);
        $jumlah_baik = intval($jumlah_siswa * 0.4);
        $jumlah_cukup = $jumlah_siswa - ($jumlah_sangat_baik + $jumlah_baik);

        $performanceStatus = [];
        $counter = 0;

        foreach ($ranking as $student => $values) {
            $totalScore = end($values); // Get the total score

            // Determine status based on rank
            if ($counter < $jumlah_sangat_baik) {
                $status = 'Sangat Baik';
            } elseif ($counter < ($jumlah_sangat_baik + $jumlah_baik)) {
                $status = 'Baik';
            } else {
                $status = 'Cukup';
            }

            // Save status to the student record
            $siswaRecord = Siswa::where('name', $student)->first();
            if ($siswaRecord) {
                $siswaRecord->status = $status;
                $siswaRecord->save();
            }

            // Store performance status for view
            $performanceStatus[$student] = $status;

            $counter++;
        }

        return view('exports.nilai', [
            'ranking' => $ranking,
            'periode' => $periode,
            'kriteria' => $kriteria,
            'siswa' => $siswa,
        ]);
    }
}

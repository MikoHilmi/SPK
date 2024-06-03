<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kriteria;
use App\Models\Periode;
use App\Models\Penilaian;
use App\Models\Crips;
use Illuminate\Support\Facades\DB;

class AlgoritmaController extends Controller
{
    public function tes($id)
    {
        $periode = Periode::find($id);
        $siswa = Siswa::with('penilaian.crips')->where('periode_id', $id)->get();
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

        foreach ($penilaian as $keyPenilaian => $valuePenilaian) {
            foreach ($kriteria as $keyKriteria => $valueKriteria) {
                if ($valueKriteria->id == $valuePenilaian->crips->kriteria_id) {
                    if ($valueKriteria->attribute == 'Benefit') {
                        $normalisasi[$valuePenilaian->siswa->name][$valueKriteria->id] = $valuePenilaian->crips->bobot / max($minMax[$valuePenilaian->crips->kriteria_id]);
                    } elseif ($valueKriteria->attribute == 'Cost') {
                        $normalisasi[$valuePenilaian->siswa->name][$valueKriteria->id] = min($minMax[$valuePenilaian->crips->kriteria_id]) / $valuePenilaian->crips->bobot;
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

        // dd($siswa);

        return view('penilaian.result', compact('siswa', 'kriteria', 'periode', 'normalisasi', 'ranking'));
    }

    public function index($id)
    {
        $periode = Periode::find($id);
        $siswa = Siswa::with('penilaian.crips')->where('periode_id', $id)->get();
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

        foreach ($penilaian as $keyPenilaian => $valuePenilaian) {
            foreach ($kriteria as $keyKriteria => $valueKriteria) {
                if ($valueKriteria->id == $valuePenilaian->crips->kriteria_id) {
                    if ($valueKriteria->attribute == 'Benefit') {
                        $normalisasi[$valuePenilaian->siswa->name][$valueKriteria->id] = $valuePenilaian->crips->bobot / max($minMax[$valuePenilaian->crips->kriteria_id]);
                    } elseif ($valueKriteria->attribute == 'Cost') {
                        $normalisasi[$valuePenilaian->siswa->name][$valueKriteria->id] = min($minMax[$valuePenilaian->crips->kriteria_id]) / $valuePenilaian->crips->bobot;
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

            // Save status and total score to the student record
            $siswaRecord = Siswa::where('name', $student)->first();
            if ($siswaRecord) {
                $siswaRecord->status = $status;
                $siswaRecord->total_nilai = $totalScore; // Save the total score
                $siswaRecord->save();
            }

            // Store performance status for view
            $performanceStatus[$student] = $status;

            $counter++;
        }

        return view('penilaian.result', compact('siswa', 'kriteria', 'periode', 'normalisasi', 'ranking', 'performanceStatus'));
    }
}

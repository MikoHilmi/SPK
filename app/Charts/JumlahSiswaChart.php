<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Periode;
use Illuminate\Support\Facades\DB;

class JumlahSiswaChart
{
    protected $jumlahSiswaChart;

    public function __construct(LarapexChart $jumlahSiswaChart)
    {
        $this->jumlahSiswaChart = $jumlahSiswaChart;
    }

    public function jumlahSiswa(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $data = Periode::leftJoin('siswas', 'periodes.id', '=', 'siswas.periode_id')
            ->select('periodes.tahun_ajaran', DB::raw('count(siswas.id) as total_siswa'))
            ->groupBy('periodes.tahun_ajaran')
            ->orderBy('tahun_ajaran', 'asc')
            ->get();

        $labels = $data->pluck('tahun_ajaran')->toArray();
        $values = $data->pluck('total_siswa')->toArray();

        return $this->jumlahSiswaChart->barChart()
            ->setHeight(300)
            ->setDataLabels(true)
            ->setGrid()
            ->setColors(['#0054a6'])
            ->setXAxis($labels)
            ->addData('Total Siswa', $values);
    }
}

<?php

namespace App\Exports;

use App\Models\Siswa;
use App\Models\Periode;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;

class SiswaExport implements FromView, ShouldAutoSize
{
    protected $periode_id;

    public function __construct($periode_id)
    {
        $this->periode_id = $periode_id;
    }

    public function view(): View
    {
        $periode = Periode::find($this->periode_id); // Gantilah ini dengan model periode yang sesuai
        $data = Siswa::where('periode_id', $this->periode_id)->get();

        return view('exports.siswa', [
            'data' => $data,
            'periode' => $periode,
        ]);
    }
}

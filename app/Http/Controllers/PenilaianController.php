<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Repository\PermissionRepository;
use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\Siswa;
use App\Models\Kriteria;
use App\Models\Periode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    protected $permission;

    public function __construct(PermissionRepository $permission)
    {
        $this->permission = $permission;
    }

    public function index()
    {
        if ($this->permission->cekAkses(Auth::user()->id, "Data Penilaian Siswa", "view") !== true) {
            return view('error.403');
        }

        $periode = Periode::orderBy('tahun_ajaran', 'DESC')->get();

        return view('penilaian.list', compact('periode'));
    }

    public function detail($id)
    {
        $periode = Periode::find($id);
        $siswa = Siswa::with('penilaian.crips')->where('periode_id', $id)->get();
        $kriteria = Kriteria::with(['crips' => function ($query) {
            $query->orderBy('bobot', 'DESC');
        }])->orderBy('name', 'ASC')->get();

        return view('penilaian.detail', compact('siswa', 'kriteria', 'periode'));
    }

    public function store(Request $request)
    {
        try {
            $periodeId = $request->periode_id;
            $siswa = Siswa::where('periode_id', $periodeId)->get();
            $hasErrors = false;

            DB::table('penilaians')->where('periode_id', $periodeId)->delete();

            foreach ($siswa as $siswaItem) {
                foreach ($request->crips_id[$siswaItem->id] as $kriteriaId => $cripsId) {
                    if (empty($cripsId)) {
                        $hasErrors = true;
                    }

                    Penilaian::create([
                        'periode_id' => $periodeId,
                        'siswa_id' => $siswaItem->id,
                        'kriteria_id' => $kriteriaId,
                        'crips_id' => $cripsId,
                    ]);
                }
            }

            if ($hasErrors) {
                Toast('Pastikan semua nilai telah diisi.', 'error');
                return redirect()->back();
            }

            Toast('Nilai berhasil disimpan, Pergi ke menu Hasil Kalkulasi untuk melihat hasil.', 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toast('Terdapat nilai yang belum diisi.', 'info');
            return redirect()->back();
        }
    }
}

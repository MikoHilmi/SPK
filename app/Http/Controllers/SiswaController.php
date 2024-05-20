<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Repository\SiswaRepository;
use App\Http\Repository\PeriodeRepository;
use App\Http\Repository\PermissionRepository;
use App\Models\Siswa;
use App\Models\Periode;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    protected $siswa, $periode, $permission;

    public function __construct(SiswaRepository $siswa, PeriodeRepository $periode, PermissionRepository $permission)
    {
        $this->siswa = $siswa;
        $this->periode = $periode;
        $this->permission = $permission;
    }

    public function index(Request $request)
    {
        if ($this->permission->cekAkses(Auth::user()->id, "Siswa", "view") !== true) {
            return view('error.403');
        }

        $periode = Periode::orderBy('tahun_ajaran', 'DESC')->get();

        return view('siswa.index', compact('periode'));
    }

    public function list($id)
    {
        $periode = Periode::find($id);
        $data = Siswa::where('periode_id', $id)->orderBy('nis', 'ASC')->get();
        $dataPeriode = Periode::orderBy('tahun_ajaran', 'DESC')->get();

        return view('siswa.list', compact('periode', 'dataPeriode', 'data'));
    }

    public function store(Request $request)
    {
        $this->siswa->store($request);

        try {
            Siswa::create($request->all());

            Alert::success('Success', 'Berhasil tambah data');
            return redirect()->back();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail data',
            'data' => $this->siswa->detail_siswa($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->siswa->update($request, $id);

        $siswa = Siswa::find($id);

        $siswa->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Berhasil diperbarui',
        ]);
    }

    public function destroy($id)
    {
        $data = Siswa::find($id);

        $data->delete();

        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => 'Berhasil dihapus'
        ]);
    }

    public function downloadTemplate()
    {
        $filePath = public_path('/files/template_siswa.xlsx');

        $fileName = 'template_siswa.xlsx';

        return response()->download($filePath, $fileName);
    }
}

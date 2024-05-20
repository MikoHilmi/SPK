<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Repository\PeriodeRepository;
use App\Http\Repository\PermissionRepository;
use App\Models\Periode;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class PeriodeController extends Controller
{
    protected $periode, $permission;

    public function __construct(PeriodeRepository $periode, PermissionRepository $permission)
    {
        $this->periode = $periode;
        $this->permission = $permission;
    }

    public function index()
    {
        if ($this->permission->cekAkses(Auth::user()->id, "Periode", "view") !== true) {
            return view('error.403');
        }

        $data = $this->periode->periode();

        return view('periode.list', compact('data'));
    }

    public function store(Request $request)
    {
        $this->periode->store($request);

        try {
            Periode::create($request->all());

            Alert::success('Success', 'Berhasil ditambahkan.');
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
            'data' => $this->periode->detail_periode($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->periode->update($request, $id);

        $periode = Periode::find($id);

        $periode->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Berhasil diperbarui',
        ]);
    }

    public function destroy($id)
    {
        $data = Periode::findOrFail($id);

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil dihapus',
        ]);
    }
}

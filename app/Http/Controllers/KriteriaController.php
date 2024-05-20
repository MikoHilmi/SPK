<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Repository\KriteriaRepository;
use App\Http\Repository\PermissionRepository;
use Illuminate\Support\Facades\Validator;
use App\Models\kriteria;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class KriteriaController extends Controller
{
    protected $kriteria, $permission;

    public function __construct(KriteriaRepository $kriteria, PermissionRepository $permission)
    {

        $this->kriteria = $kriteria;
        $this->permission = $permission;
    }

    public function index()
    {
        if ($this->permission->cekAkses(Auth::user()->id, "Kriteria", "view") !== true) {
            return view('error.403');
        }
        $data = $this->kriteria->kriteria();

        return view('kriteria.list', compact('data'));
    }

    public function store(Request $request)
    {
        $this->kriteria->store($request);

        try {
            Kriteria::create($request->all());

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
            'data' => $this->kriteria->detail_kriteria($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->kriteria->update($request, $id);

        $kriteria = Kriteria::find($id);

        $kriteria->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Berhasil diperbarui',
        ]);
    }

    public function destroy($id)
    {
        $data = Kriteria::findOrFail($id);

        $data->delete();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil dihapus'
        ]);
    }
}

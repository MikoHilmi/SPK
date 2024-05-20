<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Repository\CripsRepository;
use App\Http\Repository\KriteriaRepository;
use App\Http\Repository\PermissionRepository;
use App\Models\Crips;
use App\Models\Kriteria;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CripsController extends Controller
{
    protected $crips, $kriteria, $permission;

    public function __construct(CripsRepository $crips, KriteriaRepository $kriteria, PermissionRepository $permission)
    {
        $this->crips = $crips;
        $this->kriteria = $kriteria;
        $this->permission = $permission;
    }

    public function index(Request $request)
    {
        if ($this->permission->cekAkses(Auth::user()->id, "Sub Kriteria", "view") !== true) {
            return view('error.403');
        }

        $kriteria = Kriteria::get();
        $data = Crips::orderBy('bobot', 'DESC')->get();

        return view('crips.list', compact('data', 'kriteria'));
    }

    public function store(Request $request)
    {
        $data = $this->crips->store($request);

        try {
            $data = Crips::create($request->all());

            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Berhasil ditambahkan'
            ]);
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
            'data' => $this->crips->detail_crips($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->crips->update($request, $id);

        $crips = Crips::find($id);

        $crips->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Berhasil diperbarui',
        ]);
    }

    public function destroy($id)
    {
        $data = Crips::find($id);

        $data->delete();

        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => 'Berhasil dihapus'
        ]);
    }
}

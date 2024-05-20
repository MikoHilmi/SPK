<?php

namespace App\Http\Repository;

use Illuminate\Support\Facades\Auth;
use App\Models\Crips;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CripsRepository
{

    protected $crips;

    public function __construct(Crips $con)
    {
        $this->crips = $con;
    }

    public function crips()
    {
        return DB::table('cripss')->get();
    }

    public function detail_crips($id)
    {
        return DB::table('crips')->where('id', $id)->first();
    }

    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'kriteria_id' => 'required|exists:kriterias,id',
            'name' => 'required',
            'bobot' => 'required'
        ]);

        if ($data->fails()) {
            return response()->json([
                'message' => 'Terjadi kesalahan dalam validasi data.',
                'errors' => $data->errors()
            ], 400);
        }
    }

    public function update($request, $id)
    {
        $request->validate([
            'kriteria_id' => 'required|exists:kriterias,id',
            'name' => 'required',
            'bobot' => 'required'
        ]);
    }
}

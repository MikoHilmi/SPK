<?php

namespace App\Http\Repository;

use Illuminate\Support\Facades\Auth;
use App\Models\Kriteria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class KriteriaRepository
{

    protected $kriteria;

    public function __construct(Kriteria $con)
    {
        $this->kriteria = $con;
    }

    public function kriteria()
    {
        return DB::table('kriterias')->get();
    }

    public function detail_kriteria($id)
    {
        return DB::table('kriterias')->where('id', $id)->first();
    }

    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'attribute' => 'required',
            'bobot' => 'required|integer'
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
            'name' => 'required',
            'attribute' => 'required',
            'bobot' => 'required'
        ]);
    }
}

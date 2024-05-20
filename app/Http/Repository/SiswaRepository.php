<?php

namespace App\Http\Repository;

use App\Models\Siswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SiswaRepository
{

    protected $siswa;

    public function __construct(Siswa $con)
    {
        $this->siswa = $con;
    }

    public function siswa()
    {
        return DB::table('siswas')->get();
    }

    public function detail_siswa($id)
    {
        return DB::table('siswas')->where('id', $id)->first();
    }

    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'nis' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki - laki,Perempuan',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required',
            'alamat' => 'required|string|max:255',
            'periode_id' => 'required|exists:periodes,id',
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
            'nis' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki - laki,Perempuan',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required',
            'alamat' => 'required|string|max:255',
            'periode_id' => 'required|exists:periodes,id',
        ]);
    }
}

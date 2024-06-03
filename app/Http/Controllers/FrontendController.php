<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        return view('cek-siswa');
    }

    public function cekNilaiSiswa(Request $request)
    {
        $request->validate([
            'nis' => 'required'
        ]);

        $nis = $request->input('nis');

        $student = Siswa::where('nis', '=', $nis)->first();

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $studentData = Siswa::where('nis', '=', $nis)->first();

        return response()->json(['student' => $studentData]);
    }
}

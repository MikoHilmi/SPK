<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Imports\SiswaImport;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ImportController extends Controller
{
    public function importSiswa(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xls,xlsx',
        ]);

        if ($request->file('file')->isValid()) {
            $file = $request->file('file');
            $path = $file->storeAs('public/files', $file->getClientOriginalName());

            Excel::import(new SiswaImport, storage_path('app/' . $path));

            Alert::success('Success', 'Import data siswa berhasil');
            return redirect()->back();
        }

        Alert::error('Error', 'Gagal import data siswa');
        return redirect()->back();
    }
}

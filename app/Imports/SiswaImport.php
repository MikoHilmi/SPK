<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Periode;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $nis = $row['nis'];

        // Cek apakah siswa dengan NIS tersebut sudah ada
        $existingSiswa = Siswa::where('nis', $nis)->first();

        if ($existingSiswa) {
            // Jika sudah ada, update data siswa yang sudah ada
            $existingSiswa->update([
                'name' => $row['nama_siswa'],
                'jenis_kelamin' => $row['jenis_kelamin'],
                'tempat_lahir' => $row['tempat_lahir'],
                'tanggal_lahir' => \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir'])),
                'alamat' => $row['alamat'],
            ]);

            return null; // Kembalikan null untuk mengabaikan data yang sudah ada
        } else {
            // Jika siswa belum ada, buat objek Siswa baru
            $periode = Periode::where('tahun_ajaran', $row['periode'])->first();

            return new Siswa([
                'nis' => $nis,
                'name' => $row['nama_siswa'],
                'periode_id' => optional($periode)->id,
                'jenis_kelamin' => $row['jenis_kelamin'],
                'tempat_lahir' => $row['tempat_lahir'],
                'tanggal_lahir' => \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir'])),
                'alamat' => $row['alamat'],
            ]);
        }
    }
}

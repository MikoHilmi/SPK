<table>
    <tr>
        <td><b>Data Siswa Periode {{ $periode->tahun_ajaran }}</b></td>
    </tr>
</table>
<table border="1">
    <thead>
        <tr>
            <th style="text-align: center; background-color: #40c668;"><b>No</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>NIS</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Nama Siswa</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Periode</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Jenis Kelamin</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Tempat, Tanggal Lahir</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Alamat</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->nis }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $periode->tahun_ajaran }}</td>
                <td>{{ $item->jenis_kelamin }}</td>
                <td>{{ $item->tempat_lahir }}, {{ $item->tanggal_lahir }}</td>
                <td>{{ $item->alamat }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

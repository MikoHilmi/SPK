<table>
    <tr>
        <td><b>Data Nilai Siswa Periode {{ $periode->tahun_ajaran }}</b></td>
    </tr>
</table>
<table border="2">
    <thead>
        <tr>
            <th style="text-align: center; background-color: #40c668;"><b>Nama Siswa</b></th>
            @foreach ($kriteria as $kriteriaItem)
                <th style="text-align: center; background-color: #40c668;"><b>{{ $kriteriaItem->name }}</b></th>
            @endforeach
            <th rowspan="2" style="text-align: center; vertical-align: middle;  background-color: #40c668;"><b>Total
                    Nilai</b></th>
            <th rowspan="2" style="text-align: center; vertical-align: middle; background-color: #40c668;">
                <b>Ranking</b>
            </th>
        </tr>
        <tr>
            <th style="text-align: center; background-color: #40c668;"><b>Bobot</b></th>
            @foreach ($kriteria as $kriteriaItem)
                <th style="text-align: center; background-color: #40c668;"><b>{{ $kriteriaItem->bobot }}</b></th>
            @endforeach
        </tr>
    </thead>
    <tbody>
                                                    @php
                                                        $siswa_sorted = $siswa->where('periode_id', $periode->id)->map(function($siswa) use ($ranking) {
                                                            $total = array_sum($ranking[$siswa->name] ?? []);
                                                            return ['siswa' => $siswa, 'total' => $total];
                                                        })->sortByDesc('total');

                                                        $rank = 1;
                                                        $prevTotal = null;
                                                    @endphp
                                                    @forelse ($siswa_sorted as $data)
                                                        <tr>
                                                            <td>{{ $data['siswa']->name }}</td>
                                                            @foreach ($ranking[$data['siswa']->name] ?? [] as $value)
                                                                <td>
                                                                    <span class="fw-bold">{{ number_format($value, 2) }}</span>
                                                                </td>
                                                            @endforeach
                                                            <!-- <td class="text-center align-middle">
                                                                <span class="fw-bold">{{ number_format($data['total'], 2) }}</span>
                                                            </td> -->
                                                            @php
                                                                if ($prevTotal !== null && $data['total'] != $prevTotal) {
                                                                    $rank++;
                                                                }
                                                                $prevTotal = $data['total'];
                                                            @endphp
                                                            <td class="text-center align-middle">
                                                                <span class="fw-bold rank">{{ $rank }}</span>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="100%">Tidak ada data siswa yang tersedia.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
</table>

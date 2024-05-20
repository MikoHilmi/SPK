@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Hasil kalkulasi Penilaian Periode <span
                                class="text-danger fw-bold ms-2">{{ $periode->tahun_ajaran }}</span>
                        </h2>
                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('penilaian.index') }}">Data Penilaian</a></li>
                            <li class="breadcrumb-item active">Hasil Kalkulasi Periode {{ $periode->tahun_ajaran }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <div class="row row-deck row-cards">
                    {{-- Data Nilai --}}
                    <div class="col-sm-12">
                        <div class="card card-borderless shadow-sm">
                            <div class="p-4" id="nilai">
                                <div class="accordion-item">
                                    <h1 class="accordion-header" id="heading-1">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-1" aria-expanded="true">
                                            Data Nilai
                                        </button>
                                    </h1>
                                    <div id="collapse-1" class="accordion-collapse collapse hide" data-bs-parent="#nilai">
                                        <div class="accordion-body pt-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-vcenter"
                                                    id="datatables_nilai">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-dark">Nama Siswa</th>
                                                            @foreach ($kriteria as $kriteriaItem)
                                                                <th>{{ $kriteriaItem->name }}</th>
                                                            @endforeach
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($siswa->where('periode_id', $periode->id) as $siswaItem)
                                                            <tr>
                                                                <td style="width: 250px">{{ $siswaItem->name }}</td>
                                                                @if (count($siswaItem->penilaian) > 0)
                                                                    @foreach ($kriteria as $kriteriaItem)
                                                                        <td style="width: 100px">
                                                                            <div
                                                                                id="crips_{{ $siswaItem->id }}_{{ $kriteriaItem->id }}">
                                                                                @php
                                                                                    $siswaCripsIds = $siswaItem->penilaian
                                                                                        ->pluck('crips_id')
                                                                                        ->toArray();
                                                                                    $cripsFound = false;
                                                                                @endphp
                                                                                @foreach ($kriteriaItem->crips as $cripsItem)
                                                                                    @if (in_array($cripsItem->id, $siswaCripsIds))
                                                                                        <span
                                                                                            class="fw-bold">{{ $cripsItem->bobot }}</span>
                                                                                        @php
                                                                                            $cripsFound = true;
                                                                                        @endphp
                                                                                    @endif
                                                                                @endforeach
                                                                                @if (!$cripsFound)
                                                                                    <span
                                                                                        class="text-danger fw-bold">N/A</span>
                                                                                @endif
                                                                            </div>
                                                                        </td>
                                                                    @endforeach
                                                                @else
                                                                    @foreach ($kriteria as $kriteriaItem)
                                                                        <td style="width: 100px">
                                                                            <span class="text-danger fw-bold">N/A</span>
                                                                        </td>
                                                                    @endforeach
                                                                @endif
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="{{ count($kriteria) + 1 }}">Tidak ada data
                                                                    siswa yang tersedia.</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Data Normalisasi --}}
                    <div class="col-sm-12">
                        <div class="card card-borderless shadow-sm">
                            <div class="p-4" id="normalisasi">
                                <div class="accordion-item">
                                    <h1 class="accordion-header" id="heading-2">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-2" aria-expanded="true">
                                            Data Normalisasi
                                        </button>
                                    </h1>
                                    <div id="collapse-2" class="accordion-collapse collapse hide"
                                        data-bs-parent="#normalisasi">
                                        <div class="accordion-body pt-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-vcenter"
                                                    id="datatables_normalisasi">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-dark">Nama Siswa</th>
                                                            @foreach ($kriteria as $kriteriaItem)
                                                                <th>{{ $kriteriaItem->name }}</th>
                                                            @endforeach
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($siswa->where('periode_id', $periode->id) as $siswaItem)
                                                            <tr>
                                                                <td style="width: 250px">{{ $siswaItem->name }}</td>
                                                                @if (count($siswaItem->penilaian) > 0)
                                                                    @foreach ($kriteria as $kriteriaItem)
                                                                        <td style="width: 100px">
                                                                            <div
                                                                                id="crips_{{ $siswaItem->id }}_{{ $kriteriaItem->id }}">
                                                                                @if (isset($normalisasi[$siswaItem->name][$kriteriaItem->id]))
                                                                                    <span
                                                                                        class="fw-bold">{{ $normalisasi[$siswaItem->name][$kriteriaItem->id] }}</span>
                                                                                @else
                                                                                    <span
                                                                                        class="text-danger fw-bold">N/A</span>
                                                                                @endif
                                                                            </div>
                                                                        </td>
                                                                    @endforeach
                                                                @else
                                                                    @foreach ($kriteria as $kriteriaItem)
                                                                        <td style="width: 100px">
                                                                            <span class="text-danger fw-bold">N/A</span>
                                                                        </td>
                                                                    @endforeach
                                                                @endif
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="{{ count($kriteria) + 1 }}">Tidak ada data
                                                                    siswa yang tersedia.</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Data Rank --}}
                    <div class="col-sm-12">
                        <div class="card card-borderless shadow-sm">
                            <div class="p-4" id="rank">
                                <div class="accordion-item">
                                    <h1 class="accordion-header" id="heading-2">
                                        <button class="accordion-button " type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-3" aria-expanded="true">
                                            Data Perangkingan
                                        </button>
                                    </h1>
                                    <div id="collapse-3" class="accordion-collapse collapse show" data-bs-parent="#rank">
                                        <div class="accordion-body pt-0">
                                            <div class="row mb-4 p-2">
                                                <a href="{{ route('nilai.export', ['periode_id' => $periode->id]) }}"
                                                    class="btn btn-success d-sm-inline-block fw-bold">Export Nilai .xlsx</a>
                                            </div>
                                            <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="text-dark">Nama Siswa</th>
                                                        @foreach ($kriteria as $kriteriaItem)
                                                            <th class="text-dark">{{ $kriteriaItem->name }}</th>
                                                        @endforeach
                                                        <th class="text-dark text-center align-middle" style="width: 100px">
                                                            Total
                                                        </th>
                                                        <th class="text-dark text-center align-middle" style="width: 100px">
                                                            Ranking
                                                        </th>
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
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customJs')
    <script>
        $(document).ready(function() {
            $('#datatables_nilai').DataTable();
        })

        $(document).ready(function() {
            $('#datatables_normalisasi').DataTable();
        })

        $(document).ready(function() {
            $('#datatables_rank').DataTable();
        })
    </script>
@endsection

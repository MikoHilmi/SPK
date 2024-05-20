@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Data Penilaian
                        </h2>
                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Data Penilaian</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <div class="">
                    <p class="text-secondary">Menampilkan data penilaian siswa berdasarkan periode / tahun ajaran</p>
                </div>
                <div class="row row-deck row-cards">
                    <div class="col-sm-12">
                        <div class="card card-borderless shadow-sm">
                            <div class="card-body table-responsive">
                                <div class="table-responsive">
                                    <table class="table table-hover table-vcenter" id="datatables">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Periode</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($periode as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td style="width: 500px">Penilaian Siswa Terbaik Periode <span
                                                            class="text-danger fw-bold">{{ $item->tahun_ajaran }}</span>
                                                    </td>
                                                    <td class="">
                                                        @if (NavHelper::cekAkses(Auth::user()->id, 'Data Penilaian Siswa', 'add') == true)
                                                            <a href="{{ route('penilaian.detail', ['id' => $item->id]) }}">
                                                                <button type="button" class="btn btn-outline-primary"
                                                                    title="Form Nilai">Input Data Nilai <i
                                                                        class="bi bi-pencil ms-2"></i></button>
                                                            </a>
                                                        @endif
                                                        <a href="{{ route('kalkulasi.index', ['id' => $item->id]) }}">
                                                            <button type="button" class="btn btn-outline-success"
                                                                title="Hasil Perhitungan">Hasil Kalkulasi <i
                                                                    class="bi bi-eye ms-2"></i></button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
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
@endsection

@section('customJs')
    <script></script>
@endsection

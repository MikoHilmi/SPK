@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Dashboard
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <div class="row row-deck row-cards">
                    <div class="col-12">
                        <div class="row row-cards">
                            <div class="col-md-6 col-lg-3">
                                <div class="card card-borderless bg-primary text-primary-fg">
                                    <div class="card-stamp">
                                        <div class="card-stamp-icon bg-white text-primary">
                                            <i class="bi bi-calendar"></i>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title">Data Periode</h3>
                                        <p>{{ $total_periode }} Periode</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="card card-borderless bg-green text-green-fg">
                                    <div class="card-stamp">
                                        <div class="card-stamp-icon bg-white text-green">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title">Data Siswa</h3>
                                        <p>{{ $total_siswa }} Siswa</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="card card-borderless bg-red text-red-fg">
                                    <div class="card-stamp">
                                        <div class="card-stamp-icon bg-white text-red">
                                            <i class="bi bi-award"></i>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title">Data Kriteria</h3>
                                        <p>{{ $kriteria }} Data</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="card card-borderless bg-cyan text-cyan-fg">
                                    <div class="card-stamp">
                                        <div class="card-stamp-icon bg-white text-cyan">
                                            <i class="bi bi-123"></i>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title">Data Sub Kriteria</h3>
                                        <p>{{ $crips }} Data</p>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-lg-6">
                                <div class="card card-borderless" style="height: 30rem">
                                    <div class="card-body card-body-scrollable card-body-scrollable-shadow">
                                        <h3 class="card-title">Siswa terbaik berdasarkan periode</h3>
                                        <div class="table-responsive">
                                            <table class="table" id="datatables">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Periode</th>
                                                        <th>Nama Siswa</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($siswaTerbaik as $tahun_ajaran => $siswa)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>
                                                                <span class="status status-info">
                                                                    {{ $tahun_ajaran }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                {{ $siswa['name'] }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-lg-12">
                                <div class="card card-borderless">
                                    <div class="card-body">
                                        <h3 class="card-title">Jumlah siswa ditampilkan dalam masing-masing periode
                                        </h3>
                                        <div id="chart">
                                            {!! $jumlahSiswaChart->container() !!}
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
    <script src="{{ $jumlahSiswaChart->cdn() }}"></script>
    {{ $jumlahSiswaChart->script() }}
@endsection

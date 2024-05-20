@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Form Penilaian Siswa Periode <span
                                class="text-danger fw-bold ms-2">{{ $periode->tahun_ajaran }}</span>
                        </h2>
                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('penilaian.index') }}">Data Penilaian</a></li>
                            <li class="breadcrumb-item active">Form Penilaian Periode {{ $periode->tahun_ajaran }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <div class="row row-deck row-cards">
                    <div class="col-sm-12">
                        <div class="card card-borderless shadow-sm">
                            <div class="card-body table-responsive">
                                <div class="table-responsive">
                                    <table class="table table-hover table-vcenter" id="">
                                        <thead>
                                            <tr>
                                                <th class="text-dark">Nama Siswa</th>
                                                @foreach ($kriteria as $kriteriaItem)
                                                    <th>{{ $kriteriaItem->name }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <form action="{{ route('penilaian.store') }}" method="POST" name="nilai"
                                            id="nilai">
                                            <tbody>
                                                @csrf
                                                @forelse ($siswa->where('periode_id', $periode->id) as $siswaItem)
                                                    <tr>
                                                        <input type="hidden" value="{{ $siswaItem->id }}"
                                                            name="siswa_id[]">
                                                        <td style="width: 250px">{{ $siswaItem->name }}</td>
                                                        @if (count($siswaItem->penilaian) > 0)
                                                            @foreach ($kriteria as $kriteriaItem)
                                                                <td style="width: 100px">
                                                                    <select class="form-select"
                                                                        name="crips_id[{{ $siswaItem->id }}][{{ $kriteriaItem->id }}]"
                                                                        id="crips_{{ $siswaItem->id }}_{{ $kriteriaItem->id }}">
                                                                        <option>---</option>
                                                                        @foreach ($kriteriaItem->crips as $cripsItem)
                                                                            <option value="{{ $cripsItem->id }}"
                                                                                {{ in_array($cripsItem->id, $siswaItem->penilaian->pluck('crips_id')->toArray()) ? 'selected' : '' }}>
                                                                                {{ $cripsItem->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                            @endforeach
                                                        @else
                                                            @foreach ($kriteria as $kriteriaItem)
                                                                <td style="width: 100px">
                                                                    <select class="form-select"
                                                                        name="crips_id[{{ $siswaItem->id }}][{{ $kriteriaItem->id }}]"
                                                                        id="crips_{{ $siswaItem->id }}_{{ $kriteriaItem->id }}">
                                                                        <option>---</option>
                                                                        @foreach ($kriteriaItem->crips as $cripsItem)
                                                                            <option value="{{ $cripsItem->id }}">
                                                                                {{ $cripsItem->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                            @endforeach
                                                        @endif
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="{{ count($kriteria) + 1 }}">Tidak ada data siswa yang
                                                            tersedia.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="100%">
                                                        <button type="submit" class="btn btn-primary fw-bold w-100"
                                                            name="periode_id" value="{{ $periode->id }}"
                                                            id="submit-button">Simpan</button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </form>
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
    <script>
        // $(document).ready(function() {
        //     $('#submit-button').click(function() {
        //         let button = $(this);

        //         if (button) {
        //             message("Data berhasil disimpan", true);
        //         }
        //     });
        // });
    </script>
@endsection

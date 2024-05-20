@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Data Siswa Periode <span class="text-danger fw-bold ms-2">{{ $periode->tahun_ajaran }}</span>
                        </h2>
                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('siswa.index') }}">Data Siswa</a>
                            </li>
                            <li class="breadcrumb-item active">Data Siswa Periode {{ $periode->tahun_ajaran }}</li>
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
                            <div class="card-header">
                                <div class="card-actions">
                                    @if (NavHelper::cekAkses(Auth::user()->id, 'Siswa', 'add') == true)
                                        <button type="button" class="btn btn-primary d-sm-inline-block fw-bold"
                                            data-bs-toggle="modal" data-bs-target="#modal_add">Tambah Data Siswa</button>
                                    @endif
                                    <!-- <button class="btn btn-yellow fw-bold" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">Import Siswa
                                    </button>
                                    <ul class="dropdown-menu p-3">
                                        <form action="{{ route('import-siswa') }}" enctype="multipart/form-data"
                                            method="POST">
                                            @csrf
                                            <li>
                                                <a href="{{ route('siswa.download-template') }}"
                                                    class="btn btn-outline-primary form-control fw-bold mb-2">
                                                    Download Template
                                                </a>
                                            </li>
                                            <li>
                                                <label for="file"><code class="fw-bold text-danger">Upload
                                                        File</code></label>
                                                <input type="file" name="file" id="file"
                                                    class="form-control mb-2">
                                            </li>
                                            <li>
                                                <button type="submit"
                                                    class="btn btn-outline-primary form-control fw-bold">Upload</button>
                                            </li>
                                        </form>
                                    </ul> -->
                                    <a href="{{ route('siswa.export', ['periode_id' => $periode->id]) }}"
                                        class="btn btn-success d-sm-inline-block p-2 fw-bold">
                                        Export Siswa .xlsx
                                    </a>
                                </div>
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table table-hover card-table table-vcenter" id="datatables">
                                    <thead>
                                        <tr>
                                            <th>Aksi</th>
                                            <th>NIS</th>
                                            <th>Nama</th>
                                            <th>Periode</th>
                                            <th>L/K</th>
                                            <th>TTL</th>
                                            <th>Alamat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data->where('periode_id', $periode->id) as $item)
                                            <tr>
                                                <td>
                                                    <span class="dropdown">
                                                        <span class="btn btn-primary btn-sm btn-icon rounded-pill"
                                                            style="cursor: pointer" title="Aksi"
                                                            data-bs-boundary="viewport" data-bs-toggle="dropdown">
                                                            <i class="bi bi-gear"></i>
                                                        </span>
                                                        <div class="dropdown-menu">
                                                            @if (NavHelper::cekAkses(Auth::user()->id, 'Siswa', 'edit') == true)
                                                                <button href="javascript:void(0)" id="edit"
                                                                    data-url="{{ route('siswa.detail', ['id' => $item->id]) }}"
                                                                    data-item-id="{{ $item->id }}"
                                                                    class="dropdown-item fw-bold">
                                                                    <i class="bi bi-pencil me-2"></i>Edit
                                                                </button>
                                                            @endif
                                                            @if (NavHelper::cekAkses(Auth::user()->id, 'Siswa', 'delete') == true)
                                                                <button onclick="deletes({{ $item->id }})"
                                                                    class="dropdown-item fw-bold">
                                                                    <i class="bi bi-trash me-2"></i>Hapus
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </span>
                                                </td>
                                                <td><span class="text-muted">{{ $item->nis }}</span></td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->periode->tahun_ajaran }}</td>
                                                <td>{{ $item->jenis_kelamin }}</td>
                                                <td>{{ $item->tempat_lahir }},<br>{{ $item->tanggal_lahir }}</td>
                                                <td>{{ $item->alamat }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @include('siswa.edit')
                                @include('siswa.create')
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

            $(document).on('click', '#edit', function() {
                let url = $(this).data('url');
                $('#modal_edit').modal('show');

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            $('#id').val(response.data.id);
                            $('#nis').val(response.data.nis);
                            $('#name').val(response.data.name);
                            $('#periode_id option[value="' + response.data.periode_id + '"]')
                                .prop('selected', true);
                            $('#jenis_kelamin').val(response.data.jenis_kelamin);
                            $('#tempat_lahir').val(response.data.tempat_lahir);
                            $('#tanggal_lahir').val(response.data.tanggal_lahir);
                            $('#alamat').val(response.data.alamat);
                        }
                    }
                });
            });

            $('#modal_edit').submit(function(event) {
                event.preventDefault();

                let csrfToken = $('meta[name="csrf-token"]').attr('content');
                let id = $('#id').val();
                let url = '{{ route('siswa.update', 'ID') }}';
                let newUrl = url.replace('ID', id);
                console.log(id);
                let formData = {
                    '_token': csrfToken,
                    'id': id,
                    'nis': $('#nis').val(),
                    'name': $('#name').val(),
                    'periode_id': $('#periode_id').val(),
                    'jenis_kelamin': $('#jenis_kelamin').val(),
                    'tempat_lahir': $('#tempat_lahir').val(),
                    'tanggal_lahir': $('#tanggal_lahir').val(),
                    'alamat': $('#alamat').val(),
                };

                $.ajax({
                    type: 'POST',
                    url: newUrl,
                    data: formData,
                    dataType: 'json',
                    success: function(results) {
                        if (results.success === true) {
                            swal.fire("Done!", results.message, "success");
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else {
                            swal.fire("Error!", results.message, "error");
                        }
                    }
                });
            });
        });

        function deletes(id) {
            let url = '{{ route('siswa.delete', 'ID') }}';
            let newUrl = url.replace('ID', id);

            Swal.fire({
                title: 'Yakin hapus data ini?',
                text: "Anda tidak dapat mengembalikannya setelah dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: newUrl,
                        type: 'delete',
                        data: {},
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(results) {
                            if (results.success === true) {
                                swal.fire("Done!", results.message, "success");
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            } else {
                                swal.fire("Error!", results.message, "error");
                            }
                        }
                    });
                }
            });
        }
    </script>
@endsection

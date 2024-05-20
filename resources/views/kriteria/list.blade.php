@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Data Kriteria
                        </h2>
                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Data Kriteria</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <div class="">
                    <p class="text-secondary">Menampilkan data kriteria sebagai penilaian siswa</p>
                </div>
                <div class="row row-cards">
                    <div class="col-lg-5 col-md-5">
                        <div class="card card-borderless shadow-sm">
                            <div class="card-header">
                                <h3 class="card-title">Tambah data Kriteria</h3>
                            </div>
                            <div class="card-body">
                                @include('kriteria.edit')
                                <form method="POST" action="{{ route('kriteria.store') }}" enctype="multipart/form-data"
                                    id="create" name="create">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="name"
                                            class="col-sm-3 col-form-label text-secondary fw-semibold">Kriteria</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="name" id="name" class="form-control"
                                                placeholder="Inputkan kriteria" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="attribute"
                                            class="col-sm-3 col-form-label text-secondary fw-semibold">Attribute</label>
                                        <div class="col-sm-9">
                                            <select id="attribute" name="attribute" class="form-select"
                                                aria-label="Default select example" required>
                                                <option value="">Pilih attribute</option>
                                                <option value="Benefit">Benefit</option>
                                                <option value="Cost">Cost</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="bobot"
                                            class="col-sm-3 col-form-label text-secondary fw-semibold">Bobot</label>
                                        <div class="col-sm-9">
                                            <input type="number" name="bobot" id="bobot" class="form-control"
                                                placeholder="Inputkan bobot" required>
                                        </div>
                                    </div>
                                    @if (NavHelper::cekAkses(Auth::user()->id, 'Kriteria', 'add') == true)
                                        <button type="submit" value="Simpan"
                                            class="btn btn-primary float-end d-sm-inline-block fw-bold">Buat</button>
                                    @endif
                                </form>
                            </div>
                        </div>
                        <div class="p-2">
                            <p class="text-danger fst-italic">Benefit : Kriteria yang mengutamakan
                                nilai tertinggi sebagai acuan penilaian</p>
                            <p class="text-danger fst-italic">Cost : Kriteria yang mengutamakan nilai terendah sebagai acuan
                                penilaian</p>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7">
                        <div class="card card-borderless shadow-sm">
                            <div class="card-header">
                                <h3 class="card-title">Data Kriteria</h3>
                            </div>
                            <div class="card-body table-responsive">
                                <!-- Default Table -->
                                <table class="table table-hover table-vcenter" id="datatables">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kriteria</th>
                                            <th>Attribute</th>
                                            <th>Bobot</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->attribute }}</td>
                                                <td>{{ $item->bobot }}</td>
                                                <td>
                                                    @if (NavHelper::cekAkses(Auth::user()->id, 'Kriteria', 'edit') == true)
                                                        <button value="{{ $item->id }}" type="button"
                                                            class="btn btn-primary btn-icon" id="edit"
                                                            data-bs-toggle="modal" data-bs-target="#modal_edit"><i
                                                                class="bi bi-pencil" title="Edit"></i></button>
                                                    @endif
                                                    @if (NavHelper::cekAkses(Auth::user()->id, 'kriteria', 'delete') == true)
                                                        <button onclick="deletes({{ $item->id }})" type="button"
                                                            class="btn btn-danger btn-icon"><i class="bi bi-trash3"
                                                                title="Hapus"></i></button>
                                                    @endif
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
@endsection

@section('customJs')
    <script>
        $(document).ready(function() {

            $(document).on('click', '#edit', function() {
                let id = $(this).val();
                $('#modal_edit').modal('show');

                $.ajax({
                    url: 'kriteria/' + id,
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            $('#id').val(response.data.id);
                            $('#name').val(response.data.name);
                            $('#attribute').val(response.data.attribute);
                            $('#bobot').val(response.data.bobot);
                        }
                    }
                });
            });

            $('#modal_edit').submit(function(event) {
                event.preventDefault();

                let csrfToken = $('meta[name="csrf-token"]').attr('content');
                let id = $('#id').val();
                let formData = {
                    '_token': csrfToken,
                    'id': id,
                    'name': $('#name').val(),
                    'attribute': $('#attribute').val(),
                    'bobot': $('#bobot').val(),
                };

                $.ajax({
                    type: 'PUT',
                    url: 'kriteria/' + id,
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
            let url = '{{ route('kriteria.delete', 'ID') }}';
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
                            swal.fire("Done!", results.message, "success");
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    });
                }
            });
        }
    </script>
@endsection

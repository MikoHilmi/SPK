@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Data Periode
                        </h2>
                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Data Periode</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <div class="">
                    <p class="text-secondary">Menampilkan data periode atau tahun ajaran pada setiap semester</p>
                </div>
                <div class="row row-cards">
                    <div class="col-lg-5 col-md-5">
                        <div class="card card-borderless shadow-sm">
                            <div class="card-header">
                                <h3 class="card-title">Tambah data periode</h3>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('periode.store') }}" enctype="multipart/form-data"
                                    id="create" name="create">
                                    @csrf
                                    <div class="row mb-5">
                                        <label for="tahun_ajaran"
                                            class="col-sm-3 col-form-label text-secondary fw-semibold">Tahun</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="tahun_ajaran" id="tahun_ajaran" class="form-control"
                                                placeholder="Inputkan tahun" required>
                                        </div>
                                    </div>
                                    @if (NavHelper::cekAkses(Auth::user()->id, 'Periode', 'add') == true)
                                        <button type="submit" value="Simpan"
                                            class="btn btn-primary float-end d-sm-inline-block fw-bold">Buat</button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7">
                        <div class="card card-borderless shadow-sm">
                            <div class="card-header">
                                <h3 class="card-title">Data periode</h3>
                            </div>
                            <div class="card-body table-responsive">
                                <!-- Default Table -->
                                <table class="table table-hover table-vcenter" id="datatables">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tahun</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->tahun_ajaran }}</td>
                                                <td>
                                                    @if (NavHelper::cekAkses(Auth::user()->id, 'Periode', 'edit') == true)
                                                        <button value="{{ $item->id }}" type="button"
                                                            class="btn btn-primary btn-icon" id="edit"
                                                            data-bs-toggle="modal" data-bs-target="#modal_edit"><i
                                                                class="bi bi-pencil" title="Edit"></i></button>
                                                    @endif
                                                    @if (NavHelper::cekAkses(Auth::user()->id, 'Periode', 'delete') == true)
                                                        <button onclick="deletes({{ $item->id }})" type="button"
                                                            class="btn btn-danger btn-icon"><i class="bi bi-trash3"
                                                                title="Hapus"></i></button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @include('periode.edit')
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
        document.addEventListener('DOMContentLoaded', function() {
            var theme = document.body.getAttribute('data-bs-theme');
            var h2Element = document.getAttribute('h2');

            if (theme === 'dark') {
                // If the theme is dark, set the text color to light
                h2Element.classList.remove('text-white');
                h2Element.classList.add('text-light');
            }
        });

        $(document).ready(function() {
            $(document).on('click', '#edit', function() {
                let id = $(this).val();
                $('#modal_edit').modal('show');

                $.ajax({
                    url: 'periode/' + id,
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            $('#id').val(response.data.id);
                            $('#edit_tahun').val(response.data.tahun_ajaran);
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
                    'tahun_ajaran': $('#edit_tahun').val(),
                };

                $.ajax({
                    type: 'PUT',
                    url: 'periode/' + id,
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
            let url = '{{ route('periode.delete', 'ID') }}';
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

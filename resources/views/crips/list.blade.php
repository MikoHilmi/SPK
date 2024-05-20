@extends('layouts.app')
@section('content')
    @include('crips.edit')
    @include('crips.create')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Data Sub Kriteria
                        </h2>
                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Data Sub Kriteria</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <div class="row row-cards">
                    @foreach ($kriteria as $kriteria)
                        <div class="col-lg-6 col-md-12">
                            <div class="card card-borderless mb-2 shadow-sm">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col">
                                            <h3 class="card-title">Kriteria : <span
                                                    class="text-danger fw-bold">{{ $kriteria->name }}</span></h3>
                                            <h4 class="card-title h4">Attribute : <span
                                                    class="text-danger fw-bold">{{ $kriteria->attribute }}</span></h4>
                                        </div>
                                    </div>
                                    <div class="card-actions">
                                        @if (NavHelper::cekAkses(Auth::user()->id, 'Sub Kriteria', 'add') == true)
                                            <button data-kriteria-id="{{ $kriteria->id }}" type="button"
                                                class="btn btn-primary d-sm-inline-block fw-bold" data-bs-toggle="modal"
                                                data-bs-target="#modal_add">Tambah Data</button>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <table class="table table-hover table-vcenter">
                                        <thead>
                                            <tr>
                                                <!-- <th>No</th> -->
                                                <th>Sub Kriteria</th>
                                                <th>Bobot</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $item)
                                                @if ($item->kriteria_id === $kriteria->id)
                                                    <tr>
                                                        <!-- <td>{{ $item->id }}</td> -->
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->bobot }}</td>
                                                        <td>
                                                            @if (NavHelper::cekAkses(Auth::user()->id, 'Sub Kriteria', 'edit') == true)
                                                                <button value="{{ $item->id }}" type="button"
                                                                    class="btn btn-primary btn-icon" id="edit"
                                                                    data-bs-toggle="modal" data-bs-target="#modal_edit"><i
                                                                        class="bi bi-pencil" title="Edit"></i></button>
                                                            @endif
                                                            @if (NavHelper::cekAkses(Auth::user()->id, 'Sub Kriteria', 'delete') == true)
                                                                <button onclick="deletes({{ $item->id }})"
                                                                    type="button" class="btn btn-danger btn-icon"><i
                                                                        class="bi bi-trash3" title="Hapus"></i></button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customJs')
    <script>
        document.querySelectorAll('button[data-kriteria-id]').forEach(button => {
            button.addEventListener('click', function() {
                const kriteriaId = this.getAttribute('data-kriteria-id');
                const select = document.getElementById('kriteria');
                select.value = kriteriaId;
                // console.log(kriteriaId);

                $(document).ready(function() {
                    $('#create').submit(function(event) {
                        event.preventDefault();

                        let csrfToken = $('meta[name="csrf-token"]').attr('content');
                        const formData = $(this).serializeArray();

                        formData.push({
                            name: 'kriteria_id',
                            value: kriteriaId
                        });

                        $.ajax({
                            type: 'POST',
                            url: '{{ route('crips.store') }}',
                            data: formData,
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            success: function(results) {
                                swal.fire("Done!", results.message,
                                    "success");
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            }
                        });
                    });
                });
            });
        });

        $(document).on('click', '#edit', function() {
            let id = $(this).val();
            $('#modal_edit').modal('show');

            $.ajax({
                url: 'crips/' + id,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        $('#id').val(response.data.id);
                        $('#name').val(response.data.name);
                        $('#bobot').val(response.data.bobot);
                        $('#kriteria_id').val(response.data.kriteria_id);
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
                'bobot': $('#bobot').val(),
                'kriteria_id': $('#kriteria_id').val(),
            };

            $.ajax({
                type: 'PUT',
                url: 'crips/' + id,
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

        function deletes(id) {
            let url = '{{ route('crips.delete', 'ID') }}';
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

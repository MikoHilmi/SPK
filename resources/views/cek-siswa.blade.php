<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>{{ $title->title }}</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ asset('uploads/aplikasi/' . $favicon->favicon) }}" />
    <!-- Bootstrap Icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic"
        rel="stylesheet" type="text/css" />
    <!-- SimpleLightbox plugin CSS-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('frontend/styles.css') }}" rel="stylesheet" />
</head>

<style>
    header.masthead {
        padding-top: 10rem;
        padding-bottom: calc(10rem - 4.5rem);
        background: linear-gradient(to bottom, rgba(92, 77, 66, 0.8) 0%, rgba(92, 77, 66, 0.8) 100%),
            url("{{ asset('frontend/bg-masthead.jpg') }}");
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: scroll;
        background-size: cover;
    }
</style>

<body id="page-top">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-2" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="">{{ $title->title }}</a>
        </div>
    </nav>
    <header class="masthead">
        <div class="container px-4 px-lg-5">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-8 align-self-end">
                    <div class="alert alert-success" id="result_container" style="display: none;">
                        <h5 class="text-center">Hasil akademik siswa</h5>
                        <table class="table table-responsive mt-3">
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td id="nama_siswa"></td>
                            </tr>
                            <tr>
                                <td>NIS</td>
                                <td>:</td>
                                <td id="nis"></td>
                            </tr>
                            <tr>
                                <td>Total Nilai</td>
                                <td>:</td>
                                <td id="total_nilai"></td>
                            </tr>
                        </table>
                        <h5 class="text-center fw-bold" id="status"></h5>
                    </div>
                </div>
            </div>
            <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8 align-self-end">
                    <h1 class="text-white font-weight-bold">Cek akademik siswa</h1>
                    <hr class="divider" />
                </div>
                <div class="col-lg-8 align-self-baseline">
                    <p class="text-white-75 mb-4">Inputkan Nomor Induk Siswa</p>
                    <div class="form-group">
                        <input type="text" id="nis_input" class="form-control" placeholder="Masukkan NIS siswa">
                        <button id="fetch_data_btn" class="btn btn-primary btn-xl mt-4">Periksa</button>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <footer class="bg-light py-5">
        <div class="container px-4 px-lg-5">
            <div class="small text-center text-muted">{{ $footer->footer }}</div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
    <script src="{{ asset('frontend/scripts.js') }}"></script>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            function fetchStudentData(nis) {
                $.ajax({
                    url: '/cek-nilai-siswa',
                    type: 'GET',
                    data: {
                        nis: nis
                    },
                    success: function(response) {
                        if (response.student) {
                            $('#nama_siswa').text(response.student.name);
                            $('#nis').text(response.student.nis);
                            $('#status').text(response.student
                                .status);
                            $('#total_nilai').text(response.student.total_nilai);
                            $('#result_container').show();
                        } else {
                            $('#nama_siswa').text('Data tidak ditemukan');
                            $('#nis').text('Data tidak ditemukan');
                            $('#total_nilai').text('Data tidak ditemukan');
                            $('#status').text('');
                            $('#result_container').show();
                        }
                    },
                    error: function() {
                        $('#nama_siswa').text('Data tidak ditemukan');
                        $('#nis').text('Data tidak ditemukan');
                        $('#total_nilai').text('Data tidak ditemukan');
                        $('#status').text('');
                        $('#result_container').show();
                    }
                });
            }

            $('#fetch_data_btn').click(function() {
                const nis = $('#nis_input').val();
                if (nis) {
                    fetchStudentData(nis);
                } else {
                    alert('Masukkan NIS siswa.');
                }
            });
        });
    </script>
</body>

</html>

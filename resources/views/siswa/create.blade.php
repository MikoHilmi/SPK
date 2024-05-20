<div class="modal modal-lg modal-blur fade" id="modal_add" tabindex="-2">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('siswa.store') }}" enctype="multipart/form-data" id="create"
                name="create">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Data Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="periode_id" id="periode_id" class="form-control" required
                        value="{{ $periode->id }}" readonly>
                    <div class="row mb-3">
                        <label for="nis" class="col-sm-3 col-form-label text-secondary fw-semibold">NIS</label>
                        <div class="col-sm-9">
                            <input type="text" name="nis" id="nis" class="form-control" required
                                placeholder="Inputkan NIS">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-3 col-form-label text-secondary fw-semibold">Nama
                            Lengkap</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" id="name" class="form-control" required
                                placeholder="Inputkan nama lengkap siswa">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="jenis_kelamin" class="col-sm-3 col-form-label text-secondary fw-semibold">Jenis
                            Kelamin</label>
                        <div class="col-sm-9">
                            <select id="jenis_kelamin" name="jenis_kelamin" class="form-select"
                                aria-label="Default select example">
                                <option value="">Jenis Kelamin</option>
                                <option value="Laki - laki">Laki - laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="tempat_lahir" class="col-sm-3 col-form-label text-secondary fw-semibold">Tempat
                            Lahir</label>
                        <div class="col-sm-9">
                            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required
                                placeholder="Inputkan tempat lahir">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="tanggal_lahir" class="col-sm-3 col-form-label text-secondary fw-semibold">Tanggal
                            Lahir</label>
                        <div class="col-sm-9">
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required
                                placeholder="Inputkan tanggal lahir">
                        </div>
                    </div>
                    <div class="row">
                        <label for="alamat" class="col-sm-3 col-form-label text-secondary fw-semibold">Alamat</label>
                        <div class="col-sm-9">
                            <textarea type="text" name="alamat" id="alamat" class="form-control" required placeholder="Inputkan alamat"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary d-sm-inline-block fw-bold"
                        data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary d-sm-inline-block fw-bold">Buat</button>
                </div>
            </form>
        </div>
    </div>
</div>

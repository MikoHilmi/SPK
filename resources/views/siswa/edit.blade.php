<div class="modal modal-lg modal-blur fade" id="modal_edit" tabindex="-2">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="" enctype="multipart/form-data" id="edit" name="edit">
                @csrf
                <input type="hidden" id="id" name="id">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Data Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="nis" class="col-sm-3 col-form-label text-secondary fw-semibold">NIS</label>
                        <div class="col-sm-9">
                            <input type="text" name="nis" id="nis" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-3 col-form-label text-secondary fw-semibold">Nama Lengkap</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="periode" class="col-sm-3 col-form-label text-secondary fw-semibold">Periode</label>
                        <div class="col-sm-9">
                            <select id="periode_id" name="periode_id" class="form-select" aria-label="Default select example" disabled>
                                @foreach ($dataPeriode as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == $item->periode_id ? 'selected' : '' }}>{{ $item->tahun_ajaran }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>    
                    <div class="row mb-3">
                        <label for="jenis_kelamin" class="col-sm-3 col-form-label text-secondary fw-semibold">Jenis Kelamin</label>
                        <div class="col-sm-9">
                            <select id="jenis_kelamin" name="jenis_kelamin" class="form-select" aria-label="Default select example">
                                <option value="Laki - laki" {{ $item->jenis_kelamin === 'Laki - laki' ? 'selected' : '' }}>Laki - laki</option>
                                <option value="Perempuan" {{ $item->jenis_kelamin === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>                    
                    <div class="row mb-3">
                        <label for="tempat_lahir"
                            class="col-sm-3 col-form-label text-secondary fw-semibold">Tempat Lahir</label>
                        <div class="col-sm-9">
                            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="tanggal_lahir"
                            class="col-sm-3 col-form-label text-secondary fw-semibold">Tanggal Lahir</label>
                        <div class="col-sm-9">
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <label for="alamat"
                            class="col-sm-3 col-form-label text-secondary fw-semibold">Alamat</label>
                        <div class="col-sm-9">
                            <textarea type="text" name="alamat" id="alamat" class="form-control" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary d-sm-inline-block fw-bold"
                        data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary d-sm-inline-block fw-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
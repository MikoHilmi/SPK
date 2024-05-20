<div class="modal modal-blur fade" id="modal_edit" tabindex="-2">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="" action="" enctype="multipart/form-data" id="edit" name="edit">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="row mb-3">
                        <label for="edit_tahun" class="col-sm-3 col-form-label text-secondary fw-semibold">Tahun</label>
                        <div class="col-sm-9">
                            <input type="text" name="edit_tahun" id="edit_tahun" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary d-sm-inline-block fw-bold"
                        data-bs-dismiss="modal">Batal</button>
                    <button type="submit" value="Simpan"
                        class="btn btn-primary d-sm-inline-block fw-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
                        <label for="name"
                            class="col-sm-3 col-form-label text-secondary fw-semibold">Kriteria</label>
                        <div class="col-sm-9">
                            <select id="kriteria_id" name="kriteria_id" class="form-select"
                                aria-label="Default select example" disabled>
                                @foreach ($kriteria as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $item->id == $item->kriteria_id ? 'selected' : '' }}>{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="crips" class="col-sm-3 col-form-label text-secondary fw-semibold">Sub
                            Kriteria</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="bobot" class="col-sm-3 col-form-label text-secondary fw-semibold">Bobot</label>
                        <div class="col-sm-9">
                            <input type="number" name="bobot" id="bobot" class="form-control" required>
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

<div class="modal fade" id="fuzzyCategoryEditModal" tabindex="-1" aria-labelledby="fuzzyCategoryEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="fuzzyCategoryEditLabel">Edit Kategori Fuzzy</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="fuzzy-category-edit-form" action="" method="post">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="id" id="id_fuzzy_category_edit">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nama_kategori_edit" name="nama_kategori" required>
                                <label for="nama_kategori_edit">Nama Kategori</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="label_edit" name="label" required>
                                <label for="label_edit">Label</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="number" step="0.01" min="0" max="1" class="form-control" id="min_value_edit" name="min_value" required>
                                <label for="min_value_edit">Nilai Minimum</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="number" step="0.01" min="0" max="1" class="form-control" id="max_value_edit" name="max_value" required>
                                <label for="max_value_edit">Nilai Maksimum</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="color_edit" name="color" required>
                                    <option value="">Pilih Warna</option>
                                    <option value="primary">Primary (Biru)</option>
                                    <option value="success">Success (Hijau)</option>
                                    <option value="warning">Warning (Kuning)</option>
                                    <option value="danger">Danger (Merah)</option>
                                    <option value="info">Info (Biru Muda)</option>
                                    <option value="secondary">Secondary (Abu-abu)</option>
                                </select>
                                <label for="color_edit">Warna Badge</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active_edit" name="is_active" value="1">
                                <label class="form-check-label" for="is_active_edit">
                                    Aktif
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="fuzzy-category-edit-form">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="fuzzyCategoryCreateModal" tabindex="-1" aria-labelledby="fuzzyCategoryCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="fuzzyCategoryCreateLabel">Tambah Kategori Fuzzy</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="fuzzy-category-create-form" action="{{ route('fuzzy-categories.store') }}" method="post">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nama_kategori_create" name="nama_kategori" required>
                                <label for="nama_kategori_create">Nama Kategori</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="label_create" name="label" required>
                                <label for="label_create">Label</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="number" step="0.01" min="0" max="1" class="form-control" id="min_value_create" name="min_value" required>
                                <label for="min_value_create">Nilai Minimum</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="number" step="0.01" min="0" max="1" class="form-control" id="max_value_create" name="max_value" required>
                                <label for="max_value_create">Nilai Maksimum</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="color_create" name="color" required>
                                    <option value="">Pilih Warna</option>
                                    <option value="primary">Primary (Biru)</option>
                                    <option value="success">Success (Hijau)</option>
                                    <option value="warning">Warning (Kuning)</option>
                                    <option value="danger">Danger (Merah)</option>
                                    <option value="info">Info (Biru Muda)</option>
                                    <option value="secondary">Secondary (Abu-abu)</option>
                                </select>
                                <label for="color_create">Warna Badge</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active_create" name="is_active" value="1" checked>
                                <label class="form-check-label" for="is_active_create">
                                    Aktif
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="fuzzy-category-create-form">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteFuzzyCategoryModal" tabindex="-1" aria-labelledby="deleteFuzzyCategoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteFuzzyCategoryLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah yakin ingin menghapus kategori <strong id="deleteFuzzyCategoryName">-</strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btnConfirmDeleteFuzzyCategory">Hapus</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

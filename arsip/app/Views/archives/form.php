<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<h1 class="h4 mb-3"><?= $archive ? 'Edit' : 'Tambah' ?> Arsip</h1>
<div class="card shadow-sm" style="max-width:720px"><div class="card-body">
    <form action="<?= base_url($archive ? 'archives/update/' . $archive['id'] : 'archives/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label">Judul Arsip <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control" value="<?= esc(old('title', $archive['title'] ?? '')) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Kategori <span class="text-danger">*</span></label>
            <select name="category_id" class="form-select" required>
                <option value="">-- Pilih kategori --</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= old('category_id', $archive['category_id'] ?? '') == $c['id'] ? 'selected' : '' ?>><?= esc($c['name']) ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi <small class="text-muted">(opsional)</small></label>
            <textarea name="description" rows="3" class="form-control"><?= esc(old('description', $archive['description'] ?? '')) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Dokumen <?= $archive ? '<small class="text-muted">(kosongkan jika tidak diganti)</small>' : '<span class="text-danger">*</span>' ?></label>
            <input type="file" name="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png" <?= $archive ? '' : 'required' ?>>
            <div class="form-text">Format: PDF, JPG, PNG. Maksimal 5 MB.</div>
            <?php if ($archive): ?><div class="form-text">File saat ini: <?= esc($archive['original_name']) ?></div><?php endif ?>
        </div>
        <button class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('archives') ?>" class="btn btn-light">Batal</a>
    </form>
</div></div>
<?= $this->endSection() ?>

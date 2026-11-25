<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<h1 class="h4 mb-3"><?= $category ? 'Edit' : 'Tambah' ?> Kategori</h1>
<div class="card shadow-sm" style="max-width:600px"><div class="card-body">
    <form action="<?= base_url($category ? 'categories/update/' . $category['id'] : 'categories/store') ?>" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="name" class="form-control" value="<?= esc(old('name', $category['name'] ?? '')) ?>" required>
        </div>
        <button class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('categories') ?>" class="btn btn-light">Batal</a>
    </form>
</div></div>
<?= $this->endSection() ?>

<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Daftar Arsip</h1>
    <a href="<?= base_url('archives/create') ?>" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Arsip</a>
</div>

<form method="get" class="row g-2 mb-3">
    <div class="col-12 col-md-6"><input type="text" name="q" value="<?= esc($q) ?>" class="form-control" placeholder="Cari judul arsip..."></div>
    <div class="col-8 col-md-4">
        <select name="category" class="form-select">
            <option value="">Semua kategori</option>
            <?php foreach ($categories as $c): ?>
                <option value="<?= $c['id'] ?>" <?= $cat == $c['id'] ? 'selected' : '' ?>><?= esc($c['name']) ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="col-4 col-md-2"><button class="btn btn-outline-primary w-100">Filter</button></div>
</form>

<div class="card shadow-sm"><div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th>Judul</th><th>Kategori</th><th>File</th><th>Tanggal</th><th class="text-end">Aksi</th></tr></thead>
        <tbody>
        <?php if (! $archives): ?>
            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada arsip.</td></tr>
        <?php endif ?>
        <?php foreach ($archives as $a): ?>
            <?php $ext = strtoupper(pathinfo($a['original_name'], PATHINFO_EXTENSION)); ?>
            <tr>
                <td><a href="<?= base_url('archives/show/' . $a['id']) ?>" class="fw-semibold text-decoration-none"><?= esc($a['title']) ?></a></td>
                <td><span class="badge text-bg-secondary"><?= esc($a['category_name']) ?></span></td>
                <td><span class="badge text-bg-info"><?= esc($ext) ?></span> <small class="text-muted"><?= number_format($a['file_size'] / 1024, 0) ?> KB</small></td>
                <td class="text-nowrap"><?= date('d M Y', strtotime($a['created_at'])) ?></td>
                <td class="text-end text-nowrap">
                    <a href="<?= base_url('archives/show/' . $a['id']) ?>" class="btn btn-sm btn-outline-primary" title="Lihat"><i class="bi bi-eye"></i></a>
                    <a href="<?= base_url('archives/download/' . $a['id']) ?>" class="btn btn-sm btn-outline-success" title="Download"><i class="bi bi-download"></i></a>
                    <a href="<?= base_url('archives/edit/' . $a['id']) ?>" class="btn btn-sm btn-outline-secondary" title="Edit"><i class="bi bi-pencil"></i></a>
                    <form action="<?= base_url('archives/delete/' . $a['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus arsip ini beserta filenya?')">
                        <?= csrf_field() ?>
                        <button class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div></div>
<div class="mt-3"><?= $pager->links() ?></div>
<?= $this->endSection() ?>

<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Kategori</h1>
    <a href="<?= base_url('categories/create') ?>" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Kategori</a>
</div>
<div class="card shadow-sm"><div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th style="width:60px">#</th><th>Nama Kategori</th><th class="text-end" style="width:170px">Aksi</th></tr></thead>
        <tbody>
        <?php if (! $categories): ?>
            <tr><td colspan="3" class="text-center text-muted py-4">Belum ada kategori.</td></tr>
        <?php endif ?>
        <?php foreach ($categories as $i => $c): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= esc($c['name']) ?></td>
                <td class="text-end">
                    <a href="<?= base_url('categories/edit/' . $c['id']) ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i> Edit</a>
                    <form action="<?= base_url('categories/delete/' . $c['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                        <?= csrf_field() ?>
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div></div>
<?= $this->endSection() ?>

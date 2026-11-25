<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<?php $isPdf = $archive['file_type'] === 'application/pdf'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Detail Arsip</h1>
    <a href="<?= base_url('archives') ?>" class="btn btn-light"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>
<div class="card shadow-sm mb-3"><div class="card-body">
    <h2 class="h5"><?= esc($archive['title']) ?></h2>
    <p class="mb-1"><span class="badge text-bg-secondary"><?= esc($archive['category_name']) ?></span></p>
    <p class="text-muted"><?= $archive['description'] ? nl2br(esc($archive['description'])) : '<em>Tidak ada deskripsi.</em>' ?></p>
    <dl class="row mb-3">
        <dt class="col-sm-3">Nama file</dt><dd class="col-sm-9"><?= esc($archive['original_name']) ?></dd>
        <dt class="col-sm-3">Ukuran</dt><dd class="col-sm-9"><?= number_format($archive['file_size'] / 1024, 0) ?> KB</dd>
        <dt class="col-sm-3">Diunggah</dt><dd class="col-sm-9"><?= date('d M Y H:i', strtotime($archive['created_at'])) ?></dd>
    </dl>
    <a href="<?= base_url('archives/download/' . $archive['id']) ?>" class="btn btn-success"><i class="bi bi-download"></i> Download</a>
    <a href="<?= base_url('archives/file/' . $archive['id']) ?>" target="_blank" class="btn btn-outline-primary"><i class="bi bi-box-arrow-up-right"></i> Buka di tab baru</a>
</div></div>

<div class="card shadow-sm"><div class="card-body">
    <?php if ($isPdf): ?>
        <iframe src="<?= base_url('archives/file/' . $archive['id']) ?>" class="w-100 border-0" style="height:75vh"></iframe>
    <?php else: ?>
        <img src="<?= base_url('archives/file/' . $archive['id']) ?>" class="img-fluid mx-auto d-block" alt="<?= esc($archive['title']) ?>">
    <?php endif ?>
</div></div>
<?= $this->endSection() ?>

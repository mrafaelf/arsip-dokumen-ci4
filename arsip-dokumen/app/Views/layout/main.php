<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Sistem Arsip Dokumen') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-md navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= base_url('archives') ?>"><i class="bi bi-archive"></i> Arsip Dokumen</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="<?= base_url('archives') ?>">Arsip</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('categories') ?>">Kategori</a></li>
            </ul>
            <span class="navbar-text me-3"><i class="bi bi-person-circle"></i> <?= esc(session('user_name')) ?></span>
            <a class="btn btn-outline-light btn-sm" href="<?= base_url('logout') ?>">Logout</a>
        </div>
    </div>
</nav>

<main class="container pb-5">
    <?php if (session('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= esc(session('success')) ?><button class="btn-close" data-bs-dismiss="alert"></button></div><?php endif ?>
    <?php if (session('error')): ?><div class="alert alert-danger alert-dismissible fade show"><?= esc(session('error')) ?><button class="btn-close" data-bs-dismiss="alert"></button></div><?php endif ?>
    <?php if (session('errors')): ?>
        <div class="alert alert-danger"><ul class="mb-0"><?php foreach (session('errors') as $e): ?><li><?= esc($e) ?></li><?php endforeach ?></ul></div>
    <?php endif ?>

    <?= $this->renderSection('content') ?>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

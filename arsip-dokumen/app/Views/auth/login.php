<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Sistem Arsip Dokumen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center min-vh-100">
<div class="container" style="max-width:420px">
    <div class="text-center mb-4">
        <i class="bi bi-archive text-primary" style="font-size:3rem"></i>
        <h1 class="h4 fw-bold mt-2">Sistem Arsip Dokumen</h1>
        <p class="text-muted">Silakan login untuk melanjutkan</p>
    </div>
    <div class="card shadow-sm"><div class="card-body p-4">
        <?php if (session('error')): ?><div class="alert alert-danger py-2"><?= esc(session('error')) ?></div><?php endif ?>
        <?php if (session('success')): ?><div class="alert alert-success py-2"><?= esc(session('success')) ?></div><?php endif ?>
        <form action="<?= base_url('login') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= esc(old('email')) ?>" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn btn-primary w-100">Login</button>
        </form>
    </div></div>
</div>
</body>
</html>

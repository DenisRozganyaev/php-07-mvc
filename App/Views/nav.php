<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Blog</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarNav">
            <ul class="navbar-nav">
                <?php
                if (\App\Helpers\SessionHelper::isAdmin() && isAdminRoute()) {
                    include_once VIEW_DIR . '/navs/admin.php';
                } else {
                    include_once VIEW_DIR . '/navs/site.php';
                }
                ?>
            </ul>
            <ul class="navbar-nav">
                <?php if (\App\Helpers\SessionHelper::authCheck()): ?>
                    <li class="nav-item">
                        <?php if (\App\Helpers\SessionHelper::isAdmin()): ?>
                            <a class="nav-link" href="<?= url('admin/dashboard') ?>">Dashboard</a>
                        <?php else: ?>
                            <a class="nav-link" href="<?= url('account/dashboard') ?>">Account</a>
                        <?php endif; ?>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= url('logout') ?>">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= url('login') ?>">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= url('registration') ?>">Registration</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<nav style="background-color: #039be5;" class="shadow navbar navbar-dark navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="<?= BASEURL ?>">
            <img src="<?= BASEURL ?>public/assets/logo.png" alt="vaultbox logo" width="150">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= BASEURL ?>">Home</a>
                </li>
                <?php if (!isset($username)) : ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= BASEURL ?>login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= BASEURL ?>register">Register</a>
                    </li>
                <?php endif; ?>
                <?php if (isset($username)) : ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= BASEURL ?>vault">My Vault</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-fill me-2"></i><?= $username ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="<?= BASEURL ?>setting"><i class="bi bi-gear me-2"></i>Setting</a></li>
                            <li><a class="dropdown-item" href="<?= BASEURL ?>logout"><i class="bi bi-box-arrow-left me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
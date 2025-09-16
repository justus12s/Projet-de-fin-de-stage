<!-- header.php -->
 <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-2" href="<?= base_url('accueil')?>">
                    <img src="<?= base_url('images/logo.png')?>" alt="logo de la bibliothèque" width="40" height="40" class="d-inline-block align-text-top">
                    <span class="fw-bold text-primary">DJAB Excellence</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/')?>">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('a_propos')?>">À propos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('guide_utilisateur')?>">Guide Utilisateur</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('login')?>">Connexion</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
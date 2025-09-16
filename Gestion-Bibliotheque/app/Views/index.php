<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Accueil - Bibliothèque DJAB Excellence<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center animate-fade-in">
                    <h1 class="display-4 fw-bold mb-3">Bibliothèque DJAB Excellence</h1>
                    <p class="lead mb-4">Découvrez un univers de connaissances et explorez notre vaste collection de livres et ressources</p>
                    <a href="<?= base_url('login')?>" class="btn btn-light btn-lg">
                        <i class="fas fa-book-open me-2"></i>Explorer le catalogue
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Nouveautés -->
    <section class="mb-5 animate-fade-in delay-1">
        <h2 class="mb-4 text-center"><i class="fas fa-star me-2 text-warning"></i>Nouveautés</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <img src="<?= base_url('images/Harry-Potter-a-l-ecole-des-sorciers.jpg')?>" class="book-cover" alt="Harry Potter">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Harry Potter</h5>
                        <p class="card-text text-muted">Découvrez la magie de Poudlard et suivez les aventures de Harry et ses amis.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-primary">Fantasy</span>
                            <a href="<?= base_url('login')?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye me-1"></i> Détails
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <img src="<?= base_url('images/moi_moche_et_mechant.png')?>" class="book-cover" alt="Moi, moche et méchant">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Moi, moche et méchant</h5>
                        <p class="card-text text-muted">L'histoire hilarante de Gru et de ses célèbres Minions.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-success">Jeunesse</span>
                            <a href="<?= base_url('login')?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye me-1"></i> Détails
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <img src="https://images.pexels.com/photos/3769714/pexels-photo-3769714.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="book-cover" alt="Le Grand Custot">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Le Grand Custot</h5>
                        <p class="card-text text-muted">Recueil de recettes savoureuses pour passionnés de cuisine.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-info">Cuisine</span>
                            <a href="<?= base_url('login')?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye me-1"></i> Détails
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Avis -->
    <section class="mb-5 animate-fade-in delay-2">
        <h2 class="mb-4 text-center"><i class="fas fa-comments me-2 text-primary"></i>Avis de nos membres</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 avis-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-quote-left text-primary fa-2x me-3"></i>
                            <p class="mb-0 fst-italic">
                                "Une bibliothèque en ligne exceptionnelle ! Interface intuitive et service de qualité."
                            </p>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div>
                                <h5 class="fw-semibold mb-0">Sophie L.</h5>
                                <small class="text-muted">Étudiante en Littérature</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 avis-card success">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-quote-left text-success fa-2x me-3"></i>
                            <p class="mb-0 fst-italic">
                                "Accès à une multitude de ressources académiques qui m'ont énormément aidé."
                            </p>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div>
                                <h5 class="fw-semibold mb-0">Marc D.</h5>
                                <small class="text-muted">Chercheur Universitaire</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 avis-card info">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-quote-left text-info fa-2x me-3"></i>
                            <p class="mb-0 fst-italic">
                                "Le choix est vaste et la navigation est un plaisir. Meilleure bibliothèque en ligne !"
                            </p>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-info rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div>
                                <h5 class="fw-semibold mb-0">Amira K.</h5>
                                <small class="text-muted">Professeure de Français</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="cta-section text-center mb-5 animate-fade-in delay-3">
        <i class="fas fa-users fa-3x text-primary mb-3"></i>
        <h2 class="mb-3 fw-bold">Rejoignez notre communauté !</h2>
        <p class="mb-4 text-muted mx-auto" style="max-width: 600px;">
            Accédez à des milliers de livres, articles et ressources exclusives. 
            L'inscription est rapide et gratuite.
        </p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a class="btn btn-primary btn-lg" href="<?= base_url('register')?>">
                <i class="fas fa-user-plus me-2"></i> S'inscrire maintenant
            </a>
            <a class="btn btn-outline-primary btn-lg" href="<?= base_url('login')?>">
                <i class="fas fa-sign-in-alt me-2"></i> Se connecter
            </a>
        </div>
    </section>
<?= $this->endSection() ?>
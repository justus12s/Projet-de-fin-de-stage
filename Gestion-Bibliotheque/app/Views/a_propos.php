<?= $this->extend('layout') ?>

<?= $this->section('title') ?>À propos - Bibliothèque DJAB Excellence<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center animate-fade-in">
                    <h1 class="display-4 fw-bold mb-3">À propos de nous</h1>
                    <p class="lead mb-4">Découvrez l'histoire de notre projet et notre engagement à promouvoir la lecture</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Notre histoire -->
    <section class="mb-5 animate-fade-in delay-1">
        <div class="card about-card p-4 mb-4">
            <h2 class="h4 fw-bold text-primary mb-3"><i class="fas fa-history me-2"></i>Notre histoire</h2>
            <p class="mb-0">Notre plateforme de bibliothèque en ligne est le fruit d'un projet de fin de stage, mené avec passion et dévouement. L'objectif était de créer un outil numérique moderne pour faciliter l'accès à la culture et à l'éducation, en s'inspirant des défis et des opportunités offertes par les technologies web.</p>
        </div>
    </section>

    <!-- Notre mission -->
    <section class="mb-5 animate-fade-in delay-2">
        <div class="card about-card success p-4 mb-4">
            <h2 class="h4 fw-bold text-success mb-3"><i class="fas fa-bullseye me-2"></i>Notre mission</h2>
            <p class="mb-0">Nous pensons que la lecture est un pilier du développement personnel. Notre mission est de démocratiser l'accès au savoir en offrant un catalogue de livres riche et diversifié, accessible à tous. Nous souhaitons créer une communauté de lecteurs où chacun peut découvrir de nouvelles œuvres, partager ses passions et emprunter des livres en toute simplicité.</p>
        </div>
    </section>
    
    <!-- L'équipe -->
    <section class="mb-5 animate-fade-in delay-3">
        <div class="card about-card info p-4">
            <h2 class="h4 fw-bold text-info mb-3"><i class="fas fa-users me-2"></i>L'équipe</h2>
            <p class="mb-0">
                Ce projet a été conçu et développé par l'équipe de stagiaires de <strong>COSIT BENIN</strong>.
                Nous sommes fiers d'avoir mis en œuvre les compétences acquises durant notre formation pour donner vie à cette plateforme.
            </p>
        </div>
    </section>
    
    <!-- Section valeurs -->
    <section class="animate-fade-in">
        <h2 class="mb-4 text-center"><i class="fas fa-star me-2 text-warning"></i>Nos valeurs</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-book-open text-white fa-2x"></i>
                    </div>
                    <h5 class="fw-bold">Accessibilité</h5>
                    <p class="text-muted">Rendre la lecture accessible à tous, sans barrières</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-shield-alt text-white fa-2x"></i>
                    </div>
                    <h5 class="fw-bold">Qualité</h5>
                    <p class="text-muted">Offrir un service de qualité avec des ressources vérifiées</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="bg-info rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-hand-holding-heart text-white fa-2x"></i>
                    </div>
                    <h5 class="fw-bold">Partage</h5>
                    <p class="text-muted">Favoriser le partage des connaissances et la communauté</p>
                </div>
            </div>
        </div>
    </section>
<?= $this->endSection() ?>
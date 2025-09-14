<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Bibliothèque DJAB Excellence' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0d6efd;
            --secondary: #6c757d;
            --success: #198754;
            --warning: #ffc107;
            --danger: #dc3545;
            --info: #0dcaf0;
            --light: #f8f9fa;
            --dark: #212529;
            --background: #f8f9fa;
        }
        
        body {
            background-color: var(--background);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: var(--dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .main-content {
            flex: 1;
        }
        
        .navbar {
            background-color: #343a40 !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: all 0.2s ease;
        }
        
        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        
        .btn {
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }
        
        footer {
            margin-top: auto;
            background-color: #343a40;
            color: white;
        }
        
        /* Animation d'entrée */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in {
            opacity: 0;
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        .delay-1 {
            animation-delay: 0.2s;
        }
        
        .delay-2 {
            animation-delay: 0.4s;
        }
        
        .delay-3 {
            animation-delay: 0.6s;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .display-4 {
                font-size: 2.2rem;
            }
        }
        
        @media (max-width: 576px) {
            .display-4 {
                font-size: 1.8rem;
            }
        }
        
        /* Styles spécifiques pour la page d'accueil */
        .book-cover {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        
        .avis-card {
            border-left: 4px solid var(--primary);
            transition: all 0.3s ease;
        }
        
        .avis-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }
        
        .avis-card.success {
            border-left-color: var(--success);
        }
        
        .avis-card.info {
            border-left-color: var(--info);
        }
        
        .hero-section {
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.9) 0%, rgba(33, 37, 41, 0.9) 100%), url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 4rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 20px 20px;
        }
        
        .cta-section {
            background-color: white;
            border-radius: 12px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        /* Styles spécifiques pour la page À propos */
        .about-card {
            border-left: 4px solid var(--primary);
            transition: all 0.3s ease;
        }
        
        .about-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }
        
        .about-card.success {
            border-left-color: var(--success);
        }
        
        .about-card.info {
            border-left-color: var(--info);
        }
    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('/') ?>">
                <i class="fas fa-book-reader me-2"></i>DJAB Excellence
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= current_url() == base_url('/') ? 'active' : '' ?>" href="<?= base_url('/') ?>">
                            <i class="fas fa-home me-1"></i> Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= current_url() == base_url('a_propos') ? 'active' : '' ?>" href="<?= base_url('a_propos') ?>">
                            <i class="fas fa-info-circle me-1"></i> À propos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= current_url() == base_url('guide_utilisateur') ? 'active' : '' ?>" href="<?= base_url('guide_utilisateur') ?>">
                            <i class="fas fa-book-open me-1"></i> Guide
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= current_url() == base_url('login') ? 'active' : '' ?>" href="<?= base_url('login') ?>">
                            <i class="fas fa-sign-in-alt me-1"></i> Connexion
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <main class="container main-content my-4">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="py-4">
        <div class="container text-center">
            <p class="mb-1">&copy; 2025 <strong>Bibliothèque DJAB Excellence</strong>. Tous droits réservés.</p>
            <p class="mb-0">
                <i class="fas fa-graduation-cap me-1"></i> Un projet de fin de stage
            </p>
            <div class="mt-3">
                <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
                <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-lg"></i></a>
                <a href="#" class="text-white"><i class="fab fa-instagram fa-lg"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animation au défilement
        document.addEventListener('DOMContentLoaded', function() {
            const animatedElements = document.querySelectorAll('.animate-fade-in');
            
            animatedElements.forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                
                setTimeout(() => {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, 100 + (index * 200));
            });
        });
    </script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
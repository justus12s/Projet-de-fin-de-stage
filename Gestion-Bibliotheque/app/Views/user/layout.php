<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Espace Membre' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .book-cover {
            width: 40px;
            height: 56px;
            object-fit: cover;
            border-radius: 4px;
        }
        .book-cover-placeholder {
            width: 40px;
            height: 56px;
            background: #f8f9fa;
            border: 1px dashed #dee2e6;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
        }
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .main-content {
            flex: 1;
        }
        .footer {
            margin-top: auto;
        }
        .sidebar .nav-link {
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover {
            background-color: #f8f9fa;
            padding-left: 20px;
        }
        .sidebar .nav-link.active {
            background-color: #007bff;
            color: white !important;
        }
        
        /* Styles responsives */
        @media (max-width: 992px) {
            .navbar-brand {
                font-size: 1rem;
            }
            
            .navbar-text {
                display: none;
            }
            
            .sidebar-card {
                margin-bottom: 1rem;
            }
            
            .mobile-menu-btn {
                display: block;
                position: fixed;
                bottom: 20px;
                right: 20px;
                z-index: 1000;
                width: 50px;
                height: 50px;
                border-radius: 50%;
                background-color: #007bff;
                color: white;
                box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            }
            
            .sidebar-col {
                position: fixed;
                top: 0;
                left: -300px;
                width: 280px;
                height: 100vh;
                z-index: 1001;
                overflow-y: auto;
                transition: left 0.3s ease;
                background: white;
                padding: 1rem;
                box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            }
            
            .sidebar-col.show {
                left: 0;
            }
            
            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 1000;
            }
            
            .overlay.show {
                display: block;
            }
            
            .main-content-col {
                width: 100%;
            }
        }
        
        @media (max-width: 768px) {
            .stats-card .card-body {
                padding: 1rem;
            }
            
            .stats-card h3 {
                font-size: 1.5rem;
            }
            
            .book-cover, .book-cover-placeholder {
                width: 30px;
                height: 42px;
            }
            
            .card-header h4, .card-header h6 {
                font-size: 1rem;
            }
            
            .alert h5 {
                font-size: 1rem;
            }
            
            .d-md-flex .btn {
                margin-bottom: 0.5rem;
                width: 100%;
            }
        }
        
        @media (max-width: 576px) {
            .container {
                padding-left: 10px;
                padding-right: 10px;
            }
            
            .stats-card {
                margin-bottom: 0.5rem;
            }
            
            .stats-card .card-body {
                padding: 0.75rem;
            }
            
            .stats-card h6 {
                font-size: 0.8rem;
            }
            
            .stats-card h3 {
                font-size: 1.25rem;
            }
            
            .list-group-item {
                padding: 0.75rem;
            }
            
            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.8rem;
            }
            #closeSidebar{
                width: 32px;
                height: 32px;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= site_url('dashboard') ?>">
                <i class="fas fa-book-reader me-2"></i>DJAB Excellence
            </a>
            <button class="navbar-toggler d-lg-none" type="button" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3 d-none d-md-block">
                    <i class="fas fa-user me-1"></i> <?= session()->get('user_name') ?>
                </span>
                <a class="btn btn-outline-light btn-sm" href="<?= site_url('logout') ?>">
                    <i class="fas fa-sign-out-alt me-1"></i> <span class="d-none d-md-inline">Déconnexion</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Overlay pour mobile -->
    <div class="overlay" id="overlay"></div>

    <div class="container mt-4 main-content">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar-col" id="sidebarCol">
                <div class="card shadow-sm sidebar-card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i>Mon Espace</h5>
                        <button class="btn btn-sm btn-light d-lg-none" id="closeSidebar">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <i class="fas fa-user-circle fa-3x text-primary"></i>
                            <h6 class="mt-2"><?= session()->get('user_name') ?></h6>
                            <span class="badge bg-info"><?= session()->get('user_status') ?></span>
                        </div>
                        <hr>
                        
                        <?php
                        // Définition des URLs et de leurs libellés
                        $menuItems = [
                            'dashboard' => ['icon' => 'tachometer-alt', 'label' => 'Tableau de bord'],
                            'books' => ['icon' => 'book', 'label' => 'Livres disponibles'],
                            'my-reservations' => ['icon' => 'calendar-check', 'label' => 'Mes reservations'],
                            'my-books' => ['icon' => 'book-open', 'label' => 'Mes emprunts'],
                            'history' => ['icon' => 'history', 'label' => 'Mon historique'],
                            'profile' => ['icon' => 'user', 'label' => 'Mon profil']
                        ];
                        
                        // Récupération de l'URL courante
                        $currentUrl = current_url();
                        ?>
                        
                        <ul class="nav flex-column sidebar">
                            <?php foreach ($menuItems as $route => $item): ?>
                                <?php
                                $isActive = false;
                                $itemUrl = site_url($route);
                                
                                // Vérification si l'URL courante correspond à cet item
                                if ($currentUrl == $itemUrl) {
                                    $isActive = true;
                                }
                                // Vérification pour les sous-pages (ex: books/123)
                                else if (strpos($currentUrl, $itemUrl . '/') === 0) {
                                    $isActive = true;
                                }
                                ?>
                                <li class="nav-item">
                                    <a class="nav-link <?= $isActive ? 'active' : 'text-dark' ?>" 
                                       href="<?= $itemUrl ?>">
                                        <i class="fas fa-<?= $item['icon'] ?> me-2"></i> <?= $item['label'] ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                            
                            <li class="nav-item mt-3">
                                <a class="nav-link text-danger" href="<?= site_url('logout') ?>">
                                    <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Contenu principal -->
            <div class="col-md-9 main-content-col">
                <!-- Messages Flash -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show mb-4">
                        <i class="fas fa-check-circle me-2"></i>
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show mb-4">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('warning')): ?>
                    <div class="alert alert-warning alert-dismissible fade show mb-4">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <?= session()->getFlashdata('warning') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('info')): ?>
                    <div class="alert alert-info alert-dismissible fade show mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <?= session()->getFlashdata('info') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Contenu principal -->
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

    <!-- Bouton menu mobile -->
    
    <!-- Footer -->
    <footer class="bg-dark text-white py-4 footer">
        <div class="container text-center">
            <p class="mb-0">
                <i class="fas fa-book-reader me-2"></i>
                &copy; 2024 Bibliothèque. Tous droits réservés.
            </p>
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
    // Gestion des messages flash - VERSION SANS AUTO-FERMETURE
    document.addEventListener('DOMContentLoaded', function() {
        // Ajouter des boutons de fermeture manuelle à toutes les alerts
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            // Ajouter un bouton de fermeture si absent
            if (!alert.querySelector('.btn-close')) {
                const closeButton = document.createElement('button');
                closeButton.type = 'button';
                closeButton.className = 'btn-close';
                closeButton.setAttribute('data-bs-dismiss', 'alert');
                closeButton.setAttribute('aria-label', 'Close');
                closeButton.style.position = 'absolute';
                closeButton.style.top = '10px';
                closeButton.style.right = '10px';
                
                alert.style.position = 'relative';
                alert.appendChild(closeButton);
            }
        });
    });

    // Gestion du menu responsive
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarCol = document.getElementById('sidebarCol');
        const overlay = document.getElementById('overlay');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const closeSidebar = document.getElementById('closeSidebar');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        
        function toggleSidebar() {
            sidebarCol.classList.toggle('show');
            overlay.classList.toggle('show');
            document.body.style.overflow = sidebarCol.classList.contains('show') ? 'hidden' : '';
        }
        
        if (sidebarToggle) sidebarToggle.addEventListener('click', toggleSidebar);
        if (closeSidebar) closeSidebar.addEventListener('click', toggleSidebar);
        if (overlay) overlay.addEventListener('click', toggleSidebar);
        if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', toggleSidebar);
        
        // Animation pour les liens de la sidebar
        const navLinks = document.querySelectorAll('.sidebar .nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 992) {
                    toggleSidebar();
                }
            });
        });
    });
    </script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
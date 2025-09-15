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
        .stats-card {
            transition: transform 0.2s;
        }
        .stats-card:hover {
            transform: translateY(-5px);
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
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1rem;
            }
            
            .navbar-text {
                display: none;
            }
            
            .sidebar-card {
                margin-bottom: 1rem;
            }
            
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
        }
        
        /* Menu mobile */
        .mobile-menu-btn {
            display: none;
        }
        
        @media (max-width: 992px) {
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
                            <h6 class="mt-2"><?= $user['name'] ?></h6>
                            <span class="badge bg-info"><?= $user['status'] ?></span>
                        </div>
                        <hr>
                        <ul class="nav flex-column sidebar">
                            <li class="nav-item">
                                <a class="nav-link active" href="<?= site_url('dashboard') ?>">
                                    <i class="fas fa-tachometer-alt me-2"></i> Tableau de bord
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="<?= site_url('books') ?>">
                                    <i class="fas fa-book me-2"></i> Livres disponibles
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="<?= site_url('my-reservations') ?>">
                                    <i class="fas fa-calendar-check me-2"></i> Mes reservations
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="<?= site_url('my-books') ?>">
                                    <i class="fas fa-book-open me-2"></i> Mes emprunts
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="<?= site_url('history') ?>">
                                    <i class="fas fa-history me-2"></i> Mon historique
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="<?= site_url('profile') ?>">
                                    <i class="fas fa-user me-2"></i> Mon profil
                                </a>
                            </li>
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

                <!-- Contenu principal -->
                <div class="card">
                    <div class="card-header">
                        <h4>Tableau de bord</h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success">
                            <h5>Bienvenue <?= $user['name'] ?> !</h5>
                            <p class="mb-0">Vous êtes connecté en tant que <strong><?= $user['status'] ?></strong></p>
                        </div>
                        
                        <!-- Cartes de statistiques -->
                        <div class="row">
                            <div class="col-6 col-md-3 mb-3">
                                <div class="card text-white bg-primary h-100 stats-card">
                                    <div class="card-body text-center">
                                        <h5><i class="fas fa-book"></i></h5>
                                        <h6>Emprunts actifs</h6>
                                        <h3><?= $stats['active_loans'] ?? 0 ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 mb-3">
                                <div class="card text-white bg-success h-100 stats-card">
                                    <div class="card-body text-center">
                                        <h5><i class="fas fa-check-circle"></i></h5>
                                        <h6>Retournés</h6>
                                        <h3><?= $stats['returned_loans'] ?? 0 ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 mb-3">
                                <div class="card text-white bg-warning h-100 stats-card">
                                    <div class="card-body text-center">
                                        <h5><i class="fas fa-clock"></i></h5>
                                        <h6>En retard</h6>
                                        <h3><?= $stats['overdue_loans'] ?? 0 ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 mb-3">
                                <div class="card text-white bg-info h-100 stats-card">
                                    <div class="card-body text-center">
                                        <h5><i class="fas fa-exchange-alt"></i></h5>
                                        <h6>Total</h6>
                                        <h3><?= $stats['total_loans'] ?? 0 ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section limites d'emprunt -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Mes limites d'emprunt</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i>
                                            <strong>Limites actuelles :</strong><br>
                                            • Vous avez <strong><?= $loan_limits['current_loans'] ?></strong> livre(s) emprunté(s)<br>
                                            • Vous pouvez encore emprunter <strong><?= $loan_limits['remaining_loans'] ?></strong> livre(s)<br>
                                            • Limite maximale : <strong><?= $loan_limits['max_books'] ?></strong> livre(s) simultané(s)
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <!-- Emprunts en cours -->
                            <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h6>Mes Emprunts en Cours</h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($active_loans)): ?>
                                            <div class="list-group">
                                                <?php foreach ($active_loans as $loan): ?>
                                                <div class="list-group-item">
                                                    <div class="d-flex align-items-center">
                                                        <?php if (!empty($loan['cover_image'])): ?>
                                                            <img src="<?= base_url('uploads/books/' . $loan['cover_image']) ?>" 
                                                                 class="book-cover me-3" 
                                                                 alt="Couverture">
                                                        <?php else: ?>
                                                            <div class="book-cover-placeholder me-3">
                                                                <i class="fas fa-book"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                        
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-1"><?= esc($loan['title']) ?></h6>
                                                            <p class="mb-1 text-muted"><?= esc($loan['author']) ?></p>
                                                            <small>Retour: <?= date('d/m/Y', strtotime($loan['due_date'])) ?></small>
                                                            <?php if ($loan['status'] === 'overdue'): ?>
                                                                <span class="badge bg-danger ms-2">En retard</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-muted">Aucun emprunt en cours</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Livres disponibles -->
                            <div class="col-12 col-lg-6">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h6>Livres Disponibles</h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($available_books)): ?>
                                            <div class="list-group">
                                                <?php foreach ($available_books as $book): ?>
                                                <a href="<?= site_url('books') ?>" class="list-group-item list-group-item-action">
                                                    <div class="d-flex align-items-center">
                                                        <?php if (!empty($book['cover_image'])): ?>
                                                            <img src="<?= base_url('uploads/books/' . $book['cover_image']) ?>" 
                                                                 class="book-cover me-3" 
                                                                 alt="Couverture">
                                                        <?php else: ?>
                                                            <div class="book-cover-placeholder me-3">
                                                                <i class="fas fa-book"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                        
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-1"><?= esc($book['title']) ?></h6>
                                                            <p class="mb-1 text-muted"><?= esc($book['author']) ?></p>
                                                            <small class="text-success">Disponible</small>
                                                        </div>
                                                    </div>
                                                </a>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-muted">Aucun livre disponible</p>
                                        <?php endif; ?>
                                        
                                        <div class="text-center mt-3">
                                            <a href="<?= site_url('books') ?>" class="btn btn-primary btn-sm">
                                                Voir tous les livres
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Actions rapides -->
                        <div class="mt-4">
                            <h5>Actions rapides</h5>
                            <div class="d-flex flex-column flex-md-row gap-2">
                                <a href="<?= site_url('books') ?>" class="btn btn-outline-primary flex-fill text-center">
                                    <i class="fas fa-search"></i> Rechercher un livre
                                </a>
                                <a href="<?= site_url('my-books') ?>" class="btn btn-outline-success flex-fill text-center">
                                    <i class="fas fa-book-open"></i> Mes emprunts
                                </a>
                                <a href="<?= site_url('history') ?>" class="btn btn-outline-info flex-fill text-center">
                                    <i class="fas fa-history"></i> Mon historique
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bouton menu mobile -->
    <button class="btn btn-primary mobile-menu-btn" id="mobileMenuBtn">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 footer mt-4">
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
    // Gestion des messages flash
    document.addEventListener('DOMContentLoaded', function() {
        // Ajouter des boutons de fermeture manuelle à toutes les alerts
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
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
</body>
</html>
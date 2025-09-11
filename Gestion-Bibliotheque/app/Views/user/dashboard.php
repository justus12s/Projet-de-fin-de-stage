<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
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
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3">
                <!-- Sidebar utilisateur -->
                <div class="card">
                    <div class="card-header">
                        <h5>Mon Espace</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <i class="fas fa-user-circle fa-3x text-primary"></i>
                            <h6 class="mt-2"><?= $user['name'] ?></h6>
                            <span class="badge bg-info"><?= $user['status'] ?></span>
                        </div>
                        <hr>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" href="<?= site_url('dashboard') ?>">
                                    <i class="fas fa-tachometer-alt"></i> Tableau de bord
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('books') ?>">
                                    <i class="fas fa-book"></i> Livres disponibles
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('my-books') ?>">
                                    <i class="fas fa-book-open"></i> Mes emprunts
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('history') ?>">
                                    <i class="fas fa-history"></i> Mon historique
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('profile') ?>">
                                    <i class="fas fa-user"></i> Mon Profil
                                </a>
                            </li>
                            <li class="nav-item mt-3">
                                <a class="nav-link text-danger" href="<?= site_url('logout') ?>">
                                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-md-9">
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
                            <div class="col-md-3">
                                <div class="card text-white bg-primary mb-3 stats-card">
                                    <div class="card-body text-center">
                                        <h5><i class="fas fa-book"></i></h5>
                                        <h6>Emprunts actifs</h6>
                                        <h3><?= $stats['active_loans'] ?? 0 ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-white bg-success mb-3 stats-card">
                                    <div class="card-body text-center">
                                        <h5><i class="fas fa-check-circle"></i></h5>
                                        <h6>Retournés</h6>
                                        <h3><?= $stats['returned_loans'] ?? 0 ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-white bg-warning mb-3 stats-card">
                                    <div class="card-body text-center">
                                        <h5><i class="fas fa-clock"></i></h5>
                                        <h6>En retard</h6>
                                        <h3><?= $stats['overdue_loans'] ?? 0 ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-white bg-info mb-3 stats-card">
                                    <div class="card-body text-center">
                                        <h5><i class="fas fa-exchange-alt"></i></h5>
                                        <h6>Total</h6>
                                        <h3><?= $stats['total_loans'] ?? 0 ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <!-- Emprunts en cours -->
                            <div class="col-md-6">
                                <div class="card">
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
                                                                 class="book-cover mr-3" 
                                                                 alt="Couverture">
                                                        <?php else: ?>
                                                            <div class="book-cover-placeholder mr-3">
                                                                <i class="fas fa-book"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                        
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-1"><?= esc($loan['title']) ?></h6>
                                                            <p class="mb-1 text-muted"><?= esc($loan['author']) ?></p>
                                                            <small>Retour: <?= date('d/m/Y', strtotime($loan['due_date'])) ?></small>
                                                            <?php if ($loan['status'] === 'overdue'): ?>
                                                                <span class="badge bg-danger ml-2">En retard</span>
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
                            <div class="col-md-6">
                                <div class="card">
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
                                                                 class="book-cover mr-3" 
                                                                 alt="Couverture">
                                                        <?php else: ?>
                                                            <div class="book-cover-placeholder mr-3">
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
                            <div class="d-grid gap-2 d-md-flex">
                                <a href="<?= site_url('books') ?>" class="btn btn-outline-primary">
                                    <i class="fas fa-search"></i> Rechercher un livre
                                </a>
                                <a href="<?= site_url('my-books') ?>" class="btn btn-outline-success">
                                    <i class="fas fa-book-open"></i> Mes emprunts
                                </a>
                                <a href="<?= site_url('history') ?>" class="btn btn-outline-info">
                                    <i class="fas fa-history"></i> Mon historique
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
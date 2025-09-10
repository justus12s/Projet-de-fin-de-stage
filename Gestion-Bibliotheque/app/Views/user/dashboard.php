<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                                <a class="nav-link" href="<?= site_url('profile') ?>">
                                    <i class="fas fa-user"></i> Mon Profil
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('my-books') ?>">
                                    <i class="fas fa-book"></i> Mes Livres
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('my-reservations') ?>">
                                    <i class="fas fa-calendar"></i> Mes Réservations
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
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card text-white bg-primary mb-3">
                                    <div class="card-body text-center">
                                        <h5><i class="fas fa-book"></i></h5>
                                        <h6>Livres empruntés</h6>
                                        <h3>0</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card text-white bg-success mb-3">
                                    <div class="card-body text-center">
                                        <h5><i class="fas fa-clock"></i></h5>
                                        <h6>Réservations</h6>
                                        <h3>0</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card text-white bg-warning mb-3">
                                    <div class="card-body text-center">
                                        <h5><i class="fas fa-history"></i></h5>
                                        <h6>Historique</h6>
                                        <h3>0</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <h5>Actions rapides</h5>
                            <div class="d-grid gap-2 d-md-flex">
                                <a href="#" class="btn btn-outline-primary">
                                    <i class="fas fa-search"></i> Rechercher un livre
                                </a>
                                <a href="#" class="btn btn-outline-success">
                                    <i class="fas fa-calendar"></i> Voir mes réservations
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
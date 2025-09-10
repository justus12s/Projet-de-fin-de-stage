<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - Administration Bibliothèque</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --success-color: #2ecc71;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .sidebar {
            background-color: var(--secondary-color);
            color: white;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            margin: 4px 0;
            border-radius: 4px;
        }
        
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        
        .header {
            background-color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .stats-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            transition: transform 0.3s;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
        }
        
        .stats-card i {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        
        .card-books { border-left: 4px solid #3498db; }
        .card-members { border-left: 4px solid #2ecc71; }
        .card-loans { border-left: 4px solid #e67e22; }
        .card-overdue { border-left: 4px solid #e74c3c; }
        
        .chart-container {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .recent-table {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        
        .badge-success { background-color: var(--success-color); }
        .badge-warning { background-color: #f39c12; }
        .badge-danger { background-color: var(--accent-color); }
        
        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar d-md-block">
                <div class="text-center mb-4">
                    <h4><i class="fas fa-book-open"></i> BiblioAdmin</h4>
                </div>
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/dashboard/accueil')?>">
                            <i class="fas fa-tachometer-alt"></i> Tableau de bord
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/dashboard/books')?>">
                            <i class="fas fa-book"></i> Livres
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/dashboard/users')?>">
                            <i class="fas fa-users"></i> Membres
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/dashboard/loans')?>">
                            <i class="fas fa-exchange-alt"></i> Emprunts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-clock"></i> Retards
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-cog"></i> Paramètres
                        </a>
                    </li>
                    <li class="nav-item mt-4">
                        <a class="nav-link" href="<?= base_url('logout')?>">
                            <i class="fas fa-sign-out-alt"></i> Déconnexion
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Main content -->
            <div class="col-md-9 col-lg-10 main-content">
                <!-- Header -->
                <div class="header">
                    <h2>Tableau de Bord</h2>
                    <div class="d-flex align-items-center">
                        <div class="user-profile d-flex align-items-center">
                            <img src="https://ui-avatars.com/api/?name=Admin+User&background=3498db&color=fff" alt="Admin">
                            <span>Administrateur</span>
                        </div>
                    </div>
                </div>
                <!-- Statistics Cards -->
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="stats-card card-books">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">LIVRES</h6>
                                    <h3><?= number_format($total_books ?? 0) ?></h3>
                                    <small>Total des livres</small>
                                </div>
                                <i class="fas fa-book text-primary"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="stats-card card-members">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">MEMBRES</h6>
                                    <h3><?= number_format($total_members ?? 0) ?></h3>
                                    <small>Abonnés total</small>
                                </div>
                                <i class="fas fa-users text-success"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="stats-card card-loans">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">EMPRUNTS</h6>
                                    <h3><?= number_format($total_loans ?? 0) ?></h3>
                                    <small>Total des emprunts</small>
                                </div>
                                <i class="fas fa-exchange-alt text-warning"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="stats-card card-overdue">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">RETARDS</h6>
                                    <h3><?= number_format($total_overdue ?? 0) ?></h3>
                                    <small>Emprunts en retard</small>
                                </div>
                                <i class="fas fa-clock text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>











                <!-- Charts -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="chart-container">
                            <h5>Activité des emprunts</h5>
                            <canvas id="loanActivityChart" height="250"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="chart-container">
                            <h5>Catégories de livres</h5>
                            <canvas id="bookCategoryChart" height="250"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Recent activity -->
                <div class="row">
                    <div class="col-12">
                        <div class="recent-table">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5>Emprunts récents</h5>
                                <a href="#" class="btn btn-sm btn-primary">Voir tout</a>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Livre</th>
                                            <th>Membre</th>
                                            <th>Date d'emprunt</th>
                                            <th>Retour prévu</th>
                                            <th>Statut</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>L'Étranger</td>
                                            <td>Martin Dupont</td>
                                            <td>12/09/2023</td>
                                            <td>26/09/2023</td>
                                            <td><span class="badge bg-success">En cours</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>1984</td>
                                            <td>Sophie Martin</td>
                                            <td>10/09/2023</td>
                                            <td>24/09/2023</td>
                                            <td><span class="badge bg-warning text-dark">En retard</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Le Petit Prince</td>
                                            <td>Lucie Bernard</td>
                                            <td>15/09/2023</td>
                                            <td>29/09/2023</td>
                                            <td><span class="badge bg-success">En cours</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Harry Potter</td>
                                            <td>Thomas Leroy</td>
                                            <td>05/09/2023</td>
                                            <td>19/09/2023</td>
                                            <td><span class="badge bg-danger">Retourné</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Dune</td>
                                            <td>Émile Petit</td>
                                            <td>14/09/2023</td>
                                            <td>28/09/2023</td>
                                            <td><span class="badge bg-success">En cours</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap & jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Chart for loan activity
        const loanCtx = document.getElementById('loanActivityChart').getContext('2d');
        const loanChart = new Chart(loanCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep'],
                datasets: [{
                    label: 'Nouveaux emprunts',
                    data: [65, 59, 80, 81, 56, 55, 72, 68, 60],
                    backgroundColor: 'rgba(52, 152, 219, 0.2)',
                    borderColor: 'rgba(52, 152, 219, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }, {
                    label: 'Retours',
                    data: [28, 48, 40, 45, 60, 52, 65, 55, 50],
                    backgroundColor: 'rgba(46, 204, 113, 0.2)',
                    borderColor: 'rgba(46, 204, 113, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
        
        // Chart for book categories
        const categoryCtx = document.getElementById('bookCategoryChart').getContext('2d');
        const categoryChart = new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Fiction', 'Science', 'Histoire', 'Biographie', 'Informatique'],
                datasets: [{
                    data: [35, 20, 15, 15, 15],
                    backgroundColor: [
                        'rgba(52, 152, 219, 0.8)',
                        'rgba(46, 204, 113, 0.8)',
                        'rgba(155, 89, 182, 0.8)',
                        'rgba(241, 196, 15, 0.8)',
                        'rgba(230, 126, 34, 0.8)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
        
        // Simple animation for stats cards
        $(document).ready(function() {
            $('.stats-card').hover(
                function() {
                    $(this).css('transform', 'translateY(-5px)');
                },
                function() {
                    $(this).css('transform', 'translateY(0)');
                }
            );
        });
    </script>
</body>
</html>
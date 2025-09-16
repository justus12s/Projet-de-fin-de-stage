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

        /* Sidebar */
        .sidebar {
            background-color: var(--secondary-color);
            color: white;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
            width: 250px;
            transition: all 0.3s;
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

        /* Main content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
        }

        /* Header */
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

        /* Cards */
        .stats-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            transition: transform 0.3s;
        }

        .stats-card:hover { transform: translateY(-5px); }

        .card-books { border-left: 4px solid #3498db; }
        .card-members { border-left: 4px solid #2ecc71; }
        .card-loans { border-left: 4px solid #e67e22; }
        .card-overdue { border-left: 4px solid #e74c3c; }

        /* Charts */
        .chart-container {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        /* Recent table */
        .recent-table {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .badge-success { background-color: var(--success-color); }
        .badge-warning { background-color: #f39c12; }
        .badge-danger { background-color: var(--accent-color); }

        .user-profile img { width: 40px; height: 40px; border-radius: 50%; margin-right: 10px; }

        /* Book cover */
        .book-cover { width: 40px; height: 56px; object-fit: cover; border-radius: 4px; }
        .book-cover-placeholder {
            background: #f8f9fa;
            border: 1px dashed #dee2e6;
            display: flex; align-items: center; justify-content: center; color: #6c757d;
        }
        .table .book-cover{
            margin-right: 15px;
        }


        /* Responsive */
        @media (max-width: 992px) {
            .sidebar { left: -250px; z-index: 999; }
            .sidebar.active { left: 0; }
            .main-content { margin-left: 0; }
            .overlay { display: none; position: fixed; top: 0; left: 0; height: 100%; width: 100%; background: rgba(0,0,0,0.5); z-index: 998; }
            .overlay.active { display: block; }
        }

        @media (max-width: 768px) {
            .stats-card { text-align: center; }
            .chart-container canvas { width: 100% !important; height: auto !important; }
        }
    </style>
</head>
<body>
    <div class="overlay" id="sidebarOverlay"></div>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar d-md-block">
                <div class="text-center mb-4">
                    <h4><i class="fas fa-book-open"></i> BiblioAdmin</h4>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('admin/dashboard/accueil')?>">
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
                            <i class="fas fa-exchange-alt"></i> Emprunts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/dashboard/overdue')?>">
                            <i class="fas fa-clock"></i> Retards
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/dashboard/settings')?>">
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
                <div class="header d-flex justify-content-between align-items-center">
                    <div>
                        <button class="btn btn-outline-secondary d-lg-none me-2" id="sidebarToggle">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h2>Tableau de Bord</h2>
                    </div>
                    <div class="user-profile d-flex align-items-center">
                        <img src="https://ui-avatars.com/api/?name=Admin+User&background=3498db&color=fff" alt="Admin">
                        <span>Administrateur</span>
                    </div>
                </div>

                <!-- Stat cards -->
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

                <!-- Recent activity table -->
                <div class="row">
                    <div class="col-12">
                        <div class="recent-table">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5>Emprunts récents</h5>
                                <a href="<?= base_url('/admin/dashboard/loans') ?>" class="btn btn-sm btn-primary">Voir tout</a>
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
                                        <?php if (!empty($recent_loans) && is_array($recent_loans)): ?>
                                            <?php foreach ($recent_loans as $loan): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <?php 
                                                        $imagePath = 'uploads/books/' . ($loan['cover_image'] ?? '');
                                                        $fullPath = base_url($imagePath);
                                                        $imageExists = !empty($loan['cover_image']) && file_exists(ROOTPATH . 'public/' . $imagePath);
                                                        ?>
                                                        <?php if ($imageExists): ?>
                                                            <img src="<?= $fullPath ?>" 
                                                                alt="Couverture <?= esc($loan['book_title'] ?? 'Livre') ?>"
                                                                class="book-cover mr-3"
                                                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                        <?php endif; ?>
                                                        <div class="book-cover-placeholder mr-3" 
                                                            style="width:40px;height:56px;display: <?= $imageExists ? 'none' : 'flex' ?>; align-items:center; justify-content:center;">
                                                            <i class="fas fa-book text-muted"></i>
                                                        </div>
                                                        <div>
                                                            <strong><?= esc($loan['book_title'] ?? 'Livre inconnu') ?></strong>
                                                            <br><small class="text-muted"><?= esc($loan['author'] ?? '') ?></small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?= esc($loan['first_name'] ?? '') ?> <?= esc($loan['last_name'] ?? '') ?></td>
                                                <td><?= !empty($loan['loan_date']) ? date('d/m/Y', strtotime($loan['loan_date'])) : 'N/A' ?></td>
                                                <td><?= !empty($loan['due_date']) ? date('d/m/Y', strtotime($loan['due_date'])) : 'N/A' ?></td>
                                                <td>
                                                    <?php
                                                    $statusBadge = [
                                                        'active'=>['class'=>'success','text'=>'En cours'],
                                                        'overdue'=>['class'=>'warning','text'=>'En retard'],
                                                        'returned'=>['class'=>'info','text'=>'Retourné'],
                                                        'pending'=>['class'=>'secondary','text'=>'En attente'],
                                                        'cancelled'=>['class'=>'danger','text'=>'Annulé']
                                                    ];
                                                    $status = $loan['status'] ?? 'pending';
                                                    ?>
                                                    <span class="badge bg-<?= $statusBadge[$status]['class'] ?>"><?= $statusBadge[$status]['text'] ?></span>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('/admin/dashboard/loans/view/' . ($loan['id'] ?? '')) ?>" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr><td colspan="6" class="text-center">Aucun emprunt récent</td></tr>
                                        <?php endif; ?>
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
        // Sidebar toggle
        $(document).ready(function(){
            const sidebar = $('.sidebar');
            const overlay = $('#sidebarOverlay');
            $('#sidebarToggle').click(function(){
                sidebar.toggleClass('active');
                overlay.toggleClass('active');
            });
            overlay.click(function(){
                sidebar.removeClass('active');
                overlay.removeClass('active');
            });
        });

        // Charts
        const loanCtx = document.getElementById('loanActivityChart').getContext('2d');
        new Chart(loanCtx, {
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
                },{
                    label: 'Retours',
                    data: [28, 48, 40, 45, 60, 52, 65, 55, 50],
                    backgroundColor: 'rgba(46, 204, 113,0.2)',
                    borderColor: 'rgba(46, 204, 113,1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            }
        });

        const bookCatCtx = document.getElementById('bookCategoryChart').getContext('2d');
        new Chart(bookCatCtx, {
            type: 'doughnut',
            data: {
                labels: ['Fiction','Science','Fantasy','Histoire','Bibliographie','Informatique','Jeunesse','Classiques','Stratégie'],
                datasets: [{
                    data: [12,9,8,10,5,7,6,11,4],
                    backgroundColor:[
                        '#3498db','#2ecc71','#e74c3c','#f1c40f','#9b59b6','#1abc9c','#e67e22','#95a5a6','#34495e'
                    ]
                }]
            }
        });
    </script>
</body>
</html>
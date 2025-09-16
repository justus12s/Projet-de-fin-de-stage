<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Administration Bibliothèque' ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            background-color: var(--secondary-color);
            color: white;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
            width: 250px;
            transition: all 0.3s ease;
            z-index: 1050;
            overflow-y: auto;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            margin: 4px 0;
            border-radius: 4px;
            white-space: nowrap;
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
            transition: all 0.3s ease;
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
            flex-wrap: wrap;
        }

        /* Hamburger button */
        .sidebar-toggle {
            display: none; /* desktop */
            background-color: #f0f0f0; /* gris clair */
            border: 1px solid #ced4da; /* bordure gris */
            border-radius: 6px; /* coins arrondis */
            padding: 10px 12px;
            color: #6c757d; /* icône gris */
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .sidebar-toggle:hover {
            background-color: #e0e0e0; /* gris plus foncé */
            border-color: #adb5bd;
            color: #343a40; /* icône plus foncée */
        }

        .sidebar-toggle i {
            color: inherit; /* icône prend la couleur du bouton */
        }

        /* Affichage sur mobiles */
        @media (max-width: 992px) {
            .sidebar-toggle {
                display: inline-block;
            }

            .sidebar {
                left: -250px;
            }

            .sidebar.active {
                left: 0;
                box-shadow: 3px 0 15px rgba(0,0,0,0.2);
            }

            .main-content {
                margin-left: 0;
            }

            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                width: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 1040;
            }

            .overlay.active {
                display: block;
            }
        }

        /* Other responsive tweaks */
        @media (max-width: 768px) {
            .table th, .table td {
                font-size: 0.85rem;
            }
        }

        .badge-success { background-color: var(--success-color); }
        .badge-warning { background-color: #f39c12; }
        .badge-danger { background-color: var(--accent-color); }
    </style>
</head>
<body>
    <div class="overlay" id="sidebarOverlay"></div>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar d-md-block" id="sidebar">
                <div class="text-center mb-4">
                    <h4><i class="fas fa-book-open"></i> BiblioAdmin</h4>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('admin/dashboard/accueil') ?>">
                            <i class="fas fa-tachometer-alt"></i> Tableau de bord
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('admin/dashboard/books') ?>">
                            <i class="fas fa-book"></i> Livres
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('admin/dashboard/users') ?>">
                            <i class="fas fa-users"></i> Membres
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('admin/dashboard/loans')?>">
                            <i class="fas fa-exchange-alt"></i> Emprunts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('admin/dashboard/overdue')?>">
                            <i class="fas fa-clock"></i> Retards
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/dashboard/settings')?>">
                            <i class="fas fa-cog"></i> Paramètres
                        </a>
                    </li>
                    <li class="nav-item mt-4">
                        <a class="nav-link" href="<?= site_url('logout')?>">
                            <i class="fas fa-sign-out-alt"></i> Déconnexion
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Main content -->
            <div class="col-md-9 col-lg-10 main-content">
                <button class="btn sidebar-toggle d-lg-none">
                    <i class="fas fa-bars"></i>
                </button>
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap & jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const sidebarToggle = document.querySelector('.sidebar-toggle');

        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        });

        overlay.addEventListener('click', function() {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
    });
    </script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
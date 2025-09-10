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
        }
        
        .sidebar {
            background-color: var(--secondary-color);
            color: white;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
            width: 250px;
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
        
        .action-buttons .btn {
            margin-right: 5px;
        }
        
        .book-cover {
            width: 40px;
            height: 56px;
            object-fit: cover;
            border-radius: 4px;
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
        
        .modal-content {
            border-radius: 10px;
            border: none;
        }
        
        .modal-header {
            background-color: var(--primary-color);
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
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
                        <a class="nav-link" href="admin/dashboard/retards">
                            <i class="fas fa-clock"></i> Retards
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin/dashboard/settings">
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
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap & jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script amélioré pour la génération de mot de passe -->
    <script>
    // Fonction pour générer un mot de passe aléatoire
    function generateRandomPassword(length = 12) {
        const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
        let password = "";
        for (let i = 0; i < length; i++) {
            password += charset.charAt(Math.floor(Math.random() * charset.length));
        }
        return password;
    }

    // Fonction pour basculer la visibilité du mot de passe
    function togglePasswordVisibility(fieldId, button) {
        const passwordField = document.getElementById(fieldId);
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            button.innerHTML = '<i class="fas fa-eye-slash"></i>';
        } else {
            passwordField.type = 'password';
            button.innerHTML = '<i class="fas fa-eye"></i>';
        }
    }

    // Initialisation au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion de tous les boutons de génération de mot de passe
        document.querySelectorAll('.generate-password-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const targetField = this.getAttribute('data-target');
                const passwordField = document.getElementById(targetField);
                if (passwordField) {
                    passwordField.value = generateRandomPassword();
                    passwordField.type = 'text';
                    
                    // Mettre à jour le bouton d'œil si présent
                    const toggleBtn = document.querySelector(`[data-toggle="${targetField}"]`);
                    if (toggleBtn) {
                        toggleBtn.innerHTML = '<i class="fas fa-eye-slash"></i>';
                    }
                }
            });
        });

        // Gestion de tous les boutons de basculement de visibilité
        document.querySelectorAll('.toggle-password-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const targetField = this.getAttribute('data-toggle');
                togglePasswordVisibility(targetField, this);
            });
        });

        // Gestion spécifique pour les anciens IDs (rétrocompatibilité)
        const generateBtn = document.getElementById('generatePassword');
        if (generateBtn && !generateBtn.classList.contains('generate-password-btn')) {
            generateBtn.addEventListener('click', function() {
                const passwordField = document.getElementById('password');
                if (passwordField) {
                    passwordField.value = generateRandomPassword();
                    passwordField.type = 'text';
                    
                    // Mettre à jour le bouton d'œil si présent
                    const toggleBtn = document.getElementById('togglePassword');
                    if (toggleBtn) {
                        toggleBtn.innerHTML = '<i class="fas fa-eye-slash"></i>';
                    }
                }
            });
        }

        const toggleBtn = document.getElementById('togglePassword');
        if (toggleBtn && !toggleBtn.classList.contains('toggle-password-btn')) {
            toggleBtn.addEventListener('click', function() {
                const passwordField = document.getElementById('password');
                if (passwordField) {
                    togglePasswordVisibility('password', this);
                }
            });
        }
    });
    </script>

    <?= $this->renderSection('scripts') ?>
    
</body>
</html>
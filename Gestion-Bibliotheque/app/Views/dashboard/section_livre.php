<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Livres - Administration Bibliothèque</title>
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
            z-index: 1000;
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
        
        /* Mobile optimizations */
        @media (max-width: 992px) {
            .sidebar { 
                left: -250px; 
                z-index: 1000; 
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
                z-index: 999; 
            }
            
            .overlay.active { 
                display: block; 
            }
            
            .header {
                padding: 12px 15px;
            }
            
            .header h2 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .recent-table {
                padding: 15px;
                overflow-x: auto;
            }
            
            .table {
                font-size: 0.9rem;
            }
            
            .user-profile span {
                display: none;
            }
            
            .d-flex.justify-content-between.align-items-center.mb-4 {
                flex-direction: column;
                align-items: flex-start !important;
            }
            
            .d-flex.justify-content-between.align-items-center.mb-4 h3 {
                margin-bottom: 15px;
            }
            
            .action-buttons {
                display: flex;
                flex-wrap: nowrap;
            }
            
            .action-buttons .btn {
                margin-right: 3px;
                padding: 0.25rem 0.5rem;
            }
            
            .action-buttons .btn i {
                margin-right: 0;
            }
            
            .action-buttons .btn span {
                display: none;
            }
        }
        
        @media (max-width: 576px) {
            .main-content {
                padding: 15px 10px;
            }
            
            .header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .header h2 {
                margin-bottom: 10px;
            }
            
            .recent-table {
                padding: 12px;
            }
            
            .table th, .table td {
                padding: 0.5rem;
            }
            
            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.8rem;
            }
            
            .book-cover {
                width: 30px;
                height: 42px;
            }
            
            /* Adjust filter and search layout */
            .row.mb-4 > div {
                margin-bottom: 10px;
            }
            
            /* Hide some table columns on very small screens */
            .isbn-column, .category-column {
                display: none;
            }
        }
        
        /* For very small devices */
        @media (max-width: 360px) {
            .header {
                padding: 10px;
            }
            
            .header h2 {
                font-size: 1.3rem;
            }
            
            .recent-table h5 {
                font-size: 1.1rem;
            }
            
            .table {
                font-size: 0.8rem;
            }
            
            .action-buttons .btn {
                padding: 0.2rem 0.4rem;
            }
        }
        
        /* Improve touch targets for mobile */
        .nav-link, .btn {
            touch-action: manipulation;
        }
        
        /* Prevent horizontal scrolling */
        html, body {
            max-width: 100%;
            overflow-x: hidden;
        }
        
        /* Toggle sidebar button for mobile */
        .sidebar-toggle {
            display: none;
        }
        
        @media (max-width: 992px) {
            .sidebar-toggle {
                display: inline-block;
            }
        }
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
                        <a class="nav-link active" href="<?= site_url('admin/dashboard/books') ?>">
                            <i class="fas fa-book"></i> Livres
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('admin/dashboard/users') ?>">
                            <i class="fas fa-users"></i> Membres
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('admin/dashboard/loans') ?>">
                            <i class="fas fa-exchange-alt"></i> Emprunts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('admin/dashboard/overdue') ?>">
                            <i class="fas fa-clock"></i> Retards
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/dashboard/settings') ?>">
                            <i class="fas fa-cog"></i> Paramètres
                        </a>
                    </li>
                    <li class="nav-item mt-4">
                        <a class="nav-link" href="<?= site_url('logout') ?>">
                            <i class="fas fa-sign-out-alt"></i> Déconnexion
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Main content -->
            <div class="col-md-9 col-lg-10 main-content">
                <!-- Messages de notification -->
                <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h5>Veuillez corriger les erreurs suivantes :</h5>
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
                
                <!-- Header -->
                <div class="header">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-outline-secondary sidebar-toggle me-2" id="sidebarToggle">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h2 class="mb-0"><i class="fas fa-book me-2"></i> Gestion des Livres</h2>
                    </div>
                    <div class="user-profile d-flex align-items-center">
                        <img src="https://ui-avatars.com/api/?name=Admin+User&background=3498db&color=fff" alt="Admin">
                        <span>Administrateur</span>
                    </div>
                </div>
                
                <!-- Books Section -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3>Catalogue des Livres</h3>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBookModal">
                        <i class="fas fa-plus"></i> <span class="d-none d-md-inline">Ajouter un livre</span>
                    </button>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6 mb-2">
                        <div class="input-group">
                            <input type="text" class="form-control" id="searchInput" placeholder="Rechercher un livre par titre, auteur ou ISBN...">
                            <button class="btn btn-outline-secondary" type="button" id="searchButton">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <select class="form-select" id="categoryFilter">
                            <option selected>Toutes les catégories</option>
                            <option>Fiction</option>
                            <option>Science-Fiction</option>
                            <option>Fantasy</option>
                            <option>Histoire</option>
                            <option>Biographie</option>
                            <option>Informatique</option>
                            <option>Jeunesse</option>
                            <option>Classique</option>
                            <option>Stratégie</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <select class="form-select" id="sortSelect">
                            <option selected>Trier par</option>
                            <option value="title_asc">Titre (A-Z)</option>
                            <option value="title_desc">Titre (Z-A)</option>
                            <option value="author_asc">Auteur (A-Z)</option>
                            <option value="recent">Plus récents</option>
                        </select>
                    </div>
                </div>
                
                <div class="recent-table">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Couverture</th>
                                    <th>Titre</th>
                                    <th>Auteur</th>
                                    <th class="isbn-column">ISBN</th>
                                    <th class="category-column">Catégorie</th>
                                    <th>Disponibilité</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($books)): ?>
                                    <?php foreach ($books as $book): ?>
                                    <tr>
                                        <td>
                                            <?php
                                            // Déterminer le chemin de l'image
                                            $coverPath = '';
                                            if (!empty($book['cover_image'])) {
                                                // Vérifier si c'est l'image par défaut
                                                if ($book['cover_image'] === 'default-cover.jpg') {
                                                    $coverPath = base_url('uploads/books/default-cover.jpg');
                                                } 
                                                // Vérifier si l'image uploadée existe
                                                else {
                                                    $absolutePath = ROOTPATH . 'public/uploads/books/' . $book['cover_image'];
                                                    if (file_exists($absolutePath)) {
                                                        $coverPath = base_url('uploads/books/' . $book['cover_image']);
                                                    } else {
                                                        // Si l'image n'existe pas, utiliser l'image par défaut
                                                        $coverPath = base_url('uploads/books/default-cover.jpg');
                                                    }
                                                }
                                            } else {
                                                // Si aucun nom d'image, utiliser l'image par défaut
                                                $coverPath = base_url('uploads/books/default-cover.jpg');
                                            }
                                            ?>
                                            
                                            <img src="<?= $coverPath ?>" 
                                                alt="<?= esc($book['title']) ?>" 
                                                class="book-cover"
                                                style="width: 40px; height: 56px; object-fit: cover;"
                                                onerror="this.src='<?= base_url('uploads/books/default-cover.jpg') ?>'">
                                        </td>
                                        <td><?= esc($book['title']) ?></td>
                                        <td><?= esc($book['author']) ?></td>
                                        <td class="isbn-column"><?= esc($book['isbn'] ?? 'N/A') ?></td>
                                        <td class="category-column"><?= esc($book['category'] ?? 'Non spécifiée') ?></td>
                                        <td>
                                            <?php if ($book['available'] > 0): ?>
                                                <span class="badge bg-success">Disponible (<?= $book['available'] ?>)</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Indisponible</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="action-buttons">
                                            <!-- Bouton Voir -->
                                            <a href="<?= site_url('admin/dashboard/books/view/' . $book['id']) ?>" 
                                            class="btn btn-sm btn-outline-primary"
                                            title="Voir les détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            <!-- Bouton Modifier -->
                                            <a href="<?= site_url('admin/dashboard/books/edit/' . $book['id']) ?>" 
                                            class="btn btn-sm btn-outline-warning"
                                            title="Modifier le livre">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Bouton de suppression de livre -->
                                            <form action="<?= site_url('admin/dashboard/books/delete/' . $book['id']) ?>" 
                                                method="GET"
                                                style="display: inline-block;"
                                                onsubmit="return confirm('Supprimer le livre <?= addslashes($book['title']) ?> ?')"
                                                id="deleteForm-<?= $book['id'] ?>">                                                                              
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        title="Supprimer le livre"
                                                        onclick="console.log('Delete submitted for ID: <?= $book['id'] ?>')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Aucun livre trouvé</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Précédent</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Suivant</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Book Modal -->
    <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBookModalLabel"><i class="fas fa-plus-circle me-2"></i> Ajouter un nouveau livre</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= site_url('admin/dashboard/books/create') ?>" method="POST" enctype="multipart/form-data">

                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />                      
                       
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Titre du livre *</label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           value="<?= old('title') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="author" class="form-label">Auteur *</label>
                                    <input type="text" class="form-control" id="author" name="author" 
                                           value="<?= old('author') ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="isbn" class="form-label">ISBN</label>
                                    <input type="text" class="form-control" id="isbn" name="isbn" 
                                           value="<?= old('isbn') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Catégorie</label>
                                    <select class="form-select" id="category" name="category">
                                        <option value="">Sélectionner une catégorie</option>
                                        <option value="Fiction" <?= old('category') == 'Fiction' ? 'selected' : '' ?>>Fiction</option>
                                        <option value="Science-Fiction" <?= old('category') == 'Science-Fiction' ? 'selected' : '' ?>>Science-Fiction</option>
                                        <option value="Fantasy" <?= old('category') == 'Fantasy' ? 'selected' : '' ?>>Fantasy</option>
                                        <option value="Histoire" <?= old('category') == 'Histoire' ? 'selected' : '' ?>>Histoire</option>
                                        <option value="Biographie" <?= old('category') == 'Biographie' ? 'selected' : '' ?>>Biographie</option>
                                        <option value="Informatique" <?= old('category') == 'Informatique' ? 'selected' : '' ?>>Informatique</option>
                                        <option value="Jeunesse" <?= old('category') == 'Jeunesse' ? 'selected' : '' ?>>Jeunesse</option>
                                        <option value="Classique" <?= old('category') == 'Classique' ? 'selected' : '' ?>>Classique</option>
                                        <option value="Stratégie" <?= old('category') == 'Stratégie' ? 'selected' : '' ?>>Stratégie</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?= old('description') ?></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="publish_year" class="form-label">Année de publication</label>
                                    <input type="number" class="form-control" id="publish_year" name="publish_year" 
                                           value="<?= old('publish_year') ?>" min="1900" max="<?= date('Y') ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="publisher" class="form-label">Éditeur</label>
                                    <input type="text" class="form-control" id="publisher" name="publisher" 
                                           value="<?= old('publisher') ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Quantité *</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" 
                                           value="<?= old('quantity', 1) ?>" min="1" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="cover_image" class="form-label">Couverture du livre</label>
                            <input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/*">
                            <div class="form-text">Formats acceptés: JPG, PNG, GIF. Taille max: 2MB</div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Ajouter le livre</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap & jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function() {
            const sidebar = $('#sidebar');
            const overlay = $('#sidebarOverlay');
            
            // Sidebar toggle
            $('#sidebarToggle').click(function(){
                sidebar.toggleClass('active');
                overlay.toggleClass('active');
            });
            
            overlay.click(function(){
                sidebar.removeClass('active');
                overlay.removeClass('active');
            });
            
            // Close sidebar when clicking on a link (mobile)
            $('.sidebar .nav-link').click(function() {
                if ($(window).width() < 992) {
                    sidebar.removeClass('active');
                    overlay.removeClass('active');
                }
            });
            
            // Function to handle book search
            $('#searchButton').on('click', function() {
                const searchTerm = $('#searchInput').val().toLowerCase();
                $('table tbody tr').each(function() {
                    const title = $(this).find('td:eq(1)').text().toLowerCase();
                    const author = $(this).find('td:eq(2)').text().toLowerCase();
                    const isbn = $(this).find('td:eq(3)').text().toLowerCase();
                    if (title.includes(searchTerm) || author.includes(searchTerm) || isbn.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
            
            // Category filter functionality
            $('#categoryFilter').on('change', function() {
                const category = $(this).val();
                if (category === "Toutes les catégories") {
                    $('table tbody tr').show();
                } else {
                    $('table tbody tr').each(function() {
                        const bookCategory = $(this).find('td:eq(4)').text();
                        if (bookCategory === category) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                }
            });
            
            // Clear form when modal is closed
            $('#addBookModal').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset();
            });
            
            // Auto-close alerts after 5 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
            
            // Adjust table columns based on screen size
            function adjustTableColumns() {
                if ($(window).width() < 576) {
                    $('.isbn-column, .category-column').hide();
                } else {
                    $('.isbn-column, .category-column').show();
                }
            }
            
            // Run on load and resize
            adjustTableColumns();
            $(window).resize(adjustTableColumns);
        });
    </script>
</body>
</html>
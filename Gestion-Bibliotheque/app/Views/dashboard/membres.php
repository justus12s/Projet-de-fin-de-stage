<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Membres - Administration Bibliothèque</title>
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
        .badge-secondary { background-color: #7f8c8d; }
        
        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        
        .action-buttons .btn {
            margin-right: 5px;
        }
        
        .member-avatar {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
        }
        
        .stats-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            text-align: center;
        }
        
        .stats-card i {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        
        .card-members { border-left: 4px solid #2ecc71; }
        .card-active { border-left: 4px solid #3498db; }
        .card-overdue { border-left: 4px solid #e74c3c; }
        
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
                        <a class="nav-link" href="<?= base_url('admin/dashboard/accueil')?>">
                            <i class="fas fa-tachometer-alt"></i> Tableau de bord
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/dashoboard/section_livre')?>">
                            <i class="fas fa-book"></i> Livres
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('admin/dashboard/membres')?>">
                            <i class="fas fa-users"></i> Membres
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-exchange-alt"></i> Emprunts
                        </a>
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
                        <a class="nav-link" href="#">
                            <i class="fas fa-sign-out-alt"></i> Déconnexion
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Main content -->
            <div class="col-md-9 col-lg-10 main-content">
                <!-- Header -->
                <div class="header">
                    <h2><i class="fas fa-users me-2"></i> Gestion des Membres</h2>
                    <div class="d-flex align-items-center">
                        <div class="user-profile d-flex align-items-center">
                            <img src="https://ui-avatars.com/api/?name=Admin+User&background=3498db&color=fff" alt="Admin">
                            <span>Administrateur</span>
                        </div>
                    </div>
                </div>
                
                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-xl-4 col-md-6">
                        <div class="stats-card card-members">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">MEMBRES TOTAUX</h6>
                                    <h3>1,248</h3>
                                    <span class="text-success"><i class="fas fa-arrow-up"></i> 8%</span> depuis le mois dernier
                                </div>
                                <i class="fas fa-users text-success"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="stats-card card-active">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">MEMBRES ACTIFS</h6>
                                    <h3>982</h3>
                                    <span class="text-success"><i class="fas fa-arrow-up"></i> 5%</span> depuis le mois dernier
                                </div>
                                <i class="fas fa-user-check text-primary"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="stats-card card-overdue">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">RETARDS ACTIFS</h6>
                                    <h3>42</h3>
                                    <span class="text-danger"><i class="fas fa-arrow-up"></i> 12%</span> depuis le mois dernier
                                </div>
                                <i class="fas fa-clock text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Members Section -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3>Liste des Membres</h3>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                        <i class="fas fa-plus"></i> Ajouter un membre
                    </button>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Rechercher un membre par nom, email...">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select">
                            <option selected>Tous les statuts</option>
                            <option>Actif</option>
                            <option>Inactif</option>
                            <option>Avec retards</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select">
                            <option selected>Trier par</option>
                            <option>Nom (A-Z)</option>
                            <option>Nom (Z-A)</option>
                            <option>Plus récents</option>
                        </select>
                    </div>
                </div>
                
                <div class="recent-table">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Membre</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Date d'inscription</th>
                                    <th>Emprunts en cours</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=Martin+Dupont&background=3498db&color=fff" alt="Martin Dupont" class="member-avatar">
                                            <div>Martin Dupont</div>
                                        </div>
                                    </td>
                                    <td>martin.dupont@email.com</td>
                                    <td>06 12 34 56 78</td>
                                    <td>12/01/2023</td>
                                    <td>2</td>
                                    <td><span class="badge bg-success">Actif</span></td>
                                    <td class="action-buttons">
                                        <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=Sophie+Martin&background=e74c3c&color=fff" alt="Sophie Martin" class="member-avatar">
                                            <div>Sophie Martin</div>
                                        </div>
                                    </td>
                                    <td>sophie.martin@email.com</td>
                                    <td>06 98 76 54 32</td>
                                    <td>23/02/2023</td>
                                    <td>1</td>
                                    <td><span class="badge bg-warning text-dark">Retard</span></td>
                                    <td class="action-buttons">
                                        <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=Lucie+Bernard&background=2ecc71&color=fff" alt="Lucie Bernard" class="member-avatar">
                                            <div>Lucie Bernard</div>
                                        </div>
                                    </td>
                                    <td>lucie.bernard@email.com</td>
                                    <td>07 65 43 21 09</td>
                                    <td>05/03/2023</td>
                                    <td>3</td>
                                    <td><span class="badge bg-success">Actif</span></td>
                                    <td class="action-buttons">
                                        <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=Thomas+Leroy&background=f39c12&color=fff" alt="Thomas Leroy" class="member-avatar">
                                            <div>Thomas Leroy</div>
                                        </div>
                                    </td>
                                    <td>thomas.leroy@email.com</td>
                                    <td>06 11 22 33 44</td>
                                    <td>18/04/2023</td>
                                    <td>0</td>
                                    <td><span class="badge bg-secondary">Inactif</span></td>
                                    <td class="action-buttons">
                                        <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=Émile+Petit&background=9b59b6&color=fff" alt="Émile Petit" class="member-avatar">
                                            <div>Émile Petit</div>
                                        </div>
                                    </td>
                                    <td>emile.petit@email.com</td>
                                    <td>06 55 66 77 88</td>
                                    <td>30/05/2023</td>
                                    <td>1</td>
                                    <td><span class="badge bg-success">Actif</span></td>
                                    <td class="action-buttons">
                                        <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=Claire+Fontaine&background=16a085&color=fff" alt="Claire Fontaine" class="member-avatar">
                                            <div>Claire Fontaine</div>
                                        </div>
                                    </td>
                                    <td>claire.fontaine@email.com</td>
                                    <td>06 44 55 66 77</td>
                                    <td>15/06/2023</td>
                                    <td>2</td>
                                    <td><span class="badge bg-success">Actif</span></td>
                                    <td class="action-buttons">
                                        <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=Antoine+Moreau&background=34495e&color=fff" alt="Antoine Moreau" class="member-avatar">
                                            <div>Antoine Moreau</div>
                                        </div>
                                    </td>
                                    <td>antoine.moreau@email.com</td>
                                    <td>07 12 23 34 45</td>
                                    <td>22/07/2023</td>
                                    <td>4</td>
                                    <td><span class="badge bg-warning text-dark">Retard</span></td>
                                    <td class="action-buttons">
                                        <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
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

    <!-- Add Member Modal -->
    <div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMemberModalLabel"><i class="fas fa-user-plus me-2"></i> Ajouter un nouveau membre</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="memberFirstName" class="form-label">Prénom *</label>
                                    <input type="text" class="form-control" id="memberFirstName" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="memberLastName" class="form-label">Nom *</label>
                                    <input type="text" class="form-control" id="memberLastName" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="memberEmail" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="memberEmail" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="memberPhone" class="form-label">Téléphone</label>
                                    <input type="tel" class="form-control" id="memberPhone">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="memberAddress" class="form-label">Adresse</label>
                            <textarea class="form-control" id="memberAddress" rows="2"></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="memberPostalCode" class="form-label">Code postal</label>
                                    <input type="text" class="form-control" id="memberPostalCode">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="memberCity" class="form-label">Ville</label>
                                    <input type="text" class="form-control" id="memberCity">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="memberCountry" class="form-label">Pays</label>
                                    <input type="text" class="form-control" id="memberCountry" value="France">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="memberBirthdate" class="form-label">Date de naissance</label>
                                    <input type="date" class="form-control" id="memberBirthdate">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="memberRegistrationDate" class="form-label">Date d'inscription *</label>
                                    <input type="date" class="form-control" id="memberRegistrationDate" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="memberPhoto" class="form-label">Photo de profil</label>
                            <input type="file" class="form-control" id="memberPhoto" accept="image/*">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary">Ajouter le membre</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap & jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Function to handle member search
            $('.btn-outline-secondary').on('click', function() {
                const searchTerm = $(this).siblings('input').val().toLowerCase();
                $('table tbody tr').each(function() {
                    const name = $(this).find('td:eq(0)').text().toLowerCase();
                    const email = $(this).find('td:eq(1)').text().toLowerCase();
                    
                    if (name.includes(searchTerm) || email.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
            
            // Status filter functionality
            $('.form-select').eq(0).on('change', function() {
                const status = $(this).val();
                if (status === "Tous les statuts") {
                    $('table tbody tr').show();
                } else {
                    $('table tbody tr').each(function() {
                        const memberStatus = $(this).find('td:eq(5)').text();
                        if ((status === "Actif" && memberStatus === "Actif") || 
                            (status === "Inactif" && memberStatus === "Inactif") ||
                            (status === "Avec retards" && memberStatus === "Retard")) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                }
            });
            
            // Sort functionality
            $('.form-select').eq(1).on('change', function() {
                // This would typically be handled server-side
                alert('Fonctionnalité de tri à implémenter côté serveur');
            });
            
            // Set today's date as default for registration date
            const today = new Date().toISOString().split('T')[0];
            $('#memberRegistrationDate').val(today);
        });
    </script>
</body>
</html>
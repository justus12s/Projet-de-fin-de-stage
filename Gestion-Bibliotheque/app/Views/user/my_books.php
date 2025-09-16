<?= $this->extend('user/layout') ?>

<?= $this->section('content') ?>
<div class="container mt-3 mt-md-4">
    <!-- En-tête -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <h2 class="mb-3 mb-md-0">Mes Emprunts</h2>
        <div>
            <a href="<?= site_url('books') ?>" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Nouvel Emprunt
            </a>
        </div>
    </div>

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

    <!-- Cartes de statistiques -->
    <div class="row mb-4">
        <div class="col-6 col-md-3 mb-3">
            <div class="card text-white bg-primary text-center p-2 p-md-3 h-100">
                <h5 class="mb-1"><?= $stats['active_loans'] ?? 0 ?></h5>
                <p class="mb-0 small">Emprunts actifs</p>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="card text-white bg-success text-center p-2 p-md-3 h-100">
                <h5 class="mb-1"><?= $stats['returned_loans'] ?? 0 ?></h5>
                <p class="mb-0 small">Retournés</p>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="card text-white bg-warning text-center p-2 p-md-3 h-100">
                <h5 class="mb-1"><?= $stats['overdue_loans'] ?? 0 ?></h5>
                <p class="mb-0 small">En retard</p>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="card text-white bg-info text-center p-2 p-md-3 h-100">
                <h5 class="mb-1"><?= $stats['total_loans'] ?? 0 ?></h5>
                <p class="mb-0 small">Total</p>
            </div>
        </div>
    </div>

    <!-- Section limites d'emprunt -->
    <?php if (isset($settings)): ?>
    <div class="alert alert-info mb-4">
        <i class="fas fa-info-circle me-2"></i>
        <div>
            <strong>Vos limites d'emprunt :</strong><br>
            • Emprunts actuels : <strong><?= $stats['active_loans'] ?? 0 ?></strong> livre(s)<br>
            • Limite maximale : <strong><?= $settings['max_books'] ?? 3 ?></strong> livre(s) simultané(s)<br>
            • Vous pouvez encore emprunter : <strong><?= $settings['remaining_loans'] ?></strong> livre(s)
        </div>
    </div>
    <?php endif; ?>

    <div class="row">
        <!-- Mes emprunts en cours -->
        <div class="col-12 col-lg-8 mb-4 mb-lg-0">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-book-open me-2"></i>Mes Emprunts en Cours</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($active_loans)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="d-none d-md-table-header-group">
                                    <tr>
                                        <th>Livre</th>
                                        <th>Date emprunt</th>
                                        <th>Retour prévu</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($active_loans as $loan): ?>
                                    <tr class="align-middle">
                                        <td>
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
                                                <div>
                                                    <strong class="d-block"><?= esc($loan['title']) ?></strong>
                                                    <small class="text-muted"><?= esc($loan['author']) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            <span class="small"><?= date('d/m/Y', strtotime($loan['loan_date'])) ?></span>
                                        </td>
                                        <td>
                                            <span class="d-block"><?= date('d/m/Y', strtotime($loan['due_date'])) ?></span>
                                            <?php if ($loan['status'] === 'overdue'): ?>
                                                <span class="badge bg-danger mt-1">En retard</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            <span class="badge bg-<?= $loan['status'] === 'active' ? 'success' : 'danger' ?>">
                                                <?= $loan['status'] === 'active' ? 'En cours' : 'En retard' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="<?= site_url('loan/view/' . $loan['id']) ?>" class="btn btn-info btn-sm" title="Voir détails">
                                                    <i class="fas fa-eye"></i>
                                                    <span class="d-none d-md-inline">Détails</span>
                                                </a>
                                                <?php if ($loan['status'] === 'active'): ?>
                                                    <form action="<?= site_url('loan/return/' . $loan['id']) ?>" method="post" class="d-inline">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="btn btn-success btn-sm" 
                                                                onclick="return confirm('Retourner ce livre ?')" title="Retourner">
                                                            <i class="fas fa-undo"></i>
                                                            <span class="d-none d-md-inline">Retourner</span>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                            <h5>Aucun emprunt en cours</h5>
                            <p class="text-muted">Vous n'avez aucun livre emprunté pour le moment.</p>
                            <a href="<?= site_url('books') ?>" class="btn btn-primary mt-2">
                                <i class="fas fa-book"></i> Emprunter un livre
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar droite - Livres disponibles et actions -->
        <div class="col-12 col-lg-4">
            <!-- Livres disponibles pour nouvel emprunt -->
            <div class="card mb-3">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-check-circle me-2"></i>Livres Disponibles</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($available_books)): ?>
                        <div class="list-group">
                            <?php foreach ($available_books as $book): ?>
                            <div class="list-group-item">
                                <div class="d-flex align-items-center mb-2">
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
                                        <p class="mb-1 text-muted small"><?= esc($book['author']) ?></p>
                                        <small class="text-success">
                                            <i class="fas fa-check-circle"></i> Disponible
                                        </small>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <a href="<?= site_url('books/borrow/' . $book['id']) ?>" class="btn btn-primary btn-sm w-100">
                                        <i class="fas fa-bookmark me-1"></i> Emprunter
                                    </a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="<?= site_url('books') ?>" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-search me-1"></i> Voir tous les livres
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-3">
                            <i class="fas fa-book fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-2">Aucun livre disponible</p>
                            <a href="<?= site_url('books') ?>" class="btn btn-sm btn-outline-primary">
                                Explorer le catalogue
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-bolt me-2"></i>Actions Rapides</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?= site_url('books') ?>" class="btn btn-outline-primary text-start">
                            <i class="fas fa-search me-2"></i> Rechercher un livre
                        </a>
                        <a href="<?= site_url('history') ?>" class="btn btn-outline-info text-start">
                            <i class="fas fa-history me-2"></i> Mon historique
                        </a>
                        <a href="<?= site_url('my-reservations') ?>" class="btn btn-outline-warning text-start">
                            <i class="fas fa-calendar-check me-2"></i> Mes réservations
                        </a>
                        <a href="<?= site_url('profile') ?>" class="btn btn-outline-secondary text-start">
                            <i class="fas fa-user me-2"></i> Mon profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Styles responsives */
@media (max-width: 768px) {
    .book-cover, .book-cover-placeholder {
        width: 35px;
        height: 50px;
    }
    
    .card-header h5 {
        font-size: 1.1rem;
    }
    
    .table-responsive {
        border-radius: 0.375rem;
        border: 1px solid #dee2e6;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }
    
    .alert {
        padding: 1rem;
    }
}

@media (max-width: 576px) {
    h2 {
        font-size: 1.5rem;
    }
    
    .card {
        margin-bottom: 1rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .list-group-item {
        padding: 0.75rem;
    }
    
    .btn {
        font-size: 0.9rem;
    }
    
    .book-cover, .book-cover-placeholder {
        width: 30px;
        height: 42px;
    }
}

/* Améliorations visuelles */
.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.list-group-item {
    transition: background-color 0.2s ease;
}

.list-group-item:hover {
    background-color: #f8f9fa;
}

.btn {
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

/* Style pour les statistiques */
.card.text-white {
    transition: transform 0.2s ease;
}

.card.text-white:hover {
    transform: scale(1.05);
}
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Fonction pour confirmer le retour
function confirmReturn(loanId) {
    if (confirm('Êtes-vous sûr de vouloir retourner ce livre ?')) {
        fetch(`/loan/return/${loanId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Livre retourné avec succès !');
                location.reload();
            } else {
                alert('Erreur: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors du retour du livre');
        });
    }
}

// Animation pour le chargement
document.addEventListener('DOMContentLoaded', function() {
    // Animation des cartes de statistiques
    const statCards = document.querySelectorAll('.card.text-white');
    statCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 100 + (index * 150));
    });
});
</script>
<?= $this->endSection() ?>
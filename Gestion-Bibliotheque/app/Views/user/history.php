<?= $this->extend('user/layout') ?>

<?= $this->section('content') ?>
<div class="container mt-3 mt-md-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                        <h4 class="mb-2 mb-md-0">Mon Historique</h4>
                        <span class="badge bg-primary mt-2 mt-md-0"><?= count($loan_history) ?> emprunt(s)</span>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($loan_history)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="d-none d-md-table-header-group">
                                    <tr>
                                        <th>Livre</th>
                                        <th>Date d'emprunt</th>
                                        <th>Date de retour</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($loan_history as $loan): ?>
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
                                            <?= date('d/m/Y', strtotime($loan['loan_date'])) ?>
                                        </td>
                                        <td>
                                            <?php if ($loan['return_date']): ?>
                                                <?= date('d/m/Y', strtotime($loan['return_date'])) ?>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php
                                            $statusBadge = [
                                                'active' => ['bg-success', 'En cours'],
                                                'overdue' => ['bg-warning', 'En retard'],
                                                'returned' => ['bg-info', 'Retourné'],
                                                'pending' => ['bg-secondary', 'En attente'],
                                                'cancelled' => ['bg-danger', 'Annulé']
                                            ];
                                            $statusClass = $statusBadge[$loan['status']][0] ?? 'bg-secondary';
                                            $statusText = $statusBadge[$loan['status']][1] ?? 'Inconnu';
                                            ?>
                                            <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary w-100 w-md-auto" 
                                                    onclick="viewLoan(<?= $loan['id'] ?>)">
                                                <i class="fas fa-eye d-md-none"></i>
                                                <span class="d-none d-md-inline"><i class="fas fa-eye me-1"></i> Détails</span>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <nav aria-label="Page navigation" class="mt-4">
                            <ul class="pagination justify-content-center flex-wrap">
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
                    <?php else: ?>
                        <div class="text-center py-4 py-md-5">
                            <i class="fas fa-history fa-3x fa-4x text-muted mb-3"></i>
                            <h5>Aucun historique d'emprunt</h5>
                            <p class="text-muted mb-3">Vous n'avez encore effectué aucun emprunt.</p>
                            <a href="<?= site_url('books') ?>" class="btn btn-primary">
                                <i class="fas fa-book me-1"></i> Découvrir les livres
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Styles responsives */
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

@media (max-width: 767.98px) {
    .book-cover, .book-cover-placeholder {
        width: 35px;
        height: 50px;
    }
    
    .card-header h4 {
        font-size: 1.25rem;
    }
    
    .table-responsive {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }
    
    .badge {
        font-size: 0.75em;
    }
}

@media (max-width: 575.98px) {
    .container {
        padding-left: 12px;
        padding-right: 12px;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .book-cover, .book-cover-placeholder {
        width: 30px;
        height: 42px;
    }
    
    .pagination .page-link {
        padding: 0.375rem 0.5rem;
        font-size: 0.8rem;
        margin: 2px;
    }
    
    .fa-4x {
        font-size: 3em;
    }
}

/* Améliorations pour mobile */
@media (max-width: 767.98px) {
    tr {
        display: block;
        margin-bottom: 1rem;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 1rem;
    }
    
    td {
        display: block;
        border: none;
        padding: 0.5rem 0;
    }
    
    td:before {
        content: attr(data-label);
        font-weight: bold;
        display: block;
        margin-bottom: 0.25rem;
        color: #6c757d;
        font-size: 0.8rem;
    }
    
    /* Masquer les colonnes inutiles sur mobile */
    .d-none.d-md-table-cell {
        display: none !important;
    }
}

/* Animation douce */
.card {
    transition: box-shadow 0.2s ease;
}

.card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.btn {
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-1px);
}
</style>

<script>
function viewLoan(loanId) {
    window.location.href = `<?= site_url('loan/view/') ?>${loanId}`;
}

// Ajouter des labels pour l'affichage mobile
document.addEventListener('DOMContentLoaded', function() {
    if (window.innerWidth < 768) {
        const headers = ['Livre', 'Date d\'emprunt', 'Date de retour', 'Statut', 'Actions'];
        const cells = document.querySelectorAll('tbody td');
        
        cells.forEach((cell, index) => {
            const headerIndex = index % 5;
            cell.setAttribute('data-label', headers[headerIndex]);
        });
    }
});
</script>
<?= $this->endSection() ?>
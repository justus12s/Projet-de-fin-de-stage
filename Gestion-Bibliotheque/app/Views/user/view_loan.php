<?= $this->extend('user/layout') ?>

<?= $this->section('content') ?>
<div class="container mt-3 mt-md-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                        <h4 class="mb-2 mb-md-0">Détails de mon Emprunt</h4>
                        <a href="<?= site_url('history') ?>" class="btn btn-sm btn-outline-secondary mt-2 mt-md-0">
                            <i class="fas fa-arrow-left me-1"></i> Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Informations du livre -->
                        <div class="col-12 col-lg-5 mb-4 mb-lg-0">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-book me-2"></i>Informations du Livre</h6>
                                </div>
                                <div class="card-body text-center">
                                    <?php if (!empty($loan['cover_image'])): ?>
                                        <img src="<?= base_url('uploads/books/' . $loan['cover_image']) ?>" 
                                             class="img-fluid rounded mb-3" 
                                             alt="<?= esc($loan['title']) ?>"
                                             style="max-height: 250px;">
                                    <?php else: ?>
                                        <div class="py-4 py-md-5 bg-light rounded mb-3">
                                            <i class="fas fa-book fa-4x text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <h5><?= esc($loan['title']) ?></h5>
                                    <p class="text-muted"><?= esc($loan['author']) ?></p>
                                    
                                    <?php if (!empty($loan['isbn'])): ?>
                                        <p class="mb-2"><strong>ISBN:</strong> <?= esc($loan['isbn']) ?></p>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($loan['description'])): ?>
                                        <div class="mt-3">
                                            <h6>Description:</h6>
                                            <p class="text-muted small"><?= nl2br(esc($loan['description'])) ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Détails de l'emprunt -->
                        <div class="col-12 col-lg-7">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Détails de l'Emprunt</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-12 col-sm-6 mb-3 mb-sm-0">
                                            <strong>Statut:</strong><br>
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
                                            <span class="badge <?= $statusClass ?> mt-1"><?= $statusText ?></span>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <strong>Référence:</strong><br>
                                            <span class="text-muted">#EMP<?= str_pad($loan['id'], 6, '0', STR_PAD_LEFT) ?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-12 col-sm-6 mb-3 mb-sm-0">
                                            <strong>Date d'emprunt:</strong><br>
                                            <?= date('d/m/Y', strtotime($loan['loan_date'])) ?>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <strong>Retour prévu:</strong><br>
                                            <?= date('d/m/Y', strtotime($loan['due_date'])) ?>
                                        </div>
                                    </div>
                                    
                                    <?php if ($loan['return_date']): ?>
                                    <div class="row mb-3">
                                        <div class="col-12 col-sm-6 mb-3 mb-sm-0">
                                            <strong>Date de retour:</strong><br>
                                            <?= date('d/m/Y', strtotime($loan['return_date'])) ?>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <strong>Durée:</strong><br>
                                            <?php
                                            $start = new DateTime($loan['loan_date']);
                                            $end = new DateTime($loan['return_date']);
                                            $diff = $start->diff($end);
                                            echo $diff->days . ' jour(s)';
                                            ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($loan['status'] === 'overdue'): ?>
                                    <div class="alert alert-warning mb-3">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <strong>En retard!</strong> Veuillez retourner ce livre au plus vite.
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($loan['notes'])): ?>
                                    <div class="mb-3">
                                        <strong>Notes:</strong><br>
                                        <p class="text-muted small"><?= nl2br(esc($loan['notes'])) ?></p>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <div class="mt-4">
                                        <h6>Progression:</h6>
                                        <div class="progress mb-2">
                                            <?php if ($loan['status'] === 'returned'): ?>
                                                <div class="progress-bar bg-success" style="width: 100%">Terminé</div>
                                            <?php elseif ($loan['status'] === 'overdue'): ?>
                                                <div class="progress-bar bg-danger" style="width: 100%">En retard</div>
                                            <?php else: ?>
                                                <?php
                                                $start = new DateTime($loan['loan_date']);
                                                $end = new DateTime($loan['due_date']);
                                                $today = new DateTime();
                                                $totalDays = $start->diff($end)->days;
                                                $passedDays = $start->diff($today)->days;
                                                $percentage = min(100, ($passedDays / $totalDays) * 100);
                                                ?>
                                                <div class="progress-bar bg-primary" style="width: <?= $percentage ?>%">
                                                    <?= round($percentage) ?>%
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <small class="text-muted">
                                            <?php if ($loan['status'] === 'active'): ?>
                                                <?= $passedDays ?> jour(s) sur <?= $totalDays ?>
                                            <?php endif; ?>
                                        </small>
                                    </div>

                                    <!-- Actions -->
                                    <div class="mt-4 pt-3 border-top">
                                        <div class="d-grid gap-2 d-md-flex">
                                            <?php if ($loan['status'] === 'active'): ?>
                                                <form action="<?= site_url('loan/return/' . $loan['id']) ?>" method="post" class="w-100">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-success w-100" 
                                                            onclick="return confirm('Retourner ce livre ?')">
                                                        <i class="fas fa-undo me-2"></i> Retourner le livre
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Styles responsives */
@media (max-width: 768px) {
    .card-header h4 {
        font-size: 1.25rem;
    }
    
    .card-header h6 {
        font-size: 1rem;
    }
    
    h5 {
        font-size: 1.1rem;
    }
    
    .img-fluid {
        max-height: 200px !important;
    }
    
    .fa-4x {
        font-size: 3em;
    }
    
    .btn {
        font-size: 0.9rem;
    }
}

@media (max-width: 576px) {
    .container {
        padding-left: 12px;
        padding-right: 12px;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .img-fluid {
        max-height: 180px !important;
    }
    
    .progress {
        height: 1.25rem;
    }
    
    .progress-bar {
        font-size: 0.8rem;
    }
    
    .alert {
        padding: 0.75rem;
    }
    
    .d-grid.gap-2 .btn {
        margin-bottom: 0.5rem;
    }
}

/* Améliorations visuelles */
.card {
    transition: box-shadow 0.2s ease;
}

.card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.badge {
    font-size: 0.8em;
    padding: 0.4em 0.6em;
}

.progress {
    height: 1.5rem;
    border-radius: 0.5rem;
}

.progress-bar {
    font-weight: 500;
}

/* Animation pour les boutons */
.btn {
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

/* Style pour les séparateurs */
.border-top {
    border-top: 2px solid #f8f9fa !important;
}
</style>

<script>
// Animation pour le chargement
document.addEventListener('DOMContentLoaded', function() {
    // Animation des cartes
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 100 + (index * 150));
    });

    // Animation de la barre de progression
    const progressBar = document.querySelector('.progress-bar');
    if (progressBar) {
        progressBar.style.width = '0%';
        setTimeout(() => {
            progressBar.style.transition = 'width 1s ease-in-out';
            progressBar.style.width = progressBar.style.width;
        }, 500);
    }
});
</script>
<?= $this->endSection() ?>
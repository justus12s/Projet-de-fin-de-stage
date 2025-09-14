<?= $this->extend('user/layout') ?>

<?= $this->section('content') ?>
<div class="container mt-3 mt-md-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-bookmark me-2"></i>Confirmation d'emprunt</h4>
                </div>
                <div class="card-body">
                    <!-- Image du livre -->
                    <div class="text-center mb-4">
                        <?php if (!empty($book['cover_image'])): ?>
                            <img src="<?= base_url('uploads/books/' . $book['cover_image']) ?>" 
                                 class="img-fluid rounded shadow" 
                                 alt="Couverture de <?= esc($book['title']) ?>"
                                 style="max-height: 200px;">
                        <?php else: ?>
                            <div class="bg-light rounded d-flex align-items-center justify-content-center p-4" style="height: 200px;">
                                <i class="fas fa-book fa-4x text-muted"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Titre et auteur -->
                    <h3 class="text-center mb-2"><?= esc($book['title']) ?></h3>
                    <p class="text-center text-muted mb-4">par <?= esc($book['author']) ?></p>

                    <!-- Informations détaillées -->
                    <div class="row mb-4">
                        <div class="col-6 col-md-3 text-center">
                            <div class="border rounded p-2">
                                <i class="fas fa-calendar-alt text-primary fa-2x mb-2"></i>
                                <h6 class="mb-1">30 jours</h6>
                                <small class="text-muted">Durée</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 text-center">
                            <div class="border rounded p-2">
                                <i class="fas fa-flag text-success fa-2x mb-2"></i>
                                <h6 class="mb-1"><?= date('d/m/Y', strtotime('+30 days')) ?></h6>
                                <small class="text-muted">Retour prévu</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 text-center">
                            <div class="border rounded p-2">
                                <i class="fas fa-exclamation-triangle text-warning fa-2x mb-2"></i>
                                <h6 class="mb-1">1€/jour</h6>
                                <small class="text-muted">Retard</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 text-center">
                            <div class="border rounded p-2">
                                <i class="fas fa-copy text-info fa-2x mb-2"></i>
                                <h6 class="mb-1"><?= $book['available'] ?></h6>
                                <small class="text-muted">Exemplaires</small>
                            </div>
                        </div>
                    </div>

                    <!-- Conditions d'emprunt -->
                    <div class="alert alert-info">
                        <h5><i class="fas fa-info-circle me-2"></i> Conditions d'emprunt</h5>
                        <ul class="mb-0">
                            <li>Durée de l'emprunt : <strong>30 jours</strong></li>
                            <li>Date de retour prévue : <strong><?= date('d/m/Y', strtotime('+30 days')) ?></strong></li>
                            <li>Amende en cas de retard : <strong>1€ par jour de retard</strong></li>
                            <li>Respectez les délais pour éviter les pénalités</li>
                            <li>Prenez soin du livre emprunté</li>
                        </ul>
                    </div>

                    <!-- Actions -->
                    <div class="text-center mt-4">
                        <form action="<?= site_url('books/borrow/' . $book['id']) ?>" method="post">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-success btn-lg me-2 mb-2">
                                <i class="fas fa-check me-2"></i> Confirmer l'emprunt
                            </button>
                            <a href="<?= site_url('books') ?>" class="btn btn-secondary btn-lg mb-2">
                                <i class="fas fa-times me-2"></i> Annuler
                            </a>
                        </form>
                    </div>

                    <!-- Informations complémentaires -->
                    <div class="mt-4 p-3 bg-light rounded">
                        <h6><i class="fas fa-lightbulb me-2"></i>Conseils</h6>
                        <ul class="small mb-0">
                            <li>Notez la date de retour dans votre calendrier</li>
                            <li>Vous pouvez prolonger l'emprunt si le livre n'est pas réservé</li>
                            <li>Contactez-nous en cas de problème avec le livre</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Styles responsives pour la confirmation */
@media (max-width: 768px) {
    .card-header h4 {
        font-size: 1.25rem;
    }
    
    h3 {
        font-size: 1.5rem;
    }
    
    .btn-lg {
        padding: 0.5rem 1rem;
        font-size: 1rem;
    }
    
    .fa-2x {
        font-size: 1.5em;
    }
}

@media (max-width: 576px) {
    .container {
        padding: 0 10px;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .btn-lg {
        width: 100%;
        margin-bottom: 0.5rem;
    }
    
    .row.mb-4 > div {
        margin-bottom: 0.5rem;
    }
    
    .alert {
        padding: 1rem;
    }
}

/* Améliorations visuelles */
.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.border.rounded {
    transition: all 0.2s ease;
}

.border.rounded:hover {
    background-color: #f8f9fa;
    transform: translateY(-2px);
}

.btn {
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-1px);
}
</style>

<script>
// Animation pour le chargement
document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.border.rounded, .alert, .bg-light');
    elements.forEach((element, index) => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        element.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        
        setTimeout(() => {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, 200 + (index * 100));
    });
});

// Confirmation avant soumission
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        if (!confirm('Confirmez-vous l\'emprunt de ce livre ?')) {
            e.preventDefault();
        }
    });
});
</script>
<?= $this->endSection() ?>
<?= $this->extend('user/layout') ?>

<?= $this->section('content') ?>
<div class="container mt-3 mt-md-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-bookmark me-2"></i>Confirmation de réservation</h4>
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
                                <i class="fas fa-copy text-info fa-2x mb-2"></i>
                                <h6 class="mb-1"><?= $book['available'] ?></h6>
                                <small class="text-muted">Exemplaires</small>
                            </div>
                        </div>
                    </div>

                    <!-- Conditions de réservation -->
                    <div class="alert alert-info">
                        <h5><i class="fas fa-info-circle me-2"></i>Conditions de réservation</h5>
                        <ul class="mb-0">
                            <li>Durée de réservation : <strong>30 jours</strong></li>
                            <li>Date de retour prévue : <strong><?= date('d/m/Y', strtotime('+30 days')) ?></strong></li>
                            <li>Amende en cas de retard : <strong>1€ par jour de retard</strong></li>
                            <li>Respectez les délais pour éviter les pénalités</li>
                            <li>Prenez soin du livre réservé</li>
                        </ul>
                    </div>

                    <!-- Actions -->
                    <div class="text-center mt-4">
                        <form action="<?= site_url('books/reserve/' . $book['id']) ?>" method="post">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-success btn-lg me-2 mb-2">
                                <i class="fas fa-check me-2"></i> Confirmer la réservation
                            </button>
                            <a href="<?= site_url('books') ?>" class="btn btn-secondary btn-lg mb-2">
                                <i class="fas fa-times me-2"></i> Annuler
                            </a>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Styles responsives pour la confirmation */
.card:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
.border.rounded:hover { background-color: #f8f9fa; transform: translateY(-2px); }
.btn:hover { transform: translateY(-1px); }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation pour le chargement
    const elements = document.querySelectorAll('.border.rounded, .alert, .bg-light');
    elements.forEach((el, i) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        setTimeout(() => { el.style.opacity = '1'; el.style.transform = 'translateY(0)'; }, 200 + i*100);
    });

    // Confirmation avant soumission
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        if (!confirm('Confirmez-vous la réservation de ce livre ?')) {
            e.preventDefault();
        }
    });
});
</script>
<?= $this->endSection() ?>

<?= $this->extend('user/layout') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Mes Réservations</h4>
        </div>
        <div class="card-body">

            <!-- Message flash -->
            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i> <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if(!empty($reservations)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Livre</th>
                                <th>Auteur</th>
                                <th>Date de réservation</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($reservations as $key => $reservation): ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= esc($reservation['book_title']) ?></td>
                                    <td><?= esc($reservation['book_author']) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($reservation['reserved_at'])) ?></td>
                                    <td>
                                        <?php if($reservation['status'] == 'en_attente'): ?>
                                            <span class="badge bg-warning">En attente</span>
                                        <?php elseif($reservation['status'] == 'confirmé'): ?>
                                            <span class="badge bg-success">Confirmé</span>
                                        <?php elseif($reservation['status'] == 'annulé'): ?>
                                            <span class="badge bg-danger">Annulé</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($reservation['status'] == 'en_attente'): ?>
                                            <!-- Annuler réservation -->
                                            <a href="<?= site_url('reservations/cancel/' . $reservation['id']) ?>" 
                                               class="btn btn-sm btn-warning mb-1"
                                               onclick="return confirm('Voulez-vous vraiment annuler cette réservation ?')">
                                               <i class="fas fa-times me-1"></i> Annuler
                                            </a>
                                        <?php endif; ?>

                                        <?php if($reservation['status'] == 'annulé'): ?>
                                            <!-- Supprimer réservation -->
                                            <a href="<?= site_url('reservations/delete/' . $reservation['id']) ?>" 
                                               class="btn btn-sm btn-danger mb-1"
                                               onclick="return confirm('Voulez-vous vraiment supprimer cette réservation ?')">
                                               <i class="fas fa-trash me-1"></i> Supprimer
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-calendar-check fa-3x text-muted mb-3"></i>
                    <h5 class="mb-3">Vous n'avez encore réservé aucun livre</h5>
                    <p class="text-muted mb-4">Consultez notre bibliothèque pour effectuer votre première réservation.</p>
                    <a href="<?= site_url('books') ?>" class="btn btn-primary">
                        <i class="fas fa-book me-2"></i> Voir les livres disponibles
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<style>
/* Styles responsives pour la table */
@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.9rem;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        width: 100%;
        margin-bottom: 0.3rem;
    }
}
</style>
<?= $this->endSection() ?>

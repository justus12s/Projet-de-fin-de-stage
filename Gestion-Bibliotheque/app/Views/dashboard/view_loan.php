<?= $this->extend('dashboard/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $page_title ?></h1>
        <div>
            <a href="<?= base_url('/admin/dashboard/loans') ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
            <?php if (in_array($loan['status'], ['active', 'overdue'])): ?>
                <a href="<?= base_url('/admin/dashboard/loans/return/' . $loan['id']) ?>" class="btn btn-success btn-sm" onclick="return confirm('Marquer ce livre comme retourné ?')">
                    <i class="fas fa-undo"></i> Retourner
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informations de l'Emprunt</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Statut:</div>
                        <div class="col-md-8">
                            <?php
                            $statusBadge = [
                                'active' => ['class' => 'success', 'text' => 'En cours'],
                                'overdue' => ['class' => 'warning', 'text' => 'En retard'],
                                'returned' => ['class' => 'info', 'text' => 'Retourné'],
                                'pending' => ['class' => 'secondary', 'text' => 'En attente'],
                                'cancelled' => ['class' => 'danger', 'text' => 'Annulé']
                            ];
                            $status = $loan['status'] ?? 'pending';
                            ?>
                            <span class="badge bg-<?= $statusBadge[$status]['class'] ?? 'secondary' ?>">
                                <?= $statusBadge[$status]['text'] ?? 'Inconnu' ?>
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Date d'emprunt:</div>
                        <div class="col-md-8"><?= date('d/m/Y', strtotime($loan['loan_date'])) ?></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Retour prévu:</div>
                        <div class="col-md-8">
                            <?= date('d/m/Y', strtotime($loan['due_date'])) ?>
                            <?php if ($loan['status'] === 'active' && strtotime($loan['due_date']) < time()): ?>
                                <span class="badge badge-warning ml-2">En retard</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if ($loan['return_date']): ?>
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Date de retour:</div>
                        <div class="col-md-8"><?= date('d/m/Y', strtotime($loan['return_date'])) ?></div>
                    </div>
                    <?php endif; ?>

                    <?php if ($loan['notes']): ?>
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Notes:</div>
                        <div class="col-md-8"><?= nl2br(esc($loan['notes'])) ?></div>
                    </div>
                    <?php endif; ?>

                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Créé le:</div>
                        <div class="col-md-8"><?= date('d/m/Y H:i', strtotime($loan['created_at'])) ?></div>
                    </div>

                    <?php if ($loan['updated_at'] && $loan['updated_at'] !== $loan['created_at']): ?>
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Modifié le:</div>
                        <div class="col-md-8"><?= date('d/m/Y H:i', strtotime($loan['updated_at'])) ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Détails du Livre</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <?php if (!empty($loan['cover_image'])): ?>
                            <img src="<?= base_url('uploads/books/' . $loan['cover_image']) ?>" 
                                alt="Couverture du livre" 
                                style="max-width: 150px; max-height: 200px; object-fit: cover; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                        <?php else: ?>
                            <div style="width: 150px; height: 200px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fas fa-book fa-3x text-muted"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Titre:</div>
                        <div class="col-md-8"><?= esc($loan['book_title']) ?></div>
                    </div>

                    <?php if ($loan['author']): ?>
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Auteur:</div>
                        <div class="col-md-8"><?= esc($loan['author']) ?></div>
                    </div>
                    <?php endif; ?>

                    <?php if ($loan['isbn']): ?>
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">ISBN:</div>
                        <div class="col-md-8"><?= esc($loan['isbn']) ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informations de l'Emprunteur</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Nom:</div>
                        <div class="col-md-8"><?= esc($loan['first_name']) ?> <?= esc($loan['last_name']) ?></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Email:</div>
                        <div class="col-md-8"><?= esc($loan['email']) ?></div>
                    </div>

                    <div class="text-center mt-4">
                        <i class="fas fa-user fa-3x text-success"></i>
                        <p class="mt-2">Emprunteur</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
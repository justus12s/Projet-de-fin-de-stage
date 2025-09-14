<?= $this->extend('dashboard/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $page_title ?></h1>
        <a href="<?= base_url('/admin/dashboard/loans') ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Retour aux emprunts
        </a>
    </div>

    <!-- Cartes de statistiques -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Emprunts en Retard</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($overdue_loans) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des emprunts en retard -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-warning">
            <h6 class="m-0 font-weight-bold text-white">Emprunts en Retard</h6>
        </div>
        <div class="card-body">
            <?php if (empty($overdue_loans)): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> Aucun emprunt en retard !
                </div>
            <?php else: ?>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> 
                    <?= count($overdue_loans) ?> emprunt(s) en retard nécessitent une action.
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead class="bg-warning text-white">
                            <tr>
                                <th>Livre</th>
                                <th>Emprunteur</th>
                                <th>Date d'emprunt</th>
                                <th>Retour prévu</th>
                                <th>Jours de retard</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($overdue_loans as $loan): ?>
                            <?php
                            $dueDate = new DateTime($loan['due_date']);
                            $today = new DateTime();
                            $daysOverdue = $today->diff($dueDate)->days;
                            ?>
                            <tr>
                                <td>
                                    <strong><?= esc($loan['book_title']) ?></strong>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if (!empty($loan['cover_image'])): ?>
                                            <img src="<?= base_url('uploads/books/' . $loan['cover_image']) ?>" 
                                                alt="Couverture" 
                                                class="book-cover mr-3"
                                                style="width: 40px; height: 56px; object-fit: cover; border-radius: 4px;">
                                        <?php else: ?>
                                            <div class="book-cover-placeholder mr-3" 
                                                style="width: 40px; height: 56px; background: #f0f0f0; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-book text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <strong><?= esc($loan['book_title']) ?></strong>
                                            <?php if ($loan['author']): ?>
                                                <br><small class="text-muted"><?= esc($loan['author']) ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                
                                <td>
                                    <?= esc($loan['first_name']) ?> <?= esc($loan['last_name']) ?>
                                    <br><small class="text-muted"><?= esc($loan['email']) ?></small>
                                </td>
                                <td><?= date('d/m/Y', strtotime($loan['loan_date'])) ?></td>
                                <td><?= date('d/m/Y', strtotime($loan['due_date'])) ?></td>
                                <td>
                                    <span class="badge badge-danger"><?= $daysOverdue ?> jours</span>
                                </td>
                                <td>
                                    <a href="<?= base_url('/admin/dashboard/loans/view/' . $loan['id']) ?>" class="btn btn-info btn-sm" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('/admin/dashboard/loans/return/' . $loan['id']) ?>" class="btn btn-success btn-sm" title="Retourner" onclick="return confirm('Marquer ce livre comme retourné ?')">
                                        <i class="fas fa-undo"></i>
                                    </a>
                                    <a href="mailto:<?= esc($loan['email']) ?>?subject=Rappel%20emprunt%20en%20retard&body=Bonjour%20<?= urlencode($loan['first_name']) ?>,%0D%0A%0D%0AVotre%20emprunt%20du%20livre%20'<?= urlencode($loan['book_title']) ?>'%20est%20en%20retard%20depuis%20<?= $daysOverdue ?>%20jours.%0D%0AVeuillez%20le%20rapporter%20au%20plus%20vite.%0D%0A%0D%0ACordialement," class="btn btn-warning btn-sm" title="Envoyer un rappel">
                                        <i class="fas fa-envelope"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->extend('dashboard/layout') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4 flex-wrap">
        <h1 class="h3 mb-2 mb-sm-0 text-gray-800"><?= $page_title ?></h1>
        <a href="<?= base_url('/admin/dashboard/loans/create') ?>" class="btn btn-primary btn-sm shadow-sm w-100 w-sm-auto mb-2 mb-sm-0">
            <i class="fas fa-plus fa-sm text-white-50"></i> Nouvel Emprunt
        </a>
    </div>

    <!-- Cartes de statistiques -->
    <div class="row">
        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['total'] ?? 0 ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exchange-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Actifs</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['active'] ?? 0 ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">En Retard</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['overdue'] ?? 0 ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Retournés</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['returned'] ?? 0 ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">En Attente</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['pending'] ?? 0 ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Annulés</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['cancelled'] ?? 0 ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filtres</h6>
        </div>
        <div class="card-body">
            <form method="get" class="form-inline flex-wrap">
                <div class="form-group mr-2 mb-2">
                    <input type="text" name="search" class="form-control" placeholder="Rechercher..." value="<?= $search ?>">
                </div>
                <div class="form-group mr-2 mb-2">
                    <select name="status" class="form-control">
                        <option value="">Tous les statuts</option>
                        <option value="active" <?= $selected_status === 'active' ? 'selected' : '' ?>>Actif</option>
                        <option value="overdue" <?= $selected_status === 'overdue' ? 'selected' : '' ?>>En retard</option>
                        <option value="returned" <?= $selected_status === 'returned' ? 'selected' : '' ?>>Retourné</option>
                        <option value="pending" <?= $selected_status === 'pending' ? 'selected' : '' ?>>En attente</option>
                        <option value="cancelled" <?= $selected_status === 'cancelled' ? 'selected' : '' ?>>Annulé</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mb-2">Filtrer</button>
                <a href="<?= base_url('/admin/dashboard/loans') ?>" class="btn btn-secondary mb-2 ml-2">Réinitialiser</a>
            </form>
        </div>
    </div>

    <!-- Tableau des emprunts -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des Emprunts</h6>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Livre</th>
                            <th>Emprunteur</th>
                            <th>Date d'emprunt</th>
                            <th>Retour prévu</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($loans as $loan): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center flex-wrap">
                                    <?php if (!empty($loan['cover_image'])): ?>
                                        <img src="<?= base_url('uploads/books/' . $loan['cover_image']) ?>" 
                                            alt="Couverture" 
                                            class="book-cover mr-3 mb-2 mb-sm-0"
                                            style="width: 40px; height: 56px; object-fit: cover; border-radius: 4px;">
                                    <?php else: ?>
                                        <div class="book-cover-placeholder mr-3 mb-2 mb-sm-0" 
                                            style="width: 40px; height: 56px; background: #f0f0f0; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-book text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <strong><?= esc($loan['book_title']) ?></strong>
                                        <?php if ($loan['author']): ?>
                                            <br><small class="text-muted"><?= esc($loan['author']) ?></small>
                                        <?php endif; ?>
                                        <?php if ($loan['isbn']): ?>
                                            <br><small class="text-muted">ISBN: <?= esc($loan['isbn']) ?></small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?= esc($loan['first_name']) ?> <?= esc($loan['last_name']) ?>
                                <br><small class="text-muted"><?= esc($loan['email']) ?></small>
                            </td>
                            <td><?= date('d/m/Y', strtotime($loan['loan_date'])) ?></td>
                            <td>
                                <?= date('d/m/Y', strtotime($loan['due_date'])) ?>
                                <?php if ($loan['status'] === 'active' && strtotime($loan['due_date']) < time()): ?>
                                    <br><span class="badge badge-warning">En retard</span>
                                <?php endif; ?>
                            </td>

                            <td>
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
                                <span class="badge bg-<?= $statusBadge[$status]['class'] ?>">
                                    <?= $statusBadge[$status]['text'] ?>
                                </span>
                            </td>

                            <td>
                                <a href="<?= base_url('/admin/dashboard/loans/view/' . $loan['id']) ?>" class="btn btn-info btn-sm mb-1" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <?php if (in_array($loan['status'], ['active', 'overdue'])): ?>
                                    <a href="<?= base_url('/admin/dashboard/loans/return/' . $loan['id']) ?>" class="btn btn-success btn-sm mb-1" title="Retourner" onclick="return confirm('Marquer ce livre comme retourné ?')">
                                        <i class="fas fa-undo"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($loan['status'] === 'pending'): ?>
                                    <a href="<?= base_url('/admin/dashboard/loans/delete/' . $loan['id']) ?>" class="btn btn-danger btn-sm mb-1" title="Annuler" onclick="return confirm('Annuler cet emprunt ?')">
                                        <i class="fas fa-times"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
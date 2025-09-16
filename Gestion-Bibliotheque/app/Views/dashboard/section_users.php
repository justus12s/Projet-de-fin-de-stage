<?= $this->extend('dashboard/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <!-- En-tête -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 flex-wrap">
        <h1 class="h3 mb-2 text-gray-800"><?= $page_title ?></h1>
        <a href="<?= base_url('/admin/dashboard/users/create') ?>" class="btn btn-sm btn-primary shadow-sm mb-2">
            <i class="fas fa-plus fa-sm text-white-50"></i> Nouvel Utilisateur
        </a>
    </div>

    <!-- Cartes de statistiques -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Utilisateurs</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_users ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Administrateurs</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_admins ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Abonnés</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_users ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Utilisateurs Actifs</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_active ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-gray-300"></i>
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
                    <select name="role" class="form-control">
                        <option value="">Tous les rôles</option>
                        <option value="admin" <?= $selected_role === 'admin' ? 'selected' : '' ?>>Administrateur</option>
                        <option value="user" <?= $selected_role === 'user' ? 'selected' : '' ?>>Abonné</option>
                    </select>
                </div>
                <div class="form-group mr-2 mb-2">
                    <select name="status" class="form-control">
                        <option value="">Tous les statuts</option>
                        <option value="active" <?= $selected_status === 'active' ? 'selected' : '' ?>>Actif</option>
                        <option value="inactive" <?= $selected_status === 'inactive' ? 'selected' : '' ?>>Inactif</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mb-2">Filtrer</button>
                <a href="<?= base_url('/admin/dashboard/users') ?>" class="btn btn-secondary mb-2 ml-2">Réinitialiser</a>
            </form>
        </div>
    </div>

    <!-- Tableau des utilisateurs -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des Utilisateurs</h6>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Statut</th>
                            <th>Date d'inscription</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= esc($user['first_name']) ?> <?= esc($user['last_name']) ?></td>
                            <td><?= esc($user['email']) ?></td>
                            <td>
                                <span class="badge badge-<?= $user['role'] === 'admin' ? 'danger' : 'primary' ?>">
                                    <?= $user['role'] === 'admin' ? 'Administrateur' : 'Abonné' ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-<?= $user['is_active'] ? 'success' : 'warning' ?>">
                                    <?= $user['is_active'] ? 'Actif' : 'Inactif' ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                            <td class="action-buttons">
                                <a href="<?= base_url('/admin/dashboard/users/view/' . $user['id']) ?>" class="btn btn-info btn-sm" title="Voir"><i class="fas fa-eye"></i></a>
                                <a href="<?= base_url('/admin/dashboard/users/edit/' . $user['id']) ?>" class="btn btn-warning btn-sm" title="Modifier"><i class="fas fa-edit"></i></a>
                                <a href="<?= base_url('/admin/dashboard/users/toggle-status/' . $user['id']) ?>" class="btn btn-<?= $user['is_active'] ? 'warning' : 'success' ?> btn-sm" title="<?= $user['is_active'] ? 'Désactiver' : 'Activer' ?>"><i class="fas fa-<?= $user['is_active'] ? 'times' : 'check' ?>"></i></a>
                                <a href="<?= base_url('/admin/dashboard/users/delete/' . $user['id']) ?>" class="btn btn-danger btn-sm" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')"><i class="fas fa-trash"></i></a>
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
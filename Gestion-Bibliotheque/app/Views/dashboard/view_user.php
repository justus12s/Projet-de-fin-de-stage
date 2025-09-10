<?= $this->extend('dashboard/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $page_title ?></h1>
        <div>
            <a href="<?= base_url('/admin/dashboard/users/edit/' . $user['id']) ?>" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <a href="<?= base_url('/admin/dashboard/users') ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profil</h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-user-circle fa-5x text-gray-300"></i>
                    </div>
                    <h4><?= esc($user['first_name']) ?> <?= esc($user['last_name']) ?></h4>
                    <p class="text-muted"><?= esc($user['email']) ?></p>
                    
                    <span class="badge badge-<?= $user['role'] === 'admin' ? 'danger' : 'primary' ?> mb-2">
                        <?= $user['role'] === 'admin' ? 'Administrateur' : 'Abonné' ?>
                    </span>
                    
                    <span class="badge badge-<?= $user['is_active'] ? 'success' : 'warning' ?>">
                        <?= $user['is_active'] ? 'Actif' : 'Inactif' ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informations Personnelles</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Nom complet:</strong><br>
                            <?= esc($user['first_name']) ?> <?= esc($user['last_name']) ?>
                        </div>
                        <div class="col-md-6">
                            <strong>Email:</strong><br>
                            <?= esc($user['email']) ?>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <strong>Téléphone:</strong><br>
                            <?= $user['phone'] ? esc($user['phone']) : 'Non renseigné' ?>
                        </div>
                        <div class="col-md-6">
                            <strong>Date de naissance:</strong><br>
                            <?= $user['date_of_birth'] ? date('d/m/Y', strtotime($user['date_of_birth'])) : 'Non renseignée' ?>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-12">
                            <strong>Adresse:</strong><br>
                            <?= $user['address'] ? nl2br(esc($user['address'])) : 'Non renseignée' ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informations Professionnelles</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>ID Étudiant:</strong><br>
                            <?= $user['student_id'] ? esc($user['student_id']) : 'Non renseigné' ?>
                        </div>
                        <div class="col-md-4">
                            <strong>Institution:</strong><br>
                            <?= $user['institution'] ? esc($user['institution']) : 'Non renseignée' ?>
                        </div>
                        <div class="col-md-4">
                            <strong>Spécialisation:</strong><br>
                            <?= $user['specialization'] ? esc($user['specialization']) : 'Non renseignée' ?>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <strong>Titre professionnel:</strong><br>
                            <?= $user['professional_title'] ? esc($user['professional_title']) : 'Non renseigné' ?>
                        </div>
                        <div class="col-md-6">
                            <strong>Expiration abonnement:</strong><br>
                            <?= $user['membership_expiry'] ? date('d/m/Y', strtotime($user['membership_expiry'])) : 'Illimitée' ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informations Système</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Date d'inscription:</strong><br>
                            <?= date('d/m/Y H:i', strtotime($user['created_at'])) ?>
                        </div>
                        <div class="col-md-4">
                            <strong>Dernière modification:</strong><br>
                            <?= date('d/m/Y H:i', strtotime($user['updated_at'])) ?>
                        </div>
                        <div class="col-md-4">
                            <strong>Statut:</strong><br>
                            <span class="badge badge-<?= $user['is_active'] ? 'success' : 'warning' ?>">
                                <?= $user['is_active'] ? 'Actif' : 'Inactif' ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
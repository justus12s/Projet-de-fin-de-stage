<?= $this->extend('dashboard/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $page_title ?></h1>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Paramètres Généraux</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('/admin/dashboard/settings/save') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="form-group">
                            <label for="setting_library_name">Nom de la bibliothèque</label>
                            <input type="text" class="form-control" id="setting_library_name" 
                                   name="setting_library_name" 
                                   value="<?= $settings['library_name'] ?? 'Ma Bibliothèque' ?>">
                        </div>

                        <div class="form-group">
                            <label for="setting_loan_duration">Durée des emprunts (jours)</label>
                            <input type="number" class="form-control" id="setting_loan_duration" 
                                   name="setting_loan_duration" 
                                   value="<?= $settings['loan_duration'] ?? 30 ?>" min="1" max="365">
                        </div>

                        <div class="form-group">
                            <label for="setting_max_books_per_user">Livres maximum par utilisateur</label>
                            <input type="number" class="form-control" id="setting_max_books_per_user" 
                                   name="setting_max_books_per_user" 
                                   value="<?= $settings['max_books_per_user'] ?? 5 ?>" min="1" max="20">
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="setting_email_notifications" 
                                       name="setting_email_notifications" value="1" 
                                       <?= ($settings['email_notifications'] ?? true) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="setting_email_notifications">
                                    Notifications par email
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Enregistrer les paramètres</button>
                    </form>
                </div>
            </div>
        </div>

        
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-info text-white">
                    <h6 class="m-0 font-weight-bold">Informations Système</h6>
                </div>
                <div class="card-body">
                    <p><strong>Version:</strong> 1.0.0</p>
                    <p><strong>Dernière mise à jour:</strong> <?= date('d/m/Y') ?></p>
                    <p><strong>Utilisateurs:</strong> <?= number_format($userCount) ?> inscrits</p>
                    <p><strong>Livres:</strong> <?= number_format($bookCount) ?> au catalogue</p>
                    
                    <?php if (isset($activeUserCount)): ?>
                    <p><strong>Utilisateurs actifs:</strong> <?= number_format($activeUserCount) ?></p>
                    <?php endif; ?>
                    
                    <?php if (isset($availableBookCount)): ?>
                    <p><strong>Livres disponibles:</strong> <?= number_format($availableBookCount) ?></p>
                    <?php endif; ?>
                    
                    <?php if (isset($loanCount)): ?>
                    <p><strong>Emprunts total:</strong> <?= number_format($loanCount) ?></p>
                    <?php endif; ?>
                    
                    <?php if (isset($activeLoanCount)): ?>
                    <p><strong>Emprunts actifs:</strong> <?= number_format($activeLoanCount) ?></p>
                    <?php endif; ?>
                    
                    <hr>
                    <p class="text-muted small">
                        <i class="fas fa-info-circle"></i> 
                        Pour des modifications avancées, contactez l'administrateur système.
                    </p>
                </div>
            </div>
        </div>


    </div>
</div>
<?= $this->endSection() ?>
<?= $this->extend('dashboard/layout') ?>

<?= $this->section('content') ?>
<!-- Header -->
<div class="header">
    <div class="d-flex align-items-center">
        <button class="btn btn-outline-secondary sidebar-toggle me-2 d-lg-none" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <h2 class="mb-0"><i class="fas fa-plus-circle me-2"></i> Ajouter un nouveau livre</h2>
    </div>
    <a href="<?= site_url('admin/dashboard/books') ?>" class="btn btn-sm btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> <span class="d-none d-md-inline">Retour à la liste</span>
    </a>
</div>

<div class="recent-table">
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <h5>Veuillez corriger les erreurs suivantes :</h5>
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('admin/books/create') ?>" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="title" class="form-label">Titre du livre *</label>
                    <input type="text" class="form-control" id="title" name="title" 
                           value="<?= old('title') ?>" required>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="author" class="form-label">Auteur *</label>
                    <input type="text" class="form-control" id="author" name="author" 
                           value="<?= old('author') ?>" required>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="isbn" class="form-label">ISBN</label>
                    <input type="text" class="form-control" id="isbn" name="isbn" 
                           value="<?= old('isbn') ?>">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="category" class="form-label">Catégorie</label>
                    <select class="form-select" id="category" name="category">
                        <option value="">Sélectionner une catégorie</option>
                        <option value="Fiction" <?= old('category') == 'Fiction' ? 'selected' : '' ?>>Fiction</option>
                        <option value="Science-Fiction" <?= old('category') == 'Science-Fiction' ? 'selected' : '' ?>>Science-Fiction</option>
                        <option value="Fantasy" <?= old('category') == 'Fantasy' ? 'selected' : '' ?>>Fantasy</option>
                        <option value="Histoire" <?= old('category') == 'Histoire' ? 'selected' : '' ?>>Histoire</option>
                        <option value="Biographie" <?= old('category') == 'Biographie' ? 'selected' : '' ?>>Biographie</option>
                        <option value="Informatique" <?= old('category') == 'Informatique' ? 'selected' : '' ?>>Informatique</option>
                        <option value="Jeunesse" <?= old('category') == 'Jeunesse' ? 'selected' : '' ?>>Jeunesse</option>
                        <option value="Classique" <?= old('category') == 'Classique' ? 'selected' : '' ?>>Classique</option>
                        <option value="Stratégie" <?= old('category') == 'Stratégie' ? 'selected' : '' ?>>Stratégie</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?= old('description') ?></textarea>
        </div>
        
        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="publish_year" class="form-label">Année de publication</label>
                    <input type="number" class="form-control" id="publish_year" name="publish_year" 
                           value="<?= old('publish_year') ?>" min="1900" max="<?= date('Y') ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="publisher" class="form-label">Éditeur</label>
                    <input type="text" class="form-control" id="publisher" name="publisher" 
                           value="<?= old('publisher') ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantité *</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" 
                           value="<?= old('quantity', 1) ?>" min="1" required>
                </div>
            </div>
        </div>
        
        <div class="mb-4">
            <label for="cover_image" class="form-label">Couverture du livre</label>
            <input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/*">
            <div class="form-text">Formats acceptés: JPG, PNG, GIF. Taille max: 2MB</div>
        </div>
        
        <div class="d-flex gap-2 flex-wrap justify-content-end">
            <button type="reset" class="btn btn-secondary">Réinitialiser</button>
            <button type="submit" class="btn btn-primary">Ajouter le livre</button>
        </div>
    </form>
</div>

<style>
/* Styles spécifiques pour la page d'ajout de livre */
@media (max-width: 768px) {
    .recent-table {
        padding: 15px;
    }
    
    .form-label {
        font-weight: 500;
    }
}

@media (max-width: 576px) {
    .header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .header h2 {
        margin-bottom: 10px;
        font-size: 1.5rem;
    }
    
    .recent-table {
        padding: 12px;
    }
    
    .form-control {
        padding: 0.5rem 0.75rem;
        font-size: 0.9rem;
    }
    
    .btn {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
    
    .d-flex.gap-2.flex-wrap {
        flex-direction: column;
        width: 100%;
    }
    
    .d-flex.gap-2.flex-wrap .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}

/* Pour les très petits écrans */
@media (max-width: 360px) {
    .header h2 {
        font-size: 1.3rem;
    }
    
    .form-control {
        font-size: 0.85rem;
    }
    
    .btn {
        font-size: 0.85rem;
        padding: 0.4rem 0.8rem;
    }
}

/* Amélioration de l'expérience mobile */
.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.15);
}
</style>
<?= $this->endSection() ?>
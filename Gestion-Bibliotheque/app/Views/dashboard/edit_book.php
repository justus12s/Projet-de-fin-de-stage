<?= $this->extend('dashboard/layout') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-edit me-2"></i> Modifier le Livre</h2>
                <a href="<?= site_url('admin/dashboard/books') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Retour à la liste
                </a>
            </div>

            <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <h5>Veuillez corriger les erreurs suivantes :</h5>
                <ul>
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <form action="<?= site_url('admin/dashboard/books/update/' . $book['id']) ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="form-label">Titre du livre *</label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="<?= old('title', $book['title']) ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="author" class="form-label">Auteur *</label>
                            <input type="text" class="form-control" id="author" name="author" 
                                   value="<?= old('author', $book['author']) ?>" required>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="isbn" class="form-label">ISBN</label>
                            <input type="text" class="form-control" id="isbn" name="isbn" 
                                   value="<?= old('isbn', $book['isbn']) ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category" class="form-label">Catégorie</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">Sélectionner une catégorie</option>
                                <option value="Fiction" <?= old('category', $book['category']) == 'Fiction' ? 'selected' : '' ?>>Fiction</option>
                                <option value="Science-Fiction" <?= old('category', $book['category']) == 'Science-Fiction' ? 'selected' : '' ?>>Science-Fiction</option>
                                <option value="Fantasy" <?= old('category', $book['category']) == 'Fantasy' ? 'selected' : '' ?>>Fantasy</option>
                                <option value="Histoire" <?= old('category', $book['category']) == 'Histoire' ? 'selected' : '' ?>>Histoire</option>
                                <option value="Biographie" <?= old('category', $book['category']) == 'Biographie' ? 'selected' : '' ?>>Biographie</option>
                                <option value="Informatique" <?= old('category', $book['category']) == 'Informatique' ? 'selected' : '' ?>>Informatique</option>
                                <option value="Jeunesse" <?= old('category', $book['category']) == 'Jeunesse' ? 'selected' : '' ?>>Jeunesse</option>
                                <option value="Classique" <?= old('category', $book['category']) == 'Classique' ? 'selected' : '' ?>>Classique</option>
                                <option value="Stratégie" <?= old('category', $book['category']) == 'Stratégie' ? 'selected' : '' ?>>Stratégie</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?= old('description', $book['description']) ?></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="publish_year" class="form-label">Année de publication</label>
                            <input type="number" class="form-control" id="publish_year" name="publish_year" 
                                   value="<?= old('publish_year', $book['publish_year']) ?>" min="1900" max="<?= date('Y') ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="publisher" class="form-label">Éditeur</label>
                            <input type="text" class="form-control" id="publisher" name="publisher" 
                                   value="<?= old('publisher', $book['publisher']) ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantité *</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" 
                                   value="<?= old('quantity', $book['quantity']) ?>" min="1" required>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="cover_image" class="form-label">Nouvelle couverture</label>
                    <input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/*">
                    <div class="form-text">Laisser vide pour conserver l'image actuelle</div>
                    
                    <?php if ($book['cover_image']): ?>
                    <div class="mt-2">
                        <img src="<?= base_url('uploads/books/' . $book['cover_image']) ?>" 
                             alt="Couverture actuelle" 
                             style="width: 100px; height: 140px; object-fit: cover; border: 1px solid #ddd;">
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="<?= site_url('admin/dashboard/books') ?>" class="btn btn-secondary me-2">Annuler</a>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
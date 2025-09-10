<?= $this->extend('dashboard/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-book me-2"></i> Détails du Livre</h2>
                <a href="<?= site_url('admin/dashboard/books') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Retour à la liste
                </a>
            </div>

            <div class="card">
                <div class="row g-0">
                    <div class="col-md-3">
                        <img src="<?= $book['cover_image'] ? base_url('uploads/books/' . $book['cover_image']) : base_url('uploads/books/default-cover.jpg') ?>" 
                             class="img-fluid rounded-start" 
                             alt="<?= esc($book['title']) ?>"
                             style="width: 100%; height: 300px; object-fit: cover;">
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <h3 class="card-title"><?= esc($book['title']) ?></h3>
                            <p class="text-muted">par <?= esc($book['author']) ?></p>
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <p><strong>ISBN:</strong> <?= $book['isbn'] ?? 'Non spécifié' ?></p>
                                    <p><strong>Catégorie:</strong> <?= $book['category'] ?? 'Non spécifiée' ?></p>
                                    <p><strong>Éditeur:</strong> <?= $book['publisher'] ?? 'Non spécifié' ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Année:</strong> <?= $book['publish_year'] ?? 'Non spécifiée' ?></p>
                                    <p><strong>Quantité:</strong> <?= $book['quantity'] ?></p>
                                    <p><strong>Disponibles:</strong> <?= $book['available'] ?></p>
                                </div>
                            </div>
                            
                            <?php if (!empty($book['description'])): ?>
                            <div class="mt-3">
                                <h5>Description:</h5>
                                <p class="card-text"><?= nl2br(esc($book['description'])) ?></p>
                            </div>
                            <?php endif; ?>
                            
                            <div class="mt-4">
                                <a href="<?= site_url('admin/dashboard/books/edit/' . $book['id']) ?>" class="btn btn-warning">
                                    <i class="fas fa-edit me-1"></i> Modifier
                                </a>
                                <a href="<?= site_url('admin/dashboard/books') ?>" class="btn btn-secondary">
                                    <i class="fas fa-list me-1"></i> Liste des livres
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
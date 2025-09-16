<?= $this->extend('user/layout') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="row"> 
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Livres Disponibles</h4>
                </div>
                <div class="card-body">

                    <!-- Barre de recherche -->
                    <div class="row mb-4">
                        <div class="col-12 col-md-8 mb-3 mb-md-0">
                            <input type="text" class="form-control" placeholder="Rechercher un livre..." id="searchInput">
                        </div>
                        <div class="col-12 col-md-4">
                            <select class="form-control" id="categoryFilter">
                                <option value="">Toutes les catégories</option>
                                <?php 
                                $predefinedCategories = ['Fiction','Science Fiction','Fantasy','Histoire','Bibliographie','Informatique','Jeunesse','Classiques','Stratégie'];
                                foreach ($predefinedCategories as $cat): ?>
                                    <option value="<?= $cat ?>"><?= $cat ?></option>
                                <?php endforeach; ?>
                                <option disabled>──────────</option>
                                <?php 
                                $categoriesFromDB = [];
                                foreach ($books as $book) {
                                    if (!empty($book['category']) && !in_array($book['category'], $categoriesFromDB)) {
                                        $categoriesFromDB[] = $book['category'];
                                    }
                                }
                                $uniqueCategories = array_diff($categoriesFromDB, $predefinedCategories);
                                sort($uniqueCategories);
                                foreach ($uniqueCategories as $category): ?>
                                    <option value="<?= $category ?>"><?= $category ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Liste des livres -->
                    <div class="row" id="booksContainer">
                        <?php if (!empty($books)): ?>
                            <?php foreach ($books as $book): ?>
                            <div class="col-12 col-sm-6 col-lg-4 mb-4 book-item" data-category="<?= $book['category'] ?? '' ?>">
                                <div class="card h-100 shadow-sm">
                                    <?php if (!empty($book['cover_image'])): ?>
                                        <img src="<?= base_url('uploads/books/' . $book['cover_image']) ?>" 
                                             class="card-img-top" 
                                             alt="<?= esc($book['title']) ?>"
                                             style="height: 200px; object-fit: cover; padding: 10px;">
                                    <?php else: ?>
                                        <div class="text-center py-4 bg-light">
                                            <i class="fas fa-book fa-3x text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="card-body">
                                        <h6 class="card-title fw-bold"><?= esc($book['title']) ?></h6>
                                        <p class="card-text text-muted small mb-2"><?= esc($book['author']) ?></p>
                                        <?php if (!empty($book['category'])): ?>
                                            <span class="badge bg-primary mb-2"><?= esc($book['category']) ?></span>
                                        <?php endif; ?>
                                        <?php if (!empty($book['isbn'])): ?>
                                            <p class="card-text small mb-2"><strong>ISBN:</strong> <?= esc($book['isbn']) ?></p>
                                        <?php endif; ?>
                                        <p class="card-text small mb-3">
                                            <strong>Disponible:</strong> 
                                            <span class="<?= $book['available'] > 0 ? 'text-success' : 'text-danger' ?>">
                                                <?= $book['available'] ?> exemplaire(s)
                                            </span>
                                        </p>
                                    </div>
                                    
                                    <div class="card-footer bg-white pt-2 pb-2">
                                        <div class="d-grid gap-2">
                                            <button class="btn btn-outline-primary btn-sm" 
                                                    onclick="showBookDetails(<?= $book['id'] ?>)">
                                                <i class="fas fa-info-circle me-1"></i> Détails
                                            </button>

                                            <?php if ($book['available'] > 0): ?>
                                                <!-- Bouton redirige vers confirmation -->
                                                <a href="<?= site_url('books/confirm/' . $book['id']) ?>" 
                                                   class="btn btn-success btn-sm">
                                                    <i class="fas fa-bookmark me-1"></i> Réserver
                                                </a>
                                            <?php else: ?>
                                                <button class="btn btn-secondary btn-sm" disabled>
                                                    <i class="fas fa-ban me-1"></i> Indisponible
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <div class="alert alert-info text-center py-4">
                                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                                    <h5>Aucun livre disponible pour le moment</h5>
                                    <p class="mb-0">Revenez plus tard pour découvrir nos nouvelles acquisitions.</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Message "Aucun livre trouvé" -->
                    <div id="noResults" class="alert alert-warning text-center mt-4 py-4" style="display: none;">
                        <i class="fas fa-search fa-2x mb-3"></i>
                        <h5>Aucun livre trouvé</h5>
                        <p class="mb-3">Aucun livre ne correspond à vos critères de recherche.</p>
                        <button class="btn btn-sm btn-outline-primary mt-2" onclick="resetFilters()">
                            <i class="fas fa-refresh me-1"></i> Réinitialiser les filtres
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour les détails du livre -->
<div class="modal fade" id="bookModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookModalTitle">Détails du livre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="bookModalBody"></div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<script>
// Recherche et filtrage
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const bookItems = document.querySelectorAll('.book-item');
    const noResults = document.getElementById('noResults');
    const booksContainer = document.getElementById('booksContainer');

    function filterBooks() {
        const searchText = searchInput.value.toLowerCase();
        const selectedCategory = categoryFilter.value;
        let visibleCount = 0;

        bookItems.forEach(item => {
            const title = item.querySelector('.card-title').textContent.toLowerCase();
            const author = item.querySelector('.card-text').textContent.toLowerCase();
            const itemCategory = item.dataset.category;
            const matchesSearch = !searchText || title.includes(searchText) || author.includes(searchText);
            const matchesCategory = !selectedCategory || itemCategory === selectedCategory;
            if (matchesSearch && matchesCategory) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        noResults.style.display = visibleCount === 0 ? 'block' : 'none';
        booksContainer.style.display = visibleCount === 0 ? 'none' : 'flex';
    }

    window.resetFilters = function() {
        searchInput.value = '';
        categoryFilter.value = '';
        filterBooks();
    }

    searchInput.addEventListener('input', filterBooks);
    categoryFilter.addEventListener('change', filterBooks);
    filterBooks();
});

// Détails du livre
function showBookDetails(bookId) {
    fetch(`<?= site_url('/api/book/') ?>${bookId}`)
    .then(res => res.json())
    .then(book => {
        document.getElementById('bookModalTitle').textContent = book.title;
        document.getElementById('bookModalBody').innerHTML = `
            <div class="row">
                <div class="col-12 col-md-4 mb-3">
                    ${book.cover_image ? `<img src="<?= base_url('uploads/books/') ?>${book.cover_image}" class="img-fluid rounded shadow w-100" alt="${book.title}" style="max-height: 300px; object-fit: cover;">` :
                    `<div class="text-center py-5 bg-light rounded d-flex align-items-center justify-content-center"><i class="fas fa-book fa-5x text-muted"></i></div>`}
                </div>
                <div class="col-12 col-md-8">
                    <h4 class="mb-2 mb-md-3">${book.title}</h4>
                    <p class="text-muted mb-3 mb-md-4">${book.author}</p>
                    <div class="row mb-3 mb-md-4">
                        <div class="col-12 col-sm-6 mb-2 mb-sm-0">
                            <strong>Catégorie:</strong><br>
                            <span class="badge bg-primary mt-1">${book.category || 'Non spécifiée'}</span>
                        </div>
                        <div class="col-12 col-sm-6">
                            <strong>Disponibilité:</strong><br>
                            <span class="${book.available > 0 ? 'text-success' : 'text-danger'} mt-1 d-block">${book.available} exemplaire(s)</span>
                        </div>
                    </div>
                    <div class="book-details-grid mb-3">
                        ${book.isbn ? `<div class="detail-item"><strong>ISBN:</strong> ${book.isbn}</div>` : ''}
                        ${book.publish_year ? `<div class="detail-item"><strong>Année:</strong> ${book.publish_year}</div>` : ''}
                        ${book.publisher ? `<div class="detail-item"><strong>Éditeur:</strong> ${book.publisher}</div>` : ''}
                    </div>
                    ${book.description ? `<div class="mt-3 mt-md-4"><strong>Description:</strong><p class="text-muted mt-2" style="max-height: 150px; overflow-y: auto;">${book.description}</p></div>` : ''}
                </div>
            </div>`;

        const modalFooter = document.querySelector('#bookModal .modal-footer');
        if (book.available > 0) {
            modalFooter.innerHTML = `
                <div class="d-flex flex-column flex-md-row gap-2 w-100">
                    <a href="<?= site_url('books/confirm/') ?>${book.id}" class="btn btn-success flex-fill"><i class="fas fa-bookmark me-1 me-md-2"></i> Réserver ce livre</a>
                    <button type="button" class="btn btn-secondary flex-fill" data-bs-dismiss="modal"><i class="fas fa-times me-1 me-md-2"></i> Fermer</button>
                </div>`;
        } else {
            modalFooter.innerHTML = `
                <div class="d-flex flex-column flex-md-row gap-2 w-100">
                    <button type="button" class="btn btn-outline-secondary flex-fill" data-bs-dismiss="modal"><i class="fas fa-times me-1 me-md-2"></i> Fermer</button>
                    <button class="btn btn-outline-primary flex-fill" onclick="alert('Fonctionnalité de notification à venir')"><i class="fas fa-bell me-1 me-md-2"></i> Être notifié</button>
                </div>`;
        }

        const modalElement = document.getElementById('bookModal');
        const modal = new bootstrap.Modal(modalElement);

        function adjustModal() {
            const dialog = modalElement.querySelector('.modal-dialog');
            if (window.innerWidth < 768) {
                dialog.classList.add('modal-fullscreen', 'modal-dialog-scrollable');
                dialog.classList.remove('modal-lg');
            } else {
                dialog.classList.remove('modal-fullscreen', 'modal-dialog-scrollable');
                dialog.classList.add('modal-lg');
            }
        }

        adjustModal();
        window.addEventListener('resize', adjustModal);
        modal.show();
    })
    .catch(error => {
        console.error('Erreur:', error);
        document.getElementById('bookModalBody').innerHTML = `<div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i>Erreur lors du chargement des détails du livre.</div>`;
        const modal = new bootstrap.Modal(document.getElementById('bookModal'));
        modal.show();
    });
}
</script>
<?= $this->endSection() ?>

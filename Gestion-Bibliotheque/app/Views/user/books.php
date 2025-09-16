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
                                
                                <!-- Vos 9 catégories spécifiques -->
                                <option value="Fiction">Fiction</option>
                                <option value="Science Fiction">Science Fiction</option>
                                <option value="Fantasy">Fantasy</option>
                                <option value="Histoire">Histoire</option>
                                <option value="Bibliographie">Bibliographie</option>
                                <option value="Informatique">Informatique</option>
                                <option value="Jeunesse">Jeunesse</option>
                                <option value="Classiques">Classiques</option>
                                <option value="Stratégie">Stratégie</option>
                                
                                <!-- Séparateur -->
                                <option disabled>──────────</option>
                                
                                <!-- Catégories dynamiques supplémentaires depuis la base de données -->
                                <?php 
                                // Récupérer toutes les catégories uniques depuis les livres
                                $categoriesFromDB = [];
                                foreach ($books as $book) {
                                    if (!empty($book['category']) && !in_array($book['category'], $categoriesFromDB)) {
                                        $categoriesFromDB[] = $book['category'];
                                    }
                                }
                                
                                // Filtrer pour ne garder que les catégories qui ne sont pas déjà dans vos 9 catégories
                                $predefinedCategories = [
                                    'Fiction', 'Science Fiction', 'Fantasy', 'Histoire', 
                                    'Bibliographie', 'Informatique', 'Jeunesse', 'Classiques', 'Stratégie'
                                ];
                                $uniqueCategories = array_diff($categoriesFromDB, $predefinedCategories);
                                sort($uniqueCategories);
                                
                                foreach ($uniqueCategories as $category): 
                                ?>
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
                                                <a href="<?= site_url('books/borrow/' . $book['id']) ?>" 
                                                   class="btn btn-success btn-sm">
                                                    <i class="fas fa-bookmark me-1"></i> Emprunter
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
            <div class="modal-body" id="bookModalBody">
                <!-- Contenu chargé dynamiquement -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<style>
/* Styles supplémentaires pour améliorer l'espacement */
.card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    border: 1px solid rgba(0,0,0,0.125);
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
}

.book-item {
    padding: 0 8px;
}

.card-img-top {
    transition: transform 0.3s ease;
}

.card:hover .card-img-top {
    transform: scale(1.05);
}

.btn {
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

/* Styles responsives */
@media (max-width: 768px) {
    .card-img-top {
        height: 180px !important;
        padding: 8px !important;
    }
    
    .card-title {
        font-size: 0.9rem;
    }
    
    .card-text {
        font-size: 0.8rem;
    }
    
    .btn-sm {
        padding: 0.2rem 0.4rem;
        font-size: 0.8rem;
    }
}

@media (max-width: 576px) {
    .book-item {
        padding: 0 5px;
    }
    
    .card-img-top {
        height: 160px !important;
    }
    
    .card-body {
        padding: 0.75rem;
    }
    
    .card-footer {
        padding: 0.5rem;
    }
}

/* Styles pour la modal responsive */
@media (max-width: 767.98px) {
    #bookModal .modal-content {
        border-radius: 0;
        height: 100vh;
        margin: 0;
    }
    
    #bookModal .modal-header {
        position: sticky;
        top: 0;
        background: white;
        z-index: 100;
        border-bottom: 1px solid #dee2e6;
    }
    
    #bookModal .modal-body {
        padding: 1rem;
        overflow-y: auto;
    }
    
    #bookModal .modal-footer {
        position: sticky;
        bottom: 0;
        background: white;
        z-index: 100;
        border-top: 1px solid #dee2e6;
        padding: 1rem;
    }
    
    #bookModal .img-fluid {
        max-height: 250px !important;
    }
    
    #bookModal .fa-5x {
        font-size: 4em !important;
    }
}

@media (max-width: 575.98px) {
    #bookModal .modal-body {
        padding: 0.75rem;
    }
    
    #bookModal .modal-footer {
        padding: 0.75rem;
    }
    
    #bookModal .btn {
        padding: 0.5rem 0.75rem;
        font-size: 0.9rem;
    }
    
    #bookModal h4 {
        font-size: 1.25rem;
    }
}

/* Grille pour les détails du livre */
.book-details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 0.5rem 1rem;
}

.detail-item {
    padding: 0.5rem;
    background: #f8f9fa;
    border-radius: 0.375rem;
    font-size: 0.9rem;
}

/* Améliorations pour la description */
#bookModal .text-muted {
    line-height: 1.5;
    font-size: 0.95rem;
}

/* Animation pour l'ouverture de la modal */
.modal.fade .modal-dialog {
    transition: transform 0.3s ease-out;
}

/* Boutons adaptatifs */
@media (max-width: 767.98px) {
    .book-details-grid {
        grid-template-columns: 1fr;
    }
    
    .detail-item {
        text-align: center;
    }
    
    #bookModal .d-flex.flex-column .btn {
        margin-bottom: 0.5rem;
    }
    
    #bookModal .d-flex.flex-column .btn:last-child {
        margin-bottom: 0;
    }
}
</style>

<script>
// Filtrage et recherche
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

            const matchesSearch = searchText === '' || title.includes(searchText) || author.includes(searchText);
            const matchesCategory = selectedCategory === '' || itemCategory === selectedCategory;

            if (matchesSearch && matchesCategory) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        // Afficher/masquer le message "Aucun résultat"
        if (visibleCount === 0) {
            noResults.style.display = 'block';
            booksContainer.style.display = 'none';
        } else {
            noResults.style.display = 'none';
            booksContainer.style.display = 'flex';
        }
    }

    // Fonction pour réinitialiser les filtres
    window.resetFilters = function() {
        searchInput.value = '';
        categoryFilter.value = '';
        filterBooks();
    }

    searchInput.addEventListener('input', filterBooks);
    categoryFilter.addEventListener('change', filterBooks);

    // Initial filter pour cacher le message au chargement
    filterBooks();
});

// Afficher les détails du livre
function showBookDetails(bookId) {
    fetch(`<?= site_url('/api/book/') ?>${bookId}`)
        .then(response => response.json())
        .then(book => {
            document.getElementById('bookModalTitle').textContent = book.title;
            
            let modalContent = `
                <div class="row">
                    <div class="col-12 col-md-4 mb-3">
                        ${book.cover_image ? 
                            `<img src="<?= base_url('uploads/books/') ?>${book.cover_image}" 
                                  class="img-fluid rounded shadow w-100" 
                                  alt="${book.title}"
                                  style="max-height: 300px; object-fit: cover;">` :
                            `<div class="text-center py-5 bg-light rounded d-flex align-items-center justify-content-center">
                                <i class="fas fa-book fa-5x text-muted"></i>
                            </div>`
                        }
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
                                <span class="${book.available > 0 ? 'text-success' : 'text-danger'} mt-1 d-block">
                                    ${book.available} exemplaire(s) ${book.available > 0 ? 'disponible(s)' : 'indisponible'}
                                </span>
                            </div>
                        </div>

                        <div class="book-details-grid mb-3">
                            ${book.isbn ? `
                                <div class="detail-item">
                                    <strong>ISBN:</strong> ${book.isbn}
                                </div>
                            ` : ''}
                            
                            ${book.publish_year ? `
                                <div class="detail-item">
                                    <strong>Année:</strong> ${book.publish_year}
                                </div>
                            ` : ''}
                            
                            ${book.publisher ? `
                                <div class="detail-item">
                                    <strong>Éditeur:</strong> ${book.publisher}
                                </div>
                            ` : ''}
                        </div>
                        
                        ${book.description ? `
                            <div class="mt-3 mt-md-4">
                                <strong>Description:</strong>
                                <p class="text-muted mt-2" style="max-height: 150px; overflow-y: auto;">${book.description}</p>
                            </div>
                        ` : ''}
                    </div>
                </div>
            `;
            
            document.getElementById('bookModalBody').innerHTML = modalContent;
            
            // Mettre à jour le bouton d'emprunt dans le modal
            const modalFooter = document.querySelector('#bookModal .modal-footer');
            if (book.available > 0) {
                modalFooter.innerHTML = `
                    <div class="d-flex flex-column flex-md-row gap-2 w-100">
                        <a href="<?= site_url('books/borrow/') ?>${book.id}" class="btn btn-success flex-fill">
                            <i class="fas fa-bookmark me-1 me-md-2"></i> Emprunter ce livre
                        </a>
                        <button type="button" class="btn btn-secondary flex-fill" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1 me-md-2"></i> Fermer
                        </button>
                    </div>
                `;
            } else {
                modalFooter.innerHTML = `
                    <div class="d-flex flex-column flex-md-row gap-2 w-100">
                        <button type="button" class="btn btn-outline-secondary flex-fill" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1 me-md-2"></i> Fermer
                        </button>
                        <button class="btn btn-outline-primary flex-fill" onclick="alert('Fonctionnalité de notification à venir')">
                            <i class="fas fa-bell me-1 me-md-2"></i> Être notifié
                        </button>
                    </div>
                `;
            }
            
            // Ajuster la taille de la modal pour mobile
            const modalElement = document.getElementById('bookModal');
            const modal = new bootstrap.Modal(modalElement);
            
            // Adapter la modal pour mobile
            if (window.innerWidth < 768) {
                modalElement.querySelector('.modal-dialog').classList.add('modal-fullscreen', 'modal-dialog-scrollable');
            } else {
                modalElement.querySelector('.modal-dialog').classList.remove('modal-fullscreen', 'modal-dialog-scrollable');
                modalElement.querySelector('.modal-dialog').classList.add('modal-lg');
            }
            
            modal.show();
            
            // Réécouter le redimensionnement de la fenêtre
            window.addEventListener('resize', function() {
                if (window.innerWidth < 768) {
                    modalElement.querySelector('.modal-dialog').classList.add('modal-fullscreen', 'modal-dialog-scrollable');
                } else {
                    modalElement.querySelector('.modal-dialog').classList.remove('modal-fullscreen', 'modal-dialog-scrollable');
                    modalElement.querySelector('.modal-dialog').classList.add('modal-lg');
                }
            });
        })
        .catch(error => {
            console.error('Erreur:', error);
            document.getElementById('bookModalBody').innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Erreur lors du chargement des détails du livre.
                </div>
            `;
            
            const modalElement = document.getElementById('bookModal');
            const modal = new bootstrap.Modal(modalElement);
            
            if (window.innerWidth < 768) {
                modalElement.querySelector('.modal-dialog').classList.add('modal-fullscreen');
            }
            
            modal.show();
        });
}
</script>
<?= $this->endSection() ?>
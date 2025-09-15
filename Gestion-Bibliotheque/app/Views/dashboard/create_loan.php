<?= $this->extend('dashboard/layout') ?>

<?= $this->section('content') ?>

<!-- Titre et bouton retour -->
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
    <h1 class="h3 text-gray-800 mb-2 mb-sm-0"><?= $page_title ?></h1>
    <a href="<?= base_url('/admin/dashboard/loans') ?>" class="btn btn-secondary btn-sm w-100 w-sm-auto mb-2 mb-sm-0">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Retour
    </a>
</div>

<!-- Formulaire Nouvel Emprunt -->
<div class="card shadow mb-4 p-3">
    <?php if (session()->has('errors')): ?>
        <div class="alert alert-danger">
            <?php foreach (session('errors') as $error): ?>
                <p class="mb-1"><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('/admin/dashboard/loans/store') ?>" method="post">
        <?= csrf_field() ?>
        
        <div class="row">
            <!-- Livre -->
            <div class="col-lg-6 mb-3">
                <label for="book_id" class="form-label">Livre *</label>
                <select class="form-control" id="book_id" name="book_id" required onchange="updateBookPreview(this)">
                    <option value="">Sélectionner un livre</option>
                    <?php foreach ($books as $book): ?>
                        <?php if ($book['available'] > 0): ?>
                            <option value="<?= $book['id'] ?>" 
                                    data-cover="<?= $book['cover_image'] ?>" 
                                    data-author="<?= esc($book['author']) ?>"
                                    data-isbn="<?= esc($book['isbn']) ?>"
                                    <?= old('book_id') == $book['id'] ? 'selected' : '' ?>>
                                <?= esc($book['title']) ?> - <?= esc($book['author']) ?> 
                                (Disponible: <?= $book['available'] ?>)
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <small class="form-text text-muted">Seuls les livres disponibles sont affichés</small>

                <div id="bookPreview" class="mt-3 p-3 border rounded" style="display: none;">
                    <div class="d-flex align-items-center">
                        <img id="previewCover" src="" alt="Couverture" class="book-cover me-3" style="width:60px; height:84px; object-fit:cover;">
                        <div>
                            <h6 id="previewTitle" class="mb-1"></h6>
                            <p class="mb-1 small" id="previewAuthor"></p>
                            <small class="text-muted" id="previewIsbn"></small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Emprunteur -->
            <div class="col-lg-6 mb-3">
                <label for="user_id" class="form-label">Emprunteur *</label>
                <select class="form-control" id="user_id" name="user_id" required>
                    <option value="">Sélectionner un emprunteur</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= $user['id'] ?>" <?= old('user_id') == $user['id'] ? 'selected' : '' ?>>
                            <?= esc($user['first_name']) ?> <?= esc($user['last_name']) ?> - <?= esc($user['email']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="loan_date" class="form-label">Date d'emprunt *</label>
                <input type="date" class="form-control" id="loan_date" name="loan_date" 
                       value="<?= old('loan_date', date('Y-m-d')) ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="due_date" class="form-label">Date de retour prévue *</label>
                <input type="date" class="form-control" id="due_date" name="due_date" 
                       value="<?= old('due_date', date('Y-m-d', strtotime('+30 days'))) ?>" required>
                <small class="form-text text-muted">30 jours par défaut</small>
            </div>
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Notes supplémentaires sur l'emprunt..."><?= old('notes') ?></textarea>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <button type="submit" class="btn btn-primary btn-sm w-100 w-md-auto">Créer l'emprunt</button>
            <a href="<?= base_url('/admin/dashboard/loans') ?>" class="btn btn-secondary btn-sm w-100 w-md-auto">Annuler</a>
        </div>
    </form>
</div>

<script>
    function updateBookPreview(select) {
        const preview = document.getElementById('bookPreview');
        const selectedOption = select.options[select.selectedIndex];
        
        if (select.value) {
            const coverImage = selectedOption.getAttribute('data-cover');
            const author = selectedOption.getAttribute('data-author');
            const isbn = selectedOption.getAttribute('data-isbn');
            const title = selectedOption.text.split(' - ')[0];
            
            document.getElementById('previewTitle').textContent = title;
            document.getElementById('previewAuthor').textContent = author;
            document.getElementById('previewIsbn').textContent = isbn ? 'ISBN: ' + isbn : '';
            
            if (coverImage) {
                document.getElementById('previewCover').src = '<?= base_url('uploads/books/') ?>' + coverImage;
                document.getElementById('previewCover').style.display = 'block';
            } else {
                document.getElementById('previewCover').style.display = 'none';
            }
            
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    }

    function checkUserLoanLimit(userId) {
        if (!userId) return;
        
        fetch(<?= base_url('/admin/dashboard/loans/user-loan-count/') ?>${userId})
            .then(response => response.json())
            .then(data => {
                const settings = <?= json_encode($settings ?? []) ?>;
                const maxLoans = settings.max_books_per_user || 5;
                
                if (data.activeLoans >= maxLoans) {
                    alert("⚠ Attention: Cet utilisateur a déjà ${data.activeLoans} emprunt(s) actif(s). Limite: ${maxLoans} livre(s).");
                }
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const bookSelect = document.getElementById('book_id');
        if (bookSelect.value) updateBookPreview(bookSelect);
        bookSelect.addEventListener('change', function() { updateBookPreview(this); });
        document.getElementById('user_id').addEventListener('change', function() { checkUserLoanLimit(this.value); });
    });
</script>

<style>
    #bookPreview {
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }

    @media (max-width: 768px) {
        #bookPreview .d-flex { flex-direction: column; text-align: center; }
        #previewCover { margin-right: 0 !important; margin-bottom: 10px; }
    }

    @media (max-width: 576px) {
        .d-flex.gap-2.flex-wrap { flex-direction: column; width: 100%; }
        .d-flex.gap-2.flex-wrap .btn { width: 100%; margin-bottom: 0.5rem; }
    }
</style>

<?= $this->endSection() ?>
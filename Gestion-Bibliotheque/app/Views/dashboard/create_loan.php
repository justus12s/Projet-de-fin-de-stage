<?= $this->extend('dashboard/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $page_title ?></h1>
        <a href="<?= base_url('/admin/dashboard/loans') ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Retour
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Nouvel Emprunt</h6>
        </div>
        <div class="card-body">
            <?php if (session()->has('errors')): ?>
                <div class="alert alert-danger">
                    <?php foreach (session('errors') as $error): ?>
                        <p><?= $error ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form action="<?= base_url('/admin/dashboard/loans/store') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6">

                       

                        <div class="form-group">
                            <label for="book_id">Livre *</label>
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
                            
                            <!-- Aperçu du livre sélectionné -->
                            <div id="bookPreview" class="mt-3 p-3 border rounded" style="display: none;">
                                <div class="d-flex align-items-center">
                                    <img id="previewCover" src="" alt="Couverture" 
                                        style="width: 60px; height: 84px; object-fit: cover; border-radius: 4px; margin-right: 15px;">
                                    <div>
                                        <h6 id="previewTitle"></h6>
                                        <p class="mb-1" id="previewAuthor"></p>
                                        <small class="text-muted" id="previewIsbn"></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="user_id">Emprunteur *</label>
                            <select class="form-control" id="user_id" name="user_id" required>
                                <option value="">Sélectionner un emprunteur</option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user['id'] ?>" <?= old('user_id') == $user['id'] ? 'selected' : '' ?>>
                                        <?= esc($user['first_name']) ?> <?= esc($user['last_name']) ?> 
                                        - <?= esc($user['email']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="loan_date">Date d'emprunt *</label>
                            <input type="date" class="form-control" id="loan_date" name="loan_date" 
                                   value="<?= old('loan_date', date('Y-m-d')) ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="due_date">Date de retour prévue *</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" 
                                   value="<?= old('due_date', date('Y-m-d', strtotime('+30 days'))) ?>" required>
                            <small class="form-text text-muted">30 jours par défaut</small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3" 
                              placeholder="Notes supplémentaires sur l'emprunt..."><?= old('notes') ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Créer l'emprunt</button>
                <a href="<?= base_url('/admin/dashboard/loans') ?>" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
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



// Après la fonction updateBookPreview, ajoutez :
function checkUserLoanLimit(userId) {
    if (!userId) return;
    
    fetch(`<?= base_url('/admin/dashboard/loans/user-loan-count/') ?>${userId}`)
        .then(response => response.json())
        .then(data => {
            const settings = <?= json_encode($settings ?? []) ?>;
            const maxLoans = settings.max_books_per_user || 5;
            
            if (data.activeLoans >= maxLoans) {
                alert(`⚠️ Attention: Cet utilisateur a déjà ${data.activeLoans} emprunt(s) actif(s). ` +
                      `Limite maximale: ${maxLoans} livre(s).`);
            }
        });
}

// Écouter les changements de sélection d'utilisateur
document.getElementById('user_id').addEventListener('change', function() {
    checkUserLoanLimit(this.value);
});



// Initialiser l'aperçu si un livre est déjà sélectionné
document.addEventListener('DOMContentLoaded', function() {
    const bookSelect = document.getElementById('book_id');
    if (bookSelect.value) {
        updateBookPreview(bookSelect);
    }
    
    // Écouter les changements de sélection
    bookSelect.addEventListener('change', function() {
        updateBookPreview(this);
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Calcul automatique de la date de retour
    const loanDateInput = document.getElementById('loan_date');
    const dueDateInput = document.getElementById('due_date');
    
    loanDateInput.addEventListener('change', function() {
        if (loanDateInput.value && !dueDateInput.value) {
            const loanDate = new Date(loanDateInput.value);
            loanDate.setDate(loanDate.getDate() + 30);
            dueDateInput.value = loanDate.toISOString().split('T')[0];
        }
    });
});
</script>
<?= $this->endSection() ?>
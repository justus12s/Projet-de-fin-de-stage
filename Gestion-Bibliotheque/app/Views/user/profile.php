<?= $this->extend('user/layout') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h4 class="mb-0"><i class="fas fa-user me-2"></i>Mon Profil</h4>
    </div>
    <div class="card-body">
        <!-- Messages Flash -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('profile/update') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <label for="first_name" class="form-label">Prénom</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" 
                           value="<?= old('first_name', $user['first_name'] ?? '') ?>" required>
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <label for="last_name" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" 
                           value="<?= old('last_name', $user['last_name'] ?? '') ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" 
                       value="<?= old('email', $user['email'] ?? '') ?>" required>
            </div>

            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <label for="phone" class="form-label">Téléphone</label>
                    <input type="tel" class="form-control" id="phone" name="phone" 
                           value="<?= old('phone', $user['phone'] ?? '') ?>">
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <label for="date_of_birth" class="form-label">Date de naissance</label>
                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" 
                           value="<?= old('date_of_birth', $user['date_of_birth'] ?? '') ?>">
                </div>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Adresse</label>
                <textarea class="form-control" id="address" name="address" rows="3"><?= old('address', $user['address'] ?? '') ?></textarea>
            </div>

            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <label for="institution" class="form-label">Établissement</label>
                    <input type="text" class="form-control" id="institution" name="institution" 
                           value="<?= old('institution', $user['institution'] ?? '') ?>">
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <label for="specialization" class="form-label">Spécialisation</label>
                    <input type="text" class="form-control" id="specialization" name="specialization" 
                           value="<?= old('specialization', $user['specialization'] ?? '') ?>">
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12 col-md-6 mb-3 mb-md-0">
                    <label class="form-label">Statut</label>
                    <div class="form-control-static p-2 bg-light rounded">
                        <span class="badge bg-info fs-6"><?= $user['status'] ?? 'Non défini' ?></span>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label">Rôle</label>
                    <div class="form-control-static p-2 bg-light rounded">
                        <span class="badge bg-<?= ($user['role'] ?? 'user') === 'admin' ? 'danger' : 'secondary' ?> fs-6">
                            <?= $user['role'] ?? 'user' ?>
                        </span>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 w-md-auto">
                <i class="fas fa-save me-2"></i> Mettre à jour le profil
            </button>
        </form>

        <hr class="my-4">

        <div class="mt-4">
            <h5 class="mb-3"><i class="fas fa-key me-2"></i>Changer le mot de passe</h5>
            <form action="<?= site_url('profile/change-password') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-12 col-md-4 mb-3">
                        <label for="current_password" class="form-label">Mot de passe actuel</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <label for="new_password" class="form-label">Nouveau mot de passe</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-warning w-100 w-md-auto">
                    <i class="fas fa-key me-2"></i> Changer le mot de passe
                </button>
            </form>
        </div>

        <!-- Informations supplémentaires -->
       
    </div>
</div>

<style>
/* Styles responsives pour le profil */
@media (max-width: 768px) {
    .card-header h4 {
        font-size: 1.25rem;
    }
    
    h5 {
        font-size: 1.1rem;
    }
    
    .form-label {
        font-weight: 500;
    }
    
    .btn {
        font-size: 0.9rem;
    }
    
    .badge.fs-6 {
        font-size: 0.8em !important;
    }
}

@media (max-width: 576px) {
    .card-body {
        padding: 1rem;
    }
    
    .form-control {
        padding: 0.5rem 0.75rem;
        font-size: 0.9rem;
    }
    
    .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
    
    .row > [class*="col-"] {
        margin-bottom: 1rem;
    }
    
    .fs-4 {
        font-size: 1.25rem !important;
    }
}

/* Améliorations visuelles */
.card {
    transition: box-shadow 0.2s ease;
}

.card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.form-control {
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.btn {
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

.bg-light {
    background-color: #f8f9fa !important;
}

/* Animation pour les cartes d'information */
.card.bg-light {
    transition: transform 0.2s ease;
}

.card.bg-light:hover {
    transform: translateY(-2px);
}

/* Style pour les séparateurs */
.border-top {
    border-top: 2px solid #e9ecef !important;
}

/* Style pour la liste d'activité */
.list-unstyled li {
    padding: 0.25rem 0;
    border-left: 3px solid transparent;
    transition: all 0.2s ease;
}

.list-unstyled li:hover {
    border-left-color: #0d6efd;
    padding-left: 0.5rem;
}
</style>

<script>
// Animation pour le chargement
document.addEventListener('DOMContentLoaded', function() {
    // Animation des éléments du formulaire
    const formElements = document.querySelectorAll('.form-control, .btn, .card');
    formElements.forEach((element, index) => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        element.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        
        setTimeout(() => {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, 100 + (index * 50));
    });

    // Validation basique du mot de passe
    const passwordForm = document.querySelector('form[action*="change-password"]');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert('Les mots de passe ne correspondent pas.');
            }
            
            if (newPassword.length < 6) {
                e.preventDefault();
                alert('Le mot de passe doit contenir au moins 6 caractères.');
            }
        });
    }
});

// Fonction pour afficher/masquer le mot de passe
function togglePasswordVisibility(inputId) {
    const input = document.getElementById(inputId);
    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
    input.setAttribute('type', type);
}
</script>
<?= $this->endSection() ?>
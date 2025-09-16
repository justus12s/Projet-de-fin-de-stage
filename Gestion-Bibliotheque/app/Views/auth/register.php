<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Inscription - Bibliothèque DJAB Excellence<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .register-hero {
        background: linear-gradient(135deg, rgba(13, 110, 253, 0.9) 0%, rgba(33, 37, 41, 0.9) 100%), url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1350&q=80');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 4rem 0;
        margin-bottom: 2rem;
        border-radius: 0 0 20px 20px;
    }
    
    .form-container {
        background-color: white;
        border-radius: 12px;
        padding: 2.5rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .form-container:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }
    
    .form-control {
        border-radius: 8px;
        border: 1px solid #dee2e6;
        padding: 0.75rem 1rem;
        transition: all 0.2s ease;
    }
    
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    
    .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    
    .form-check-input:checked {
        background-color: var(--primary);
        border-color: var(--primary);
    }
    
    .alert {
        border: none;
        border-radius: 8px;
        padding: 1rem 1.25rem;
    }
    
    .alert-danger {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border-left: 4px solid #dc3545;
    }
    
    .alert-success {
        background-color: rgba(25, 135, 84, 0.1);
        color: #198754;
        border-left: 4px solid #198754;
    }
    
    .status-fields {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid var(--primary);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <!-- Hero Section -->
    <section class="register-hero">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center animate-fade-in">
                    <h1 class="display-5 fw-bold mb-3">Inscription</h1>
                    <p class="lead mb-4">Créez votre compte pour accéder à notre bibliothèque</p>
                </div>
            </div>
        </div>
    </section>

    <div class="container animate-fade-in delay-1">
        <div class="form-container">
            <h2 class="h4 fw-bold text-center mb-4 text-primary"><i class="fas fa-book me-2"></i>Bibliothèque en Ligne</h2>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-4">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show mb-4">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('auth/register') ?>" method="POST">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Prénom *</label>
                            <input type="text" class="form-control <?= isset($errors['first_name']) ? 'is-invalid' : '' ?>" 
                                   name="first_name" value="<?= old('first_name') ?>" required>
                            <?php if (isset($errors['first_name'])): ?>
                                <div class="invalid-feedback"><?= $errors['first_name'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nom *</label>
                            <input type="text" class="form-control <?= isset($errors['last_name']) ? 'is-invalid' : '' ?>" 
                                   name="last_name" value="<?= old('last_name') ?>" required>
                            <?php if (isset($errors['last_name'])): ?>
                                <div class="invalid-feedback"><?= $errors['last_name'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email *</label>
                    <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                           name="email" value="<?= old('email') ?>" required>
                    <?php if (isset($errors['email'])): ?>
                        <div class="invalid-feedback"><?= $errors['email'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Mot de passe *</label>
                            <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                                   name="password" required>
                            <?php if (isset($errors['password'])): ?>
                                <div class="invalid-feedback"><?= $errors['password'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Confirmer le mot de passe *</label>
                            <input type="password" class="form-control <?= isset($errors['password_confirm']) ? 'is-invalid' : '' ?>" 
                                   name="password_confirm" required>
                            <?php if (isset($errors['password_confirm'])): ?>
                                <div class="invalid-feedback"><?= $errors['password_confirm'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Statut *</label>
                    <select class="form-control" name="status" required onchange="toggleStatusFields()">
                        <option value="">Sélectionnez votre statut</option>
                        <option value="student" <?= old('status') == 'student' ? 'selected' : '' ?>>Étudiant</option>
                        <option value="teacher" <?= old('status') == 'teacher' ? 'selected' : '' ?>>Enseignant</option>
                        <option value="professor" <?= old('status') == 'professor' ? 'selected' : '' ?>>Professeur</option>
                        <option value="professional" <?= old('status') == 'professional' ? 'selected' : '' ?>>Professionnel</option>
                        <option value="other" <?= old('status') == 'other' ? 'selected' : '' ?>>Autre</option>
                    </select>
                </div>

                <div id="studentFields" class="status-fields" style="display: <?= old('status') == 'student' ? 'block' : 'none' ?>;">
                    <h5 class="fw-semibold mb-3 text-primary"><i class="fas fa-graduation-cap me-2"></i>Informations étudiant</h5>
                    <div class="mb-3">
                        <label class="form-label">Numéro d'étudiant</label>
                        <input type="text" class="form-control" name="student_id" value="<?= old('student_id') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Établissement</label>
                        <input type="text" class="form-control" name="institution" value="<?= old('institution') ?>">
                    </div>
                </div>

                <div id="professionalFields" class="status-fields" style="display: <?= in_array(old('status'), ['teacher', 'professor', 'professional']) ? 'block' : 'none' ?>;">
                    <h5 class="fw-semibold mb-3 text-primary"><i class="fas fa-briefcase me-2"></i>Informations professionnelles</h5>
                    <div class="mb-3">
                        <label class="form-label">Institution/Entreprise</label>
                        <input type="text" class="form-control" name="institution" value="<?= old('institution') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fonction/Titre</label>
                        <input type="text" class="form-control" name="professional_title" value="<?= old('professional_title') ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Spécialisation/Domaine</label>
                    <input type="text" class="form-control" name="specialization" value="<?= old('specialization') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Téléphone</label>
                    <input type="tel" class="form-control" name="phone" value="<?= old('phone') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Adresse</label>
                    <textarea class="form-control" name="address" rows="2"><?= old('address') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date de naissance</label>
                    <input type="date" class="form-control" name="date_of_birth" value="<?= old('date_of_birth') ?>">
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-lg">
                    <i class="fas fa-user-plus me-2"></i> S'inscrire
                </button>

                <div class="text-center mt-4 pt-3 border-top">
                    <p class="mb-0">Déjà inscrit ? <a href="<?= site_url('login') ?>">Se connecter</a></p>
                </div>
            </form>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function toggleStatusFields() {
        const status = document.querySelector('[name="status"]').value;
        
        document.getElementById('studentFields').style.display = 'none';
        document.getElementById('professionalFields').style.display = 'none';
        
        if (status === 'student') {
            document.getElementById('studentFields').style.display = 'block';
        } else if (['teacher', 'professor', 'professional'].includes(status)) {
            document.getElementById('professionalFields').style.display = 'block';
        }
    }
</script>
<?= $this->endSection() ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Bibliothèque en Ligne</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .auth-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .auth-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 500px;
        }
        .auth-header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h2><i class="fas fa-book"></i> Bibliothèque en Ligne</h2>
                <p class="mb-0">Créez votre compte</p>
            </div>

            <div class="p-4">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show">
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

                    <div id="studentFields" style="display: <?= old('status') == 'student' ? 'block' : 'none' ?>;">
                        <div class="mb-3">
                            <label class="form-label">Numéro d'étudiant</label>
                            <input type="text" class="form-control" name="student_id" value="<?= old('student_id') ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Établissement</label>
                            <input type="text" class="form-control" name="institution" value="<?= old('institution') ?>">
                        </div>
                    </div>

                    <div id="professionalFields" style="display: <?= in_array(old('status'), ['teacher', 'professor', 'professional']) ? 'block' : 'none' ?>;">
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

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-user-plus"></i> S'inscrire
                    </button>

                    <div class="text-center mt-3">
                        <p>Déjà inscrit ? <a href="<?= site_url('login') ?>">Se connecter</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
</body>
</html>
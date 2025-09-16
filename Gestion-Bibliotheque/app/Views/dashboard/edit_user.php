<?= $this->extend('dashboard/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $page_title ?></h1>
        <a href="<?= base_url('/admin/dashboard/users') ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Retour
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Modifier l'Utilisateur</h6>
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

            <form action="<?= base_url('/admin/dashboard/users/update/' . $user['id']) ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name">Prénom *</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?= old('first_name', $user['first_name']) ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last_name">Nom *</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?= old('last_name', $user['last_name']) ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $user['email']) ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Téléphone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="<?= old('phone', $user['phone']) ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" id="generatePassword">
                                        <i class="fas fa-sync-alt"></i> Générer
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <small class="form-text text-muted" id="passwordStrength"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="role">Rôle *</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="">Sélectionner un rôle</option>
                                <option value="admin" <?= old('role', $user['role']) === 'admin' ? 'selected' : '' ?>>Administrateur</option>
                                <option value="user" <?= old('role', $user['role']) === 'user' ? 'selected' : '' ?>>Utilisateur</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Statut *</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="active" <?= old('status', $user['is_active'] ? 'active' : 'inactive') === 'active' ? 'selected' : '' ?>>Actif</option>
                                <option value="inactive" <?= old('status', $user['is_active'] ? 'active' : 'inactive') === 'inactive' ? 'selected' : '' ?>>Inactif</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_of_birth">Date de naissance</label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?= old('date_of_birth', $user['date_of_birth']) ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address">Adresse</label>
                    <textarea class="form-control" id="address" name="address" rows="2"><?= old('address', $user['address']) ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="student_id">ID Étudiant</label>
                            <input type="text" class="form-control" id="student_id" name="student_id" value="<?= old('student_id', $user['student_id']) ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="institution">Institution</label>
                            <input type="text" class="form-control" id="institution" name="institution" value="<?= old('institution', $user['institution']) ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="specialization">Spécialisation</label>
                            <input type="text" class="form-control" id="specialization" name="specialization" value="<?= old('specialization', $user['specialization']) ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="professional_title">Titre professionnel</label>
                    <input type="text" class="form-control" id="professional_title" name="professional_title" value="<?= old('professional_title', $user['professional_title']) ?>">
                </div>

                <div class="form-group">
                    <label for="membership_expiry">Date d'expiration d'userment</label>
                    <input type="date" class="form-control" id="membership_expiry" name="membership_expiry" value="<?= old('membership_expiry', $user['membership_expiry']) ?>">
                </div>

                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="<?= base_url('/admin/dashboard/users') ?>" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordField = document.getElementById('password');
    const generateBtn = document.getElementById('generatePassword');
    const toggleBtn = document.getElementById('togglePassword');
    const strengthText = document.getElementById('passwordStrength');

    // Fonction pour générer un mot de passe fort
    function generateStrongPassword(length = 12) {
        const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=[]{}|;:,.<>?";
        let password = "";
        
        // Assurer au moins un de chaque type
        password += "ABCDEFGHIJKLMNOPQRSTUVWXYZ".charAt(Math.floor(Math.random() * 26));
        password += "abcdefghijklmnopqrstuvwxyz".charAt(Math.floor(Math.random() * 26));
        password += "0123456789".charAt(Math.floor(Math.random() * 10));
        password += "!@#$%^&*()_+-=[]{}|;:,.<>?".charAt(Math.floor(Math.random() * 26));
        
        // Remplir le reste
        for (let i = password.length; i < length; i++) {
            password += charset.charAt(Math.floor(Math.random() * charset.length));
        }
        
        // Mélanger le mot de passe
        return password.split('').sort(() => Math.random() - 0.5).join('');
    }

    // Génération de mot de passe
    generateBtn.addEventListener('click', function() {
        const newPassword = generateStrongPassword();
        passwordField.value = newPassword;
        passwordField.type = 'text';
        
        // Afficher la force du mot de passe
        strengthText.textContent = "Mot de passe généré : " + checkPasswordStrength(newPassword);
        strengthText.className = "form-text text-success";
        
        // Revenir au champ password après 5 secondes
        setTimeout(() => {
            passwordField.type = 'password';
        }, 5000);
    });

    // Afficher/Masquer le mot de passe
    toggleBtn.addEventListener('click', function() {
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleBtn.innerHTML = '<i class="fas fa-eye-slash"></i>';
        } else {
            passwordField.type = 'password';
            toggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
        }
    });

    // Vérifier la force du mot de passe en temps réel
    passwordField.addEventListener('input', function() {
        if (passwordField.value) {
            strengthText.textContent = "Force du mot de passe : " + checkPasswordStrength(passwordField.value);
            strengthText.className = "form-text " + getStrengthColor(passwordField.value);
        } else {
            strengthText.textContent = "";
        }
    });

    // Fonction pour vérifier la force du mot de passe
    function checkPasswordStrength(password) {
        let strength = 0;
        
        if (password.length >= 8) strength++;
        if (password.match(/[a-z]+/)) strength++;
        if (password.match(/[A-Z]+/)) strength++;
        if (password.match(/[0-9]+/)) strength++;
        if (password.match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/)) strength++;
        
        switch(strength) {
            case 0: case 1: case 2: return "Faible";
            case 3: return "Moyen";
            case 4: return "Fort";
            case 5: return "Très fort";
            default: return "Faible";
        }
    }

    // Couleur en fonction de la force
    function getStrengthColor(password) {
        const strength = checkPasswordStrength(password);
        switch(strength) {
            case "Faible": return "text-danger";
            case "Moyen": return "text-warning";
            case "Fort": return "text-info";
            case "Très fort": return "text-success";
            default: return "text-muted";
        }
    }
});
</script>
<?= $this->endSection() ?>
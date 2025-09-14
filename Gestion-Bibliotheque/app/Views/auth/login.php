<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Connexion - Bibliothèque DJAB Excellence<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .login-hero {
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
        max-width: 450px;
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
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <!-- Hero Section -->
    <section class="login-hero">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center animate-fade-in">
                    <h1 class="display-5 fw-bold mb-3">Connexion</h1>
                    <p class="lead mb-4">Connectez-vous à votre compte</p>
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
            
            <form action="<?= site_url('auth/login') ?>" method="POST">
                <?= csrf_field() ?>
                
                <div class="mb-4">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="<?= old('email') ?>" required>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Se souvenir de moi</label>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 mb-3">
                    <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                </button>

                <div class="text-center mt-3">
                    <a href="<?= site_url('forgot-password') ?>">Mot de passe oublié ?</a>
                </div>

                <div class="text-center mt-3 pt-3 border-top">
                    <p class="mb-0">Pas encore inscrit ? <a href="<?= site_url('register') ?>">Créer un compte</a></p>
                </div>
            </form>
        </div>
    </div>
<?= $this->endSection() ?>
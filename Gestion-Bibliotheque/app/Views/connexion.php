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
                    <p class="lead mb-4">Accédez à votre espace personnel pour gérer vos emprunts et réservations</p>
                </div>
            </div>
        </div>
    </section>

    <div class="container animate-fade-in delay-1">
        <div class="form-container">
            <h2 class="h4 fw-bold text-center mb-4 text-primary"><i class="fas fa-sign-in-alt me-2"></i>Connectez-vous</h2>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-4">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show mb-4">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <form action="<?= base_url('login/authenticate') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="mb-4">
                    <label for="email" class="form-label fw-semibold">Adresse e-mail</label>
                    <input type="email" class="form-control" id="email" name="email" required 
                           placeholder="votre@email.com" value="<?= old('email') ?>">
                </div>
                
                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" required 
                           placeholder="Votre mot de passe">
                    <div class="form-text">
                        <a href="<?= base_url('forgot-password') ?>" class="text-decoration-none text-primary">Mot de passe oublié ?</a>
                    </div>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Se souvenir de moi</label>
                </div>
                
                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                    </button>
                </div>
            </form>
            
            <div class="text-center mt-4 pt-3 border-top">
                <p class="mb-2 text-muted">Vous n'avez pas de compte ?</p>
                <a href="<?= base_url('register') ?>" class="btn btn-outline-primary">
                    <i class="fas fa-user-plus me-2"></i>Créer un compte
                </a>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
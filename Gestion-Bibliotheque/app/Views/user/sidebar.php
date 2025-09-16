<div class="sidebar-sticky pt-3">
    <div class="text-center mb-4 p-3">
        <i class="fas fa-user-circle fa-3x text-white"></i>
        <h6 class="mt-2 text-white"><?= $user['name'] ?? 'Utilisateur' ?></h6>
        <span class="badge bg-info"><?= $user['status'] ?? 'Membre' ?></span>
    </div>
    
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link text-white <?= current_url() == site_url('dashboard') ? 'active bg-primary' : '' ?>" 
               href="<?= site_url('dashboard') ?>">
                <i class="fas fa-tachometer-alt"></i> Tableau de bord
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white <?= current_url() == site_url('books') ? 'active bg-primary' : '' ?>" 
               href="<?= site_url('books') ?>">
                <i class="fas fa-book"></i> Livres disponibles
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white <?= current_url() == site_url('my-books') ? 'active bg-primary' : '' ?>" 
               href="<?= site_url('my-books') ?>">
                <i class="fas fa-book-open"></i> Mes emprunts
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white <?= current_url() == site_url('history') ? 'active bg-primary' : '' ?>" 
               href="<?= site_url('history') ?>">
                <i class="fas fa-history"></i> Mon historique
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white <?= current_url() == site_url('my-reservations') ? 'active bg-primary' : '' ?>" 
               href="<?= site_url('my-reservations') ?>">
                <i class="fas fa-calendar-check"></i> Mes réservations
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white <?= current_url() == site_url('profile') ? 'active bg-primary' : '' ?>" 
               href="<?= site_url('profile') ?>">
                <i class="fas fa-user"></i> Mon profil
            </a>
        </li>
        <li class="nav-item mt-3">
            <a class="nav-link text-warning" href="<?= site_url('logout') ?>">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </a>
        </li>
    </ul>
</div>
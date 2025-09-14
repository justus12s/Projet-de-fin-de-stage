<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Guide d'Utilisation - Bibliothèque DJAB Excellence<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .guide-section {
        background-color: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
        transition: all 0.3s ease;
    }
    
    .guide-section:hover {
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        transform: translateY(-3px);
    }
    
    .guide-section h2 {
        border-bottom: 3px solid var(--primary);
        padding-bottom: 0.5rem;
        margin-bottom: 1.5rem;
    }
    
    .guide-section ul {
        padding-left: 1.5rem;
    }
    
    .guide-section li {
        margin-bottom: 0.5rem;
        position: relative;
    }
    
    .guide-section li strong {
        color: var(--primary);
    }
    
    .step-number {
        display: inline-block;
        width: 30px;
        height: 30px;
        background-color: var(--primary);
        color: white;
        border-radius: 50%;
        text-align: center;
        line-height: 30px;
        margin-right: 10px;
        font-weight: bold;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center animate-fade-in">
                    <h1 class="display-4 fw-bold mb-3">Guide d'Utilisation</h1>
                    <p class="lead mb-4">Découvrez comment naviguer et utiliser toutes les fonctionnalités de notre plateforme de bibliothèque en ligne</p>
                </div>
            </div>
        </div>
    </section>

    <div class="animate-fade-in delay-1">
        <!-- Section Démarrer -->
        <section class="guide-section">
            <h2 class="h3 fw-bold text-primary mb-4"><span class="step-number">1</span>Démarrer</h2>
            <p class="mb-4">Pour commencer, vous pouvez explorer le site en tant que visiteur ou vous connecter pour accéder à vos fonctionnalités personnelles.</p>
            
            <h3 class="h5 fw-semibold text-success mb-3">La Page d'Accueil</h3>
            <p class="mb-4">La page d'accueil est la vitrine de la bibliothèque. Elle met en avant les <strong>nouveautés</strong> et les <strong>livres les plus populaires</strong>, vous donnant des idées de lecture dès votre arrivée.</p>
            
            <h3 class="h5 fw-semibold text-success mb-3">La Page de Catalogue</h3>
            <p class="mb-2">C'est ici que vous trouverez l'ensemble de notre collection de livres. Vous pouvez :</p>
            <ul class="mb-4">
                <li><strong>Rechercher un livre</strong> par titre ou par auteur.</li>
                <li><strong>Filtrer les résultats</strong> par catégorie (roman, science-fiction, etc.) pour affiner votre recherche.</li>
            </ul>
        </section>

        <!-- Section Emprunter -->
        <section class="guide-section">
            <h2 class="h3 fw-bold text-primary mb-4"><span class="step-number">2</span>Emprunter un Livre</h2>
            <p class="mb-4">Pour emprunter un livre, vous devez être connecté.</p>
            
            <h3 class="h5 fw-semibold text-success mb-3">Sur la Page de Détail du Livre</h3>
            <p class="mb-2">En cliquant sur la couverture d'un livre, vous accédez à sa page de détails. Vous y trouverez :</p>
            <ul class="mb-4">
                <li>Un résumé de l'ouvrage.</li>
                <li>Des informations sur l'auteur.</li>
                <li>Son statut de disponibilité.</li>
            </ul>
            
            <p>Si le livre est disponible, un bouton vous permettra de l'emprunter. S'il est déjà emprunté, vous aurez la possibilité de le <strong>réserver</strong>.</p>
        </section>

        <!-- Section Gérer le compte -->
        <section class="guide-section">
            <h2 class="h3 fw-bold text-primary mb-4"><span class="step-number">3</span>Gérer votre Compte</h2>
            <p class="mb-4">Une fois connecté, la page <strong>"Mon Compte"</strong> devient votre espace personnel. Vous pouvez y :</p>
            
            <ul class="mb-4">
                <li>Consulter la liste de vos <strong>emprunts actuels</strong> avec les dates de retour.</li>
                <li>Gérer vos <strong>réservations</strong> et être notifié de la disponibilité des livres.</li>
                <li>Accéder à votre <strong>historique d'emprunts</strong> (cette fonctionnalité est en cours de développement).</li>
                <li>Gérer les informations de votre <strong>profil</strong>.</li>
            </ul>
        </section>

        <!-- Section Administration -->
        <section class="guide-section">
            <h2 class="h3 fw-bold text-primary mb-4"><span class="step-number">4</span>Panneau d'Administration</h2>
            <p class="mb-4">Cette section est réservée aux administrateurs de la bibliothèque. Elle permet de :</p>
            
            <ul class="mb-4">
                <li>Gérer l'ajout, la modification et la suppression de livres dans la base de données.</li>
                <li>Suivre les emprunts et les retours en temps réel.</li>
                <li>Gérer les utilisateurs de la plateforme.</li>
            </ul>
        </section>

        <!-- Section Technique -->
        <section class="guide-section">
            <h2 class="h3 fw-bold text-primary mb-4"><span class="step-number">5</span>Fonctionnement technique simplifié</h2>
            <p class="mb-4">Le site est structuré en deux parties principales qui travaillent ensemble :</p>
            
            <ul class="mb-4">
                <li><strong>Le Frontend (Interface) :</strong> C'est tout ce que vous voyez et avec quoi vous interagissez (les pages web, les boutons, les formulaires). Il est construit avec <strong>HTML, CSS et JavaScript</strong>.</li>
                <li><strong>Le Backend (Logique) :</strong> C'est la partie "invisible" qui gère la logique du site, comme la gestion des emprunts et des réservations, et les interactions avec la base de données. Il est développé avec <strong>PHP et MySQL</strong>.</li>
            </ul>
            
            <p>Ces deux parties communiquent pour que toutes vos actions soient prises en compte et que les informations soient mises à jour.</p>
        </section>

        <!-- Bouton de retour -->
        <div class="text-center mt-5">
            <a href="<?= base_url('/') ?>" class="btn btn-primary btn-lg">
                <i class="fas fa-home me-2"></i>Retour à l'accueil
            </a>
        </div>
    </div>
<?= $this->endSection() ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guide d'Utilisation - DJAB Excellence</title>
    <link rel="stylesheet" href="nav_footer.css">
    <link rel="stylesheet" href="acc_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php 
    require(__DIR__ . '/includes/header.php');
    ?>

    <main class="container my-5">
        <h1 class="display-5 fw-bold text-center mb-5 text-primary">Guide d'Utilisation de la Plateforme</h1>
        <p class="lead text-center mb-5 text-white">Ce guide vous aide à naviguer et à utiliser toutes les fonctionnalités de notre plateforme de bibliothèque en ligne, conçue pour vous offrir une expérience de lecture fluide et intuitive.</p>

        <section class="mb-5 p-4 rounded-4 shadow-sm bg-light">
            <h2 class="h4 mb-3 fw-bold text-success">1. Démarrer</h2>
            <p>Pour commencer, vous pouvez explorer le site en tant que visiteur ou vous connecter pour accéder à vos fonctionnalités personnelles.</p>
            <h3 class="h5 mt-4 fw-semibold text-primary">La Page d'Accueil</h3>
            <p>La page d'accueil est la vitrine de la bibliothèque. Elle met en avant les **nouveautés** et les **livres les plus populaires**, vous donnant des idées de lecture dès votre arrivée.</p>
            <h3 class="h5 mt-4 fw-semibold text-primary">La Page de Catalogue</h3>
            <p class="mb-2">C'est ici que vous trouverez l'ensemble de notre collection de livres. Vous pouvez :</p>
            <ul>
                <li>**Rechercher un livre** par titre ou par auteur.</li>
                <li>**Filtrer les résultats** par catégorie (roman, science-fiction, etc.) pour affiner votre recherche.</li>
            </ul>
        </section>

        <section class="mb-5 p-4 rounded-4 shadow-sm bg-light">
            <h2 class="h4 mb-3 fw-bold text-success">2. Emprunter un Livre</h2>
            <p>Pour emprunter un livre, vous devez être connecté.</p>
            <h3 class="h5 mt-4 fw-semibold text-primary">Sur la Page de Détail du Livre</h3>
            <p class="mb-2">En cliquant sur la couverture d'un livre, vous accédez à sa page de détails. Vous y trouverez :</p>
            <ul>
                <li>Un résumé de l'ouvrage.</li>
                <li>Des informations sur l'auteur.</li>
                <li>Son statut de disponibilité.</li>
            </ul>
            <p class="mt-4">Si le livre est disponible, un bouton vous permettra de l'emprunter. S'il est déjà emprunté, vous aurez la possibilité de le **réserver**.</p>
        </section>

        <section class="mb-5 p-4 rounded-4 shadow-sm bg-light">
            <h2 class="h4 mb-3 fw-bold text-success">3. Gérer votre Compte</h2>
            <p>Une fois connecté, la page **"Mon Compte"** devient votre espace personnel. Vous pouvez y :</p>
            <ul>
                <li>Consulter la liste de vos **emprunts actuels** avec les dates de retour.</li>
                <li>Gérer vos **réservations** et être notifié de la disponibilité des livres.</li>
                <li>Accéder à votre **historique d'emprunts** (cette fonctionnalité est en cours de développement).</li>
                <li>Gérer les informations de votre **profil**.</li>
            </ul>
        </section>

        <section class="mb-5 p-4 rounded-4 shadow-sm bg-light">
            <h2 class="h4 mb-3 fw-bold text-success">4. Panneau d'Administration</h2>
            <p>Cette section est réservée aux administrateurs de la bibliothèque. Elle permet de :</p>
            <ul>
                <li>Gérer l'ajout, la modification et la suppression de livres dans la base de données.</li>
                <li>Suivre les emprunts et les retours en temps réel.</li>
                <li>Gérer les utilisateurs de la plateforme.</li>
            </ul>
        </section>

        <section class="mb-5 p-4 rounded-4 shadow-sm bg-light">
            <h2 class="h4 mb-3 fw-bold text-success">Fonctionnement technique simplifié</h2>
            <p>Le site est structuré en deux parties principales qui travaillent ensemble :</p>
            <ul>
                <li>**Le Frontend (Interface) :** C'est tout ce que vous voyez et avec quoi vous interagissez (les pages web, les boutons, les formulaires). Il est construit avec **HTML, CSS et JavaScript**.</li>
                <li>**Le Backend (Logique) :** C'est la partie "invisible" qui gère la logique du site, comme la gestion des emprunts et des réservations, et les interactions avec la base de données. Il est développé avec **PHP et MySQL**.</li>
            </ul>
            <p class="mt-4">Ces deux parties communiquent pour que toutes vos actions soient prises en compte et que les informations soient mises à jour.</p>
        </section>

        <div class="text-center">
            <a href="index.php" class="btn btn-primary">Retour à l'accueil</a>
        </div>
    </main>

    <?php 
    require(__DIR__ . '/includes/footer.php');
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

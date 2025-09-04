<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque en ligne - DJAB Excellence</title>
    <link rel="stylesheet" href="acc_style.css">
    <link rel="stylesheet" href="nav_footer.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php
    require_once(__DIR__ . '/includes/header.php');
    ?>
    <main class="container my-5">
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold text-white shadow-sm">Bienvenue sur la plateforme de la bibliothèque DJAB Excellence</h1>
            <p class="lead text-light">Explorez, découvrez et lisez des milliers de livres et ressources en ligne.</p>
        </div>

        <section class="mb-5">
            <h2 class="mb-4 text-primary">Nouveautés</h2>
            <div class="row justify-content-center g-4">
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card shadow-sm h-100" style="width: 18rem; margin:auto;">
                        <img src="images/Harry-Potter-a-l-ecole-des-sorciers.jpg" class="card-img-top" alt="Harry Potter">
                        <div class="card-body">
                            <h5 class="card-title">Harry Potter</h5>
                            <p class="card-text">Découvrez la magie de Poudlard et suivez les aventures de Harry et ses amis.</p>
                            <a href="livre_description.php" class="btn btn-primary">Voir le livre</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card shadow-sm h-100" style="width: 18rem; margin:auto;">
                        <img src="images/moi_moche_et_mechant.png" class="card-img-top" alt="Moi, moche et méchant">
                        <div class="card-body">
                            <h5 class="card-title">Moi, moche et méchant</h5>
                            <p class="card-text">L’histoire hilarante de Gru et de ses célèbres Minions dans une aventure inoubliable.</p>
                            <a href="livre_description.php" class="btn btn-primary">Voir le livre</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card shadow-sm h-100" style="width: 18rem; margin:auto;">
                        <img src="images/cuisine.png" class="card-img-top" alt="Le Grand Custot">
                        <div class="card-body">
                            <h5 class="card-title">Le Grand Custot</h5>
                            <p class="card-text">Un recueil de recettes savoureuses pour tous les passionnés de cuisine.</p>
                            <a href="livre_description.php" class="btn btn-primary">Voir le livre</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-5">
            <h3 class="mb-4 text-success">Avis de nos abonnés</h3>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="avis h-100 shadow-sm">
                        <p>
                            "Une bibliothèque en ligne exceptionnelle ! J'ai trouvé tous les livres que je cherchais. L'interface est intuitive et le service de qualité. Je la recommande vivement."
                        </p>
                        <h4 class="fw-semibold mt-3">Sophie L.</h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="avis h-100 shadow-sm">
                        <p>
                            "En tant qu'étudiant, cette bibliothèque est une véritable aubaine. L'accès à une multitude de ressources académiques m'a énormément aidé dans mes recherches."
                        </p>
                        <h4 class="fw-semibold mt-3">Marc D.</h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="avis h-100 shadow-sm">
                        <p>
                            "Le choix est vaste et la navigation est un plaisir. DJAB Excellence est la meilleure bibliothèque en ligne que j'ai pu utiliser."
                        </p>
                        <h4 class="fw-semibold mt-3">Amira K.</h4>
                    </div>
                </div>
            </div>
        </section>

        <section class="sign py-5 px-3 rounded-4 shadow text-center mx-auto" style="max-width: 600px;">
            <h2 class="mb-3">Rejoignez notre communauté !</h2>
            <p class="mb-4">
                Accédez à des milliers de livres, articles et ressources exclusives. L'inscription est rapide et gratuite.
            </p>
            <a class="inscrit" href="inscription.php">S'inscrire maintenant</a>
        </section>
    </main>

    <?php
    require_once(__DIR__ . '/includes/footer.php');
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
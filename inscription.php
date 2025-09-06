<?php session_start()?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Bibliothèque DJAB Excellence</title>
    <!-- Les styles CSS sont directement inclus pour la simplicité -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            color: #212529;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .form-container {
            background-color: #ffffff;
            padding: 2.5rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
        }
        .form-control {
            border-radius: 0.5rem;
            border: 1px solid #ced4da;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            line-height: 1.5;
        }
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            border-radius: 0.5rem;
            font-weight: 600;
            padding: 0.75rem 1.25rem;
            font-size: 1rem;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }
        header {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        footer {
            background-color: #343a40;
            color: #f8f9fa;
            padding: 1rem 0;
            text-align: center;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="nav_footer.css">
</head>
<body>
    <?php 
    require(__DIR__ . '/includes/header.php');
    ?>

    <main class="container my-5">
        <div class="form-container">
            <h1 class="h3 fw-bold text-center mb-4 text-primary">Inscription</h1>
        <?php if (!isset($_SESSION['SUCCES_MESSAGE'])) : ?>
            <form action="submit_inscription.php" method="POST">
                <!-- si message d'erreur on l'affiche -->
                <?php if (isset($_SESSION['INSCRIPTION_ERROR'])) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['INSCRIPTION_ERROR'];
                        unset($_SESSION['INSCRIPTION_ERROR']); ?>
                    </div>
                <?php endif; ?>
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control" name="nom" required>
                </div>
                <div class="mb-3">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input type="text" class="form-control" name="prenom" required>
                </div>
                <div class="mb-3">
                    <label for="sexe" class="form-label">Sexe</label>
                    <select class="form-select form-control" name="sexe" required>
                        <option value="">Sélectionnez votre sexe</option>
                        <option value="Homme">Homme</option>
                        <option value="Femme">Femme</option>
                        <option value="Autre">Autre</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="date-naissance" class="form-label">Date de Naissance</label>
                    <input type="date" class="form-control" name="date-naissance" required>
                </div>
                <div class="mb-3">
                    <label for="statut" class="form-label">Statut</label>
                    <select class="form-select form-control" name="statut" required>
                        <option value="">Sélectionnez votre statut</option>
                        <option value="Étudiant">Étudiant</option>
                        <option value="Étudiant">Elève</option>
                        <option value="Professeur">Professeur</option>
                        <option value="Professionnel">Professionnel</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Adresse e-mail</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="confirm-password" class="form-label">Confirmer le mot de passe</label>
                    <input type="password" class="form-control" name="confirm-password" required>
                </div>
                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">S'inscrire</button>
                </div>
            </form>
            <div class="text-center mt-3">
                <p class="mb-0">Déjà un compte ? <a href="connexion.php" class="text-primary text-decoration-none fw-semibold">Connectez-vous ici.</a></p>
            </div>
        <?php else : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['SUCCES_MESSAGE']; ?>
            </div>
        <?php endif; ?>
        </div>
    </main>
    
    <?php 
    require(__DIR__ . '/includes/footer.php');
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

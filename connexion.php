<?php session_start();?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Bibliothèque DJAB Excellence</title>
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
            max-width: 400px;
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
            <h1 class="h3 fw-bold text-center mb-4 text-primary">Connexion</h1>
            <?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
                <form action="submit_connexion.php" method="POST">
                    <!-- si message d'erreur on l'affiche -->
                    <?php if (isset($_SESSION['LOGIN_ERROR_MESSAGE'])) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $_SESSION['LOGIN_ERROR_MESSAGE'];
                            unset($_SESSION['LOGIN_ERROR_MESSAGE']); ?>
                        </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="email-help" placeholder="you@exemple.com">
                        <div id="email-help" class="form-text">e-mail utilisé lors de la création de compte.</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
                <!-- Si utilisateur/trice bien connectée on affiche un message de succès -->
            <?php else : ?>
                <div class="alert alert-success" role="alert">
                    Bienvenue <?php echo $_SESSION['LOGGED_USER']['email']; ?> et bienvenue sur le site !
                </div>
            <?php endif; ?>
            <div class="text-center mt-3">
                <p class="mb-0">Vous n'avez pas de compte ? <a href="inscription.php" class="text-primary text-decoration-none fw-semibold">Inscrivez-vous ici.</a></p>
            </div>
        </div>
    </main>
    
    <?php 
    require(__DIR__ . '/includes/footer.php');
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

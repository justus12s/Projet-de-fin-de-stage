<?php
session_start();
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/connexion_bdd.php');
require_once(__DIR__ . '/functions.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = htmlspecialchars(trim($_POST["nom"]));
    $prenom = htmlspecialchars(trim($_POST["prenom"]));
    $sexe = htmlspecialchars(trim($_POST["sexe"]));
    $date_naissance = $_POST["date-naissance"];
    $statut = htmlspecialchars(trim($_POST["statut"]));
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm-password"];

    if ($password !== $confirm_password) {
        $_SESSION["INSCRIPTION_ERROR"] = "Les mots de passe ne correspondent pas.";
        header("Location: inscription.php");
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        $check = $mysqlClient->prepare("SELECT id_utilisateur FROM utilisateur WHERE email = ? OR prenom = ?");
        $check->execute([$email,$prenom]);

        if ($check->rowCount() > 0) {
            $_SESSION["LOGIN_ERROR_MESSAGE"] = "L'utilisateur existe déjà. Connectez-vous";
            header("Location: connexion.php");
            exit;
            redirectToUrl('connexion.php');
        }

        $sql = "INSERT INTO utilisateur (nom, prenom, sexe, naissance, statut, email, mot_de_passe) 
                VALUES (:nom, :prenom, :sexe, :naissance, :statut, :email, :password)";
        $stmt = $mysqlClient->prepare($sql);
        $stmt->execute([
            ":nom" => $nom,
            ":prenom" => $prenom,
            ":sexe" => $sexe,
            ":naissance" => $date_naissance,
            ":statut" => $statut,
            ":email" => $email,
            ":password" => $hashedPassword
        ]);

        $_SESSION["SUCCESS_MESSAGE"] = "Inscription réussie ! Vous pouvez vous connecter.";
        header("Location: connexion.php");
        exit;

    } catch (PDOException $e) {
        die("Erreur lors de l'inscription : " . $e->getMessage());
    }
}

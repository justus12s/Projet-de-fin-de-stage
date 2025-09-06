<?php
session_start();
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/connexion_bdd.php');
require_once(__DIR__ . '/functions.php');

$usersStatement = $mysqlClient->prepare('SELECT * FROM utilisateur');
$usersStatement->execute();
$users = $usersStatement->fetchAll();

$adminsStatement = $mysqlClient->prepare('SELECT * FROM administrateur');
$adminsStatement->execute();
$admins = $adminsStatement->fetchAll();

$postData = $_POST;

if (isset($postData['email']) && isset($postData['password'])) {

    if (!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['LOGIN_ERROR_MESSAGE'] = 'Il faut un email valide pour soumettre le formulaire.';
    } else {
        $found = false;

        foreach ($users as $user) {
            if ($user['email'] === $postData['email'] &&
                password_verify($postData['password'], $user['mot_de_passe'])) {

                $_SESSION['LOGGED_USER'] = [
                    'email' => $user['email'],
                    'user_id' => $user['user_id'],
                ];
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['LOGIN_ERROR_MESSAGE'] = sprintf(
                'Les informations envoyées ne permettent pas de vous identifier : (%s/%s)',
                $postData['email'],
                strip_tags($postData['password'])
            );
        }
    }

    redirectToUrl('index.php');
}

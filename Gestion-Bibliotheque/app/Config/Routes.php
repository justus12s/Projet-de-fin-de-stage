<?php
namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setAutoRoute(false);

// -----------------------------
// Routes publiques
// -----------------------------
$routes->get('/', 'Home::index');
$routes->get('a-propos', 'Home::a_propos');         // Slash remplacé par trait d'union
$routes->get('guide-utilisateur', 'Home::guide_utilisateur');
$routes->get('contact', 'Home::contact');

// Routes de création d'admin (à supprimer après utilisation)
$routes->get('create-super-admin', 'AdminCreator::createAdmin');
$routes->get('create-all-admins', 'AdminCreator::createMultipleAdmins');

// -----------------------------
// Routes d'authentification
// -----------------------------
$routes->get('register', 'AuthController::register');
$routes->post('auth/register', 'AuthController::attemptRegister');

$routes->get('login', 'AuthController::login');
$routes->post('auth/login', 'AuthController::attemptLogin');

$routes->get('logout', 'AuthController::logout');

$routes->get('forgot-password', 'AuthController::forgotPassword');
$routes->post('auth/forgot-password', 'AuthController::attemptForgotPassword');

$routes->get('reset-password/(:any)', 'AuthController::resetPassword/$1');
$routes->post('auth/reset-password', 'AuthController::attemptResetPassword');

// -----------------------------
// Routes protégées (utilisateurs)
// -----------------------------
$routes->group('', ['filter' => 'auth'], function($routes) {
    
    // Dashboard et profil
    $routes->get('dashboard', 'UserController::dashboard');
    $routes->get('profile', 'UserController::profile');
    $routes->post('profile/update', 'UserController::updateProfile');
    $routes->post('profile/change-password', 'UserController::changePassword');

    // Livres
    $routes->get('books', 'UserController::books'); 
    $routes->get('history', 'UserController::history'); 
    $routes->get('loan/view/(:num)', 'UserController::viewLoan/$1'); 
    $routes->get('api/book/(:num)', 'UserController::getBookDetails/$1');

    // Emprunts
    $routes->get('books/borrow/(:num)', 'UserController::borrow/$1'); 
    $routes->post('books/borrow/(:num)', 'UserController::borrowBook/$1'); 
    $routes->post('loan/return/(:num)', 'UserController::returnBook/$1'); 

    // Réservations
    $routes->get('books/confirm/(:num)', 'ReservationController::confirm/$1'); // Page confirmation réservation
    $routes->post('books/reserve/(:num)', 'ReservationController::reserve/$1'); // Action réservation
    $routes->get('my-reservations', 'ReservationController::myReservations');

    // Annullation de reservations ....
    $routes->get('reservations/cancel/(:num)', 'ReservationController::cancel/$1');
    // Suppression de lz reservztion ...    
    $routes->get('reservations/delete/(:num)', 'ReservationController::delete/$1');



});

// -----------------------------
// Routes administrateur
// -----------------------------
$routes->group('admin', ['filter' => 'auth:admin'], function($routes) {

    // Dashboard admin
    $routes->get('dashboard', 'AdminBookController::index');

    // Gestion des livres
    $routes->get('books', 'AdminBookController::index_livre');
    $routes->post('books/create', 'AdminBookController::create');
    $routes->get('books/view/(:num)', 'AdminBookController::view/$1');
    $routes->get('books/edit/(:num)', 'AdminBookController::edit/$1');
    $routes->post('books/update/(:num)', 'AdminBookController::update/$1');
    $routes->get('books/delete/(:num)', 'AdminBookController::delete/$1');

    // Gestion des utilisateurs
    $routes->get('users', 'AdminUserController::index');
    $routes->get('users/create', 'AdminUserController::create');
    $routes->post('users/store', 'AdminUserController::store');
    $routes->get('users/view/(:num)', 'AdminUserController::view/$1');
    $routes->get('users/edit/(:num)', 'AdminUserController::edit/$1');
    $routes->post('users/update/(:num)', 'AdminUserController::update/$1');
    $routes->get('users/delete/(:num)', 'AdminUserController::delete/$1');
    $routes->get('users/toggle-status/(:num)', 'AdminUserController::toggleStatus/$1');
    $routes->get('users/generate-password', 'AdminUserController::generatePassword');

    // Gestion des prêts
    $routes->get('loans', 'AdminLoanController::index');
    $routes->get('loans/create', 'AdminLoanController::create');
    $routes->post('loans/store', 'AdminLoanController::store');
    $routes->get('loans/return/(:num)', 'AdminLoanController::returnLoan/$1');
    $routes->get('loans/delete/(:num)', 'AdminLoanController::delete/$1');
    $routes->get('loans/view/(:num)', 'AdminLoanController::view/$1');
    $routes->get('overdue', 'AdminLoanController::overdue');
    $routes->get('loans/user-loan-count/(:num)', 'AdminLoanController::getUserLoanCount/$1');

    // Paramétrages
    $routes->get('settings', 'SettingsController::index');
    $routes->post('settings/save', 'SettingsController::save');

    // Statistiques
    $routes->get('stats', 'AdminStatsController::index');
});

// -----------------------------
// Autres routes
// -----------------------------
$routes->get('test-db', 'TestController::checkDB');

// -----------------------------
// Gestion erreur 404
// -----------------------------
$routes->set404Override(function() {
    return view('errors/html/error_404');
});

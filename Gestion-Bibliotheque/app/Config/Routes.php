<?php
namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setAutoRoute(false);

// Routes publiques
$routes->get('/', 'Home::index');
$routes->get('a_propos', 'Home::a_propos');         // ← Slash enlevé
$routes->get('guide_utilisateur', 'Home::guide_utilisateur');
$routes->get('contact', 'Home::contact');      // ← Slash enlevé
// Juste pour creer des utilisateur admin . Après , ces lignes de condes seront supprimées...
$routes->get('create-super-admin', 'AdminCreator::createAdmin');
$routes->get('create-all-admins', 'AdminCreator::createMultipleAdmins');

// Routes d'authentification
$routes->get('register', 'AuthController::register');
$routes->post('auth/register', 'AuthController::attemptRegister');
$routes->get('login', 'AuthController::login');
$routes->post('auth/login', 'AuthController::attemptLogin');
$routes->get('logout', 'AuthController::logout');
$routes->get('forgot-password', 'AuthController::forgotPassword');
$routes->post('auth/forgot-password', 'AuthController::attemptForgotPassword');
$routes->get('reset-password/(:any)', 'AuthController::resetPassword/$1');
$routes->post('auth/reset-password', 'AuthController::attemptResetPassword');



// Routes protégées (utilisateurs normaux)
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'UserController::dashboard');
    $routes->get('profile', 'UserController::profile');
    $routes->post('profile/update', 'UserController::updateProfile');
    $routes->get('my-books', 'UserController::myBooks');
    $routes->get('my-reservations', 'UserController::myReservations');
    $routes->get('books', 'UserController::books'); // ← Ajouter
    $routes->get('history', 'UserController::history'); // ← Ajouter
    $routes->get('loan/view/(:num)', 'UserController::viewLoan/$1'); // ← Ajouter
    $routes->get('api/book/(:num)', 'UserController::getBookDetails/$1');
    $routes->post('profile/change-password', 'UserController::changePassword');
    
    // ... routes existantes ...
    $routes->get('books/borrow/(:num)', 'UserController::borrow/$1'); // Page de confirmation d'emprunt
    $routes->post('books/borrow/(:num)', 'UserController::borrowBook/$1'); // Action d'emprunt
    $routes->post('loan/return/(:num)', 'UserController::returnBook/$1'); // Retour de livre

});





// Routes administrateur
$routes->group('admin', ['filter' => 'auth:admin'], function($routes) {
    $routes->group('dashboard', function($routes) {
        // Page d'accueil admin
        $routes->get('accueil', 'AdminBookController::index');
        
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

        // Gestion des prêts ( emprunts )...
        $routes->get('loans', 'AdminLoanController::index');
        $routes->get('loans/create', 'AdminLoanController::create');
        $routes->post('loans/store', 'AdminLoanController::store');
        $routes->get('loans/return/(:num)', 'AdminLoanController::returnLoan/$1');
        $routes->get('loans/delete/(:num)', 'AdminLoanController::delete/$1');
        $routes->get('loans/view/(:num)', 'AdminLoanController::view/$1');
        $routes->get('overdue', 'AdminLoanController::overdue');

        // Settings ( Parametrages )
        // Dans app/Config/Routes.php
        $routes->get('settings', 'SettingsController::index');
        $routes->post('settings/save', 'SettingsController::save');
        // Dans app/Config/Routes.php
        $routes->get('loans/user-loan-count/(:num)', 'AdminLoanController::getUserLoanCount/$1');

        // Statistiques
        $routes->get('stats', 'AdminStatsController::index');
    });
});

// Route pour tester la connexion BD
$routes->get('test-db', 'TestController::checkDB');

// Error route
$routes->set404Override(function() {
    return view('errors/html/error_404');
});





  

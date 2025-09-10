**Projet de Fin d'Études : Gestion de Bibliothèque en Ligne**
📚 Une application web complète développée avec CodeIgniter 4 pour la gestion efficace d'une bibliothèque. Cette plateforme permet aux administrateurs et aux utilisateurs de gérer les livres, les membres et les emprunts de manière intuitive et sécurisée.

**✨ Fonctionnalités**
**👥 Gestion des Utilisateurs**

Inscription et authentification sécurisée avec validation par email

Rôles distincts : Administrateurs, Étudiants, Enseignants, Professeurs et Bibliothécaires

Gestion des statuts d'activation et d'expiration d'abonnement

Tableaux de bord personnalisés selon le rôle et le statut

Système de récupération de mot de passe

**📖 Gestion des Livres**

Catalogue complet des livres avec images de couverture

Système de recherche et filtrage avancé par titre, auteur, catégorie, ISBN

Gestion des stocks (quantité totale et disponible)

Informations détaillées : titre, auteur, ISBN, catégorie, description, année de publication

CRUD complet (Create, Read, Update, Delete)

**🔄 Gestion des Emprunts**

Système d'emprunt avec dates de début, retour prévu et retour effectif

Suivi en temps réel du statut des emprunts (en attente, actif, retourné, en retard, annulé)

Notifications automatiques pour les retards de retour

Historique complet des transactions avec notes

Gestion des prolongations d'emprunt

**🛠️ Technologies Utilisées**

Backend : CodeIgniter 4 (PHP 7.4+)

Frontend : HTML5, CSS3, JavaScript, Bootstrap

Base de données : MySQL 5.7+

Sécurité : Validation des données, protection CSRF, hachage des mots de passe (bcrypt)

**📦 Structure du Projet**

Gestion-Bibliotheque/
├── app/
│   ├── Config/
│   │   ├── Database.php
│   │   └── Routes.php
│   ├── Controllers/
│   │   ├── Auth.php
│   │   ├── Books.php
│   │   ├── Loans.php
│   │   └── Users.php
│   ├── Models/
│   │   ├── UserModel.php
│   │   ├── BookModel.php
│   │   └── LoanModel.php
│   ├── Views/
│   │   ├── auth/
│   │   ├── books/
│   │   ├── loans/
│   │   ├── users/
│   │   └── dashboard/
│   └── Libraries/
├── public/
│   └── assets/
│       ├── css/
│       ├── js/
│       ├── images/
│       └── uploads/covers/
├── system/
└── writable/

**🗃️ Structure Détaillée de la Base de Données**

**Table users**

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    date_of_birth DATE,
    
    -- NOUVEAU : Type de statut avec plus d'options
    status ENUM('student', 'teacher', 'professor', 'librarian', 'professional', 'other') DEFAULT 'student',
    
    -- NOUVEAU : Informations spécifiques selon le statut
    student_id VARCHAR(50),              -- Numéro d'étudiant
    institution VARCHAR(255),            -- Université/École/Entreprise
    specialization VARCHAR(255),         -- Domaine d'études/spécialisation
    professional_title VARCHAR(100),     -- Titre professionnel
    
    role ENUM('admin', 'user') DEFAULT 'user',
    is_active TINYINT(1) DEFAULT 0,
    membership_expiry DATE,              -- NOUVEAU : Date d'expiration d'adhésion
    activation_code VARCHAR(32),
    reset_token VARCHAR(32),
    reset_expires DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Index pour les nouveaux champs
    INDEX idx_email (email),
    INDEX idx_role (role),
    INDEX idx_status (status),
    INDEX idx_institution (institution),
    INDEX idx_membership_expiry (membership_expiry),
    INDEX idx_active (is_active)
);


**Table books**

CREATE TABLE books (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    isbn VARCHAR(20) UNIQUE,
    category VARCHAR(100),
    description TEXT,
    publish_year YEAR,
    publisher VARCHAR(255),
    quantity INT DEFAULT 1,
    available INT DEFAULT 1,
    cover_image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

**Table loans**

CREATE TABLE loans (
    id INT PRIMARY KEY AUTO_INCREMENT,
    book_id INT NOT NULL,
    user_id INT NOT NULL,
    loan_date DATE NOT NULL,
    due_date DATE NOT NULL,
    return_date DATE NULL,
    status ENUM('pending', 'active', 'returned', 'overdue', 'cancelled') DEFAULT 'pending',
    notes TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);



**Contributeur de ces modifications : Abel KPOKOUTA**

---------------------------------------------------------------------------------------------------------------



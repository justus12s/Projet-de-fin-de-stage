<?php
namespace App\Controllers;

use App\Models\BookModel;
use App\Models\UserModel;
use App\Models\LoanModel; // modeles pour les emprunts...

class AdminBookController extends BaseController
{
    protected $bookModel;
    protected $userModel;
    protected $loanModel;
    
    public function __construct()
    {
        $this->bookModel = new BookModel();
        $this->userModel = new UserModel(); // Initialisation du model User...
        $this->loanModel = new LoanModel(); // Décommentez si vous avez un modèle Loan;
        helper(['form', 'url']);
    }


    public function index()
    {
        $loanModel = new LoanModel(); // Finalement imprémenter...
        
        // Récupérer les vraies statistiques
        $data = [
            'page_title' => 'Tableau de Bord',
            'total_books' => $this->bookModel->countAll(),
            'available_books' => $this->bookModel->where('available >', 0)->countAllResults(),
            'total_members' => $this->userModel->where('role', 'user')->countAllResults(),
            'active_members' => $this->userModel->where('role', 'user')
                                            ->where('is_active', 1)
                                            ->countAllResults(),
            'total_loans' => $loanModel->countAll(),
            'active_loans' => $loanModel->where('status', 'active')->countAllResults(),
            'overdue_loans' => $loanModel->where('status', 'overdue')->countAllResults(),
            'recent_loans' => $loanModel->getLoansWithDetails(['limit' => 5])
        ];
        
        return view('dashboard/index', $data);
    }


    public function index_livre()
    {
        // Debug: Vérifier si le contrôleur est appelé
        echo "<!-- Controller AdminBookController::index() appelé -->";
        
        $data = [
            'page_title' => 'Gestion des Livres',
            'books' => $this->bookModel->getBooks(),
            'total_books' => $this->bookModel->countAll()
        ];
        
        return view('dashboard/section_livre', $data);
    }


    public function create()
    {
        // Validation simple
        if (empty($_POST['title']) || empty($_POST['author'])) {
            return redirect()->to('/admin/dashboard/books')->with('error', 'Titre et auteur sont requis');
        }
        // admin/dashboard/acceuil
        // TRAITEMENT DE L'IMAGE (partie corrigée)
        $coverImageName = $this->handleImageUpload();
        
        // Préparation des données
        $data = [
            'title' => $_POST['title'],
            'author' => $_POST['author'],
            'isbn' => $_POST['isbn'] ?? null,
            'category' => $_POST['category'] ?? null,
            'description' => $_POST['description'] ?? null,
            'publish_year' => $_POST['publish_year'] ?? null,
            'publisher' => $_POST['publisher'] ?? null,
            'quantity' => $_POST['quantity'] ?? 1,
            'available' => $_POST['quantity'] ?? 1,
            'cover_image' => $coverImageName // On stocke le nom du fichier
        ];
        // Insertion
        if ($this->bookModel->insert($data)) {
            return redirect()->to('/admin/dashboard/books')->with('success', 'Livre ajouté avec succès !');
        } else {
            return redirect()->to('/admin/dashboard/books')->with('error', 'Erreur lors de l\'ajout');
        }
    }

    /**
     * admin/dashboard/acceuil
     * Gère l'upload de l'image de couverture
     */
    private function handleImageUpload()
    {
        $coverImage = $this->request->getFile('cover_image');
        
        // Si aucun fichier n'est uploadé ou s'il y a une erreur
        if (!$coverImage || $coverImage->getError() == 4) {
            return null; // Aucune image
        }
        
        // Vérifier que le fichier est valide
        if ($coverImage->isValid() && !$coverImage->hasMoved()) {
            // Créer le dossier s'il n'existe pas
            $uploadPath = ROOTPATH . 'public/uploads/books';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            // Générer un nom unique pour l'image
            $newName = $coverImage->getRandomName();
            
            // Déplacer le fichier uploadé
            if ($coverImage->move($uploadPath, $newName)) {
                return $newName;
            }
        }
        
        return null ;
    }

    public function view($id)
    {
        $book = $this->bookModel->find($id);
        if (!$book){
            return redirect()->to('/admin/dashboard/books')->with('error', 'Livre non trouvé');
        }

        $data = [
            'page_title' => 'Détails du Livre - ' . $book['title'],
            'book' => $book
        ];

        return view('dashboard/view_book' , $data);
    }

    /**
     * Affichage le formulaire de modification ...
     */

    public function edit($id)
    {
        $book = $this->bookModel->find($id);
        if (!$book){
            return redirect()->to('admin/dashboard/books')->with('error', 'Livre non trouvé');
        }

        $data = [
            'page_title' => 'Modifier le Livre - ' . $book['title'],
            'book' => $book,
            'Validation' => \Config\Services::validation()
        ];

        return view('dashboard/edit_book' , $data);
    }

    /**
     * Traite la modification d'un livre
     */
    public function update($id)
    {
        // Validation
        $validation = \Config\Services::validation();
        
        $rules = [
            'title' => 'required|min_length[2]|max_length[255]',
            'author' => 'required|min_length[2]|max_length[255]',
            'quantity' => 'required|numeric'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        // Traitement de l'image
        $coverImage = $this->handleImageUpload();
        $data = [
            'title' => $this->request->getPost('title'),
            'author' => $this->request->getPost('author'),
            'isbn' => $this->request->getPost('isbn'),
            'category' => $this->request->getPost('category'),
            'description' => $this->request->getPost('description'),
            'publish_year' => $this->request->getPost('publish_year'),
            'publisher' => $this->request->getPost('publisher'),
            'quantity' => $this->request->getPost('quantity')
        ];
        
        // Si une nouvelle image est uploadée
        if ($coverImage) {
            $data['cover_image'] = $coverImage;
            
            // Supprimer l'ancienne image si ce n'est pas l'image par défaut
            $oldBook = $this->bookModel->find($id);
            if ($oldBook['cover_image'] && $oldBook['cover_image'] !== 'default-cover.jpg') {
                $oldImagePath = ROOTPATH . 'public/uploads/books/' . $oldBook['cover_image'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }
        
        if ($this->bookModel->update($id, $data)) {
            return redirect()->to('/admin/dashboard/books')->with('success', 'Livre modifié avec succès !');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification');
        }
    }

  
    
    public function delete($id)
    {
        try {
            // 1. Validation de l'ID
            if (!is_numeric($id) || $id <= 0) {
                throw new \Exception('ID de livre invalide');
            }

            // 2. Recherche du livre
            $book = $this->bookModel->find($id);
            
            if (!$book) {
                return redirect()->to('/admin/dashboard/books')->with('error', 'Livre non trouvé');
            }

            // 3. Suppression de l'image si nécessaire
            if ($book['cover_image'] && $book['cover_image'] !== 'default-cover.jpg') {
                $imagePath = ROOTPATH . 'public/uploads/books/' . $book['cover_image'];
                
                if (file_exists($imagePath)) {
                    if (!unlink($imagePath)) {
                        log_message('error', 'Échec suppression image: ' . $imagePath);
                    }
                }
            }

            // 4. Suppression de la base de données
            if ($this->bookModel->delete($id)) {
                $message = 'Livre "' . $book['title'] . '" supprimé avec succès !';
                log_message('info', $message);
                return redirect()->to('/admin/dashboard/books')->with('success', $message);
            } else {
                throw new \Exception('Échec de la suppression en base de données');
            }

        } catch (\Exception $e) {
            // 5. Gestion des erreurs
            $errorMessage = 'Erreur lors de la suppression: ' . $e->getMessage();
            log_message('error', $errorMessage);
            
            return redirect()->to('/admin/dashboard/books')->with('error', $errorMessage);
        }
    }

   

}
 
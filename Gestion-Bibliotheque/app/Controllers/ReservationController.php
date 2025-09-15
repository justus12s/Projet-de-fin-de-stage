<?php

namespace App\Controllers;

use App\Models\BookModel;
use App\Models\ReservationModel;
use CodeIgniter\Controller;

class ReservationController extends Controller
{
    protected $bookModel;
    protected $reservationModel;

    public function __construct()
    {
        $this->bookModel = new BookModel();
        $this->reservationModel = new ReservationModel();
        helper(['url', 'form', 'session']);
    }

    /**
     * Affiche la page de confirmation de réservation
     */
    public function confirm($bookId)
    {
        $book = $this->bookModel->find($bookId);

        if (!$book) {
            return redirect()->to(site_url('books'))->with('error', 'Livre introuvable');
        }

        if ($book['available'] <= 0) {
            return redirect()->to(site_url('books'))->with('error', 'Ce livre n\'est plus disponible pour réservation');
        }

        return view('user/confirm_reservation', ['book' => $book]);
    }

    /**
     * Crée une réservation après confirmation
     */
    public function reserve($bookId)
    {
        $book = $this->bookModel->find($bookId);

        if (!$book) {
            return redirect()->to(site_url('books'))->with('error', 'Livre introuvable');
        }

        if ($book['available'] <= 0) {
            return redirect()->to(site_url('books'))->with('error', 'Ce livre n\'est plus disponible pour réservation');
        }

        // Vérifier si le formulaire est soumis en POST
        if ($this->request->getMethod() === 'post') {
            $this->reservationModel->insert([
                'user_id' => session()->get('user_id'),
                'book_id' => $bookId,
                'reserved_at' => date('Y-m-d H:i:s'),
                'status' => 'Réservé'
            ]);

            // Réduire le nombre disponible
            $this->bookModel->update($bookId, [
                'available' => $book['available'] - 1
            ]);

            return redirect()->to(site_url('books'))->with('success', 'Réservation confirmée !');
        }

        // Sinon, rediriger vers confirmation
        return redirect()->to(site_url('books/confirm/' . $bookId));
    }

    /**
     * Liste les réservations de l'utilisateur
     */
    public function myReservations()
    {
        $userId = session()->get('user_id');
        $reservations = $this->reservationModel
                             ->where('user_id', $userId)
                             ->orderBy('reserved_at', 'DESC')
                             ->findAll();

        return view('user/my_reservations', ['reservations' => $reservations]);
    }
}

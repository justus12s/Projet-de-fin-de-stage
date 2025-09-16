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
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('login');
        }

        $reservationModel = new \App\Models\ReservationModel();

        // Créer la réservation avec status "en_attente"
        $reservationModel->insert([
            'user_id' => $userId,
            'book_id' => $bookId,
            'reserved_at' => date('Y-m-d H:i:s'),
            'status' => 'en_attente'
        ]);

        // Message flash pour l'utilisateur
        session()->setFlashdata('success', 'Vous avez réservé le livre "' . esc($bookId) . '" avec succès ! En attente de confirmation par l’administrateur.');

        return redirect()->to('my-reservations');
    }





    

    /**
     * Liste les réservations de l'utilisateur
     */


    public function myReservations()
    {
        $userId = session()->get('user_id');
        $reservationModel = new \App\Models\ReservationModel();
        $bookModel = new \App\Models\BookModel();

        // Récupérer toutes les réservations de l'utilisateur
        $reservationsRaw = $reservationModel->where('user_id', $userId)
                                            ->orderBy('reserved_at', 'DESC')
                                            ->findAll();

        $reservations = [];
        foreach($reservationsRaw as $r) {
            $book = $bookModel->find($r['book_id']);
            $reservations[] = [
                'id' => $r['id'],
                'book_title' => $book['title'],
                'book_author' => $book['author'],
                'reserved_at' => $r['reserved_at'],
                'status' => $r['status']
            ];
        }

        return view('user/my_reservations', ['reservations' => $reservations]);
    }


    public function cancel($id)
    {
        $reservationModel = new \App\Models\ReservationModel();
        $reservationModel->update($id, ['status' => 'annulé']);
        session()->setFlashdata('success', 'Réservation annulée avec succès.');
        return redirect()->to(site_url('my-reservations'));
    }


    public function delete($id)
    {
        $reservationModel = new \App\Models\ReservationModel();
        $reservationModel->delete($id);
        session()->setFlashdata('success', 'Réservation supprimée avec succès.');
        return redirect()->to(site_url('my-reservations'));
    }














}

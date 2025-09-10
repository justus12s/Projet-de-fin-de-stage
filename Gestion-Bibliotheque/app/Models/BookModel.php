<?php
namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id','title', 'author', 'isbn', 'category', 
        'description', 'publish_year', 'publisher', 
        'quantity', 'available', 'cover_image'
    ];
    protected $returnType = 'array';

    public function getBooks()
    {
        return $this->findAll();
    }


        /**
     * Décrémente la disponibilité d'un livre
     */
    public function decrementAvailable($bookId)
    {
        $book = $this->find($bookId);
        if ($book && $book['available'] > 0) {
            $this->update($bookId, [
                'available' => $book['available'] - 1
            ]);
        }
    }

    /**
     * Incrémente la disponibilité d'un livre
     */
    public function incrementAvailable($bookId)
    {
        $book = $this->find($bookId);
        if ($book) {
            $this->update($bookId, [
                'available' => $book['available'] + 1
            ]);
        }
    }
    
    
}
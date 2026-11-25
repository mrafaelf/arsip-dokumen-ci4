<?php
namespace App\Models;

use CodeIgniter\Model;

class ArchiveModel extends Model
{
    protected $table         = 'archives';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['title', 'category_id', 'description', 'file_name', 'original_name', 'file_type', 'file_size'];
    protected $useTimestamps = true;

    public function withCategory()
    {
        return $this->select('archives.*, categories.name AS category_name')
                    ->join('categories', 'categories.id = archives.category_id');
    }
}

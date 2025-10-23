<?php

namespace App\Models;

use CodeIgniter\Model;

class NoteModel extends Model
{
    protected $table      = 'notes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'title', 'content', 'created_at', 'updated_at'];
    protected $useTimestamps = false;
}

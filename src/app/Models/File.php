<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public function getList($perPage)
    {
        $result = $this->select(['path', 'size', 'created_at'])
            ->orderBy('created_at', 'desc')
            ->simplePaginate($perPage)
            ->toArray();
        return $result;
    }
}

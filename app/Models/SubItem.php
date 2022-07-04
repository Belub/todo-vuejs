<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubItem extends Model
{
    use HasFactory;

    public function items() {
        return $this->belongsTo('App\Models\Item', 'author_id');
    }
}

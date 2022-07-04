<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubItem;

class Item extends Model
{
    use HasFactory;

    public function subItem() {
        return $this->hasMany(SubItem::class, 'item_id');
    }
}

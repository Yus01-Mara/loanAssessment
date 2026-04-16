<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CElement extends Model
{
    protected $fillable = ['name', 'code', 'weight'];

    public function subElements()
    {
        return $this->hasMany(CSubElement::class, 'element_id');
    }
}


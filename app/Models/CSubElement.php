<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CSubElement extends Model
{
    protected $fillable = ['element_id', 'name', 'weight'];

    public function element()
    {
        return $this->belongsTo(CElement::class);
    }

    public function ratings()
{
    return $this->hasMany(RatingScale::class, 'sub_element_id');
}
 }


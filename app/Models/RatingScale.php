<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingScale extends Model
{
    protected $fillable = ['sub_element_id', 'label', 'score'];

    public function subElement()
{
    return $this->belongsTo(CSubElement::class, 'sub_element_id');
}
 }


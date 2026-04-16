<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model
{
    protected $table = 'loan_applications';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'applicant_name',
        'business_name',
        'amount',
        'status',
    ];
}

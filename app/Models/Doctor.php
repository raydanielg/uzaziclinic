<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'specialization',
        'license_number',
        'status',
        'bio',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

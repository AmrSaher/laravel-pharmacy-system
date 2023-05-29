<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'priority',
        'owner_id',
        'governorate_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function governorate()
    {
        return $this->belongsTo(Governorate::class, 'governorate_id');
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
}

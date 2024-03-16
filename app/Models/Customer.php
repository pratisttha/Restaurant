<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'city',
        'street',
    ];

    public function visits(){
        $this->hasMany(Visit::class);
    }

    public function order(){
        return $this->hasMany(Order::class);
    }
}

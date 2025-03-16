<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'argent',
    ];
  

    public function user()
    {
        return $this->hasOne(User::class, 'wallet_id');
    }
}

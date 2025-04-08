<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'sender_id',
        'recever_id',
        'montant',
        'status',
        'date',
        // 'wallet_id'
    ];

    
    public function sender ()
    {
        return $this->belongsTo(User::class,'sender_id');
    }
    public function recever ()
    {
        return $this->belongsTo(User::class,'recever_id');
    }
    public function wallet ()
    {
        return $this->belongsTo(Wallet::class,'wallet_id');
    }

}

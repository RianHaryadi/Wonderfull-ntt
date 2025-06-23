<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'ticket_code',
        'status',
    ];

    public function transaction()
{
    return $this->belongsTo(Transaction::class);
}
}

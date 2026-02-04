<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['adoption_id', 'amount', 'payment_status'];

    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';

    public function adoption()
    {
        return $this->belongsTo(Adoption::class);
    }
}
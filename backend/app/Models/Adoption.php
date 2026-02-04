<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adoption extends Model
{
    protected $fillable = ['user_id', 'cat_id', 'status', 'message'];

    const STATUS_PENDING = 'pending';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_DECLINED = 'declined';
    const STATUS_COMPLETED = 'completed';


    public function user()
    {
    return $this->belongsTo(User::class);
    }

    public function cat()
    {
        return $this->belongsTo(Cat::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    protected $fillable = ['name', 'description', 'breed', 'gender','age', 'is_adopted', 'images', 'price'];

    protected $casts = [
        'images' => 'array'
    ];

    public function adoptions()
    {
        return $this->hasMany(Adoption::class);
    }

    // Add method to mark cat as adopted
    public function markAsAdopted()
    {
        $this->is_adopted = true;
        $this->save();
    }
}
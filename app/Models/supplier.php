<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['name', 'contact_name', 'phone', 'phone2','email', 'address'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'kana', 'tel', 'email', 'postcode', 'address', 'birthday', 'gender', 'memo'];


    public function scopeSearchCustomers($query, $input)
    {
        if ($input) {
            return $query->where('kana', 'like', $input . '%')->orWhere('tel', 'like', $input . '%');
        }

        return $query;
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}

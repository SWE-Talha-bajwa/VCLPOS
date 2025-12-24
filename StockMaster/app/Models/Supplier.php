<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'shop_name',
        'address',
        'city',
        'country',
    ];

    protected static function booted()
    {
        static::addGlobalScope('user', function ($builder) {
            if (auth()->check()) {
                $builder->where('user_id', auth()->id());
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

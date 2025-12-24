<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesReturn extends Model
{
    protected $fillable = [
        'sale_id',
        'user_id',
        'total_amount',
        'reason',
    ];

    protected static function booted()
    {
        static::addGlobalScope('user', function ($builder) {
            if (auth()->check()) {
                $builder->where('user_id', auth()->id());
            }
        });
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(SalesReturnItem::class);
    }
}

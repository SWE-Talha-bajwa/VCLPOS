<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adjustment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'date', 'reference', 'note'];

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

    public function details()
    {
        return $this->hasMany(AdjustmentDetail::class);
    }
}

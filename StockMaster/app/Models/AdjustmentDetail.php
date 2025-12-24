<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Added for HasFactory trait
use App\Models\Product; // Added for product relationship
use App\Models\Adjustment; // Added for adjustment relationship

class AdjustmentDetail extends Model
{
    use HasFactory;

    protected $fillable = ['adjustment_id', 'product_id', 'quantity', 'type'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function adjustment()
    {
        return $this->belongsTo(Adjustment::class);
    }
}

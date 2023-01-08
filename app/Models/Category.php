<?php

namespace App\Models;

use App\Traits\Multitenantable;
use Cknow\Money\Casts\MoneyDecimalCast;
use Cknow\Money\Casts\MoneyStringCast;
use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Category extends Model
{
    use HasFactory, Multitenantable;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    protected $casts = [
        'category_assigned' => MoneyDecimalCast::class . ':currency',
        'category_activity' => MoneyDecimalCast::class . ':currency',
        'category_available' => MoneyDecimalCast::class . ':currency',
    ];


}

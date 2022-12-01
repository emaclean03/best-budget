<?php

namespace App\Models;

use App\Traits\Multitenantable;
use Cknow\Money\Casts\MoneyDecimalCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, Multitenantable;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function budget(){
        return $this->belongsTo(Budget::class);
    }

    protected $casts = [
        'created_at'  => 'date:m-d-Y',
        'outflow' =>MoneyDecimalCast::class.':currency',
        'inflow' => MoneyDecimalCast::class.':currency',
    ];



}

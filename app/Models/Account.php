<?php

namespace App\Models;

use App\Traits\Multitenantable;
use Cknow\Money\Casts\MoneyDecimalCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory, Multitenantable;

    public $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function budget() {
        return $this->belongsTo(Budget::class);
    }

    public function transaction(){
        return $this->hasMany(Transaction::class);
    }

    protected $casts = [
        'cleared_balance' =>MoneyDecimalCast::class.':currency',
        'uncleared_balance' => MoneyDecimalCast::class.':currency',
        'working_balance' => MoneyDecimalCast::class.':currency',
    ];
}

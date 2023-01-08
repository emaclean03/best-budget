<?php

namespace App\Models;

use App\Traits\Multitenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Budget extends Model
{
    use HasFactory, Multitenantable;

    protected $guarded = [];



    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories():HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function account():HasMany
    {
        return $this->hasMany(Account::class);
    }

    public function transaction():HasMany
    {
        return $this->hasMany(Transaction::class);
    }

}

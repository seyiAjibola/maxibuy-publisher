<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug'];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionType extends Model
{
    /** @use HasFactory<\Database\Factories\SubscriptionTypeFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'label',
        'price',
    ];
}

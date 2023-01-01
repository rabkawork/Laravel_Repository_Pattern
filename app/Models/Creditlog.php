<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creditlog extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "credit_id",
        "amount",
        "description",
    ];

}

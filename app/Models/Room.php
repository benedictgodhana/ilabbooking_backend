<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms'; // Specify the table name if it differs from the default convention

    protected $fillable = [
        'name',
        'description',
        'capacity',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BcsAppearance extends Model
{
    use HasFactory;

    protected $hidden = ['character_id', 'created_at', 'deleted_at', 'id', 'updated_at'];
}

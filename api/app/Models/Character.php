<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'deleted_at', 'updated_at'];

    protected $appends = ['bb_appearances', 'bcs_appearances', 'occupations'];

    public function bbAppearances()
    {
        return $this->hasMany('App\Models\BbAppearance');
    }

    public function bcsAppearances()
    {
        return $this->hasMany('App\Models\BcsAppearance');
    }

    public function occupations()
    {
        return $this->hasMany('App\Models\Occupation');
    }

    public function getBbAppearancesAttribute()
    {
        return $this->bbAppearances()->pluck('season')->flatten();
    }

    public function getBcsAppearancesAttribute()
    {
        return $this->bcsAppearances()->pluck('season')->flatten();
    }

    public function getBirthdayAttribute($value)
    {
        return date('m/d/Y', strtotime($value));
    }

    public function getOccupationsAttribute()
    {
        return $this->occupations()->pluck('occupation')->flatten();
    }
}

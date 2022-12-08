<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function orgnaizations()
    {
        return $this->hasMany(Orgnaization::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orgnaization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'username',
        'email',
        'status',
        'country_id',
        'city_id',
        'subscriptions',
        'password',
        'description',
        'image'
    ];
    protected $hidden = [
        'password',
    ];
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function getImageAttribute(){
        return asset('uploads/images/org/'.$this->attributes['image']);
    }
}

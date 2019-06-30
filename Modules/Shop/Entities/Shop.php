<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = ['branch', 'city_id', 'app_id'];


    
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }


    public function application()
    {
        return $this->belongsTo('App\Models\Application\Application', 'app_id');
    }
}

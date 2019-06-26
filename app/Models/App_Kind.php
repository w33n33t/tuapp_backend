<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class App_Kind extends Model
{
   
    use SoftDeletes;

    public $table = 'app_kinds';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'title'
    ];

    public function application()
    {
        return $this->belongsToMany('App\Models\Application\Application', 'app_kind_application', 'app_kind_id', 'application_id');
    }

     
}

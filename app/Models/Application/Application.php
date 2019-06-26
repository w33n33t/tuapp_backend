<?php

namespace App\Models\Application;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Application",
 *      required={"text"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="title",
 *          description="string",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="services",
 *          description="services",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="appkinds",
 *          description="app kind",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class Application extends Model
{
    use SoftDeletes;

    public $table = 'applications';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'title'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required'
    ];

    public function services()
    {
        return $this->belongsToMany('App\Models\Service\Service', 'application_service', 'application_id', 'service_id');
    }

    public function appkinds()
    {
        return $this->belongsToMany('App\Models\App_Kind', 'app_kind_application', 'application_id', 'app_kind_id');
    }
    

}
 
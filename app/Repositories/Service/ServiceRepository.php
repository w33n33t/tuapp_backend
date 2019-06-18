<?php

namespace App\Repositories\Service;

use App\Models\Service\Service; 
use App\Repositories\BaseRepository;

/**
 * Class ServiceRepository
 * @package App\Repositories\Service
 * @version June 10, 2019, 3:28 pm UTC
*/

class ServiceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Service::class;
    }
}

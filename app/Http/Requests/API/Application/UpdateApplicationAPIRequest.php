<?php

namespace App\Http\Requests\API\Application;

use App\Models\Application\Application;
use InfyOm\Generator\Request\APIRequest;

class UpdateApplicationAPIRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Application::$rules;
    }
}

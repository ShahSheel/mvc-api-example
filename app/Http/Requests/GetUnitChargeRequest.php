<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class GetUnitChargeRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
           'started_at' => ['required','string']
        ];
    }


}

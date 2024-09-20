<?php
/*
 * File name: CreateSlideRequest.php
 * Last modified: 2021.01.25 at 15:38:33
 * Copyright (c) 2021
 */

namespace App\Http\Requests;

use App\Models\Slide;
use Illuminate\Foundation\Http\FormRequest;

class CreateSlideRequest extends FormRequest
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
        return Slide::$rules;
    }
}

<?php
/*
 * File name: CreateCustomPageRequest.php
 * Last modified: 2021.02.27 at 20:34:32
 * Copyright (c) 2021
 */

namespace App\Http\Requests;

use App\Models\CustomPage;
use Illuminate\Foundation\Http\FormRequest;

class CreateCustomPageRequest extends FormRequest
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
        return CustomPage::$rules;
    }
}

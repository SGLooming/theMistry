<?php
/*
 * File name: UpdatePaymentMethodRequest.php
 * Last modified: 2021.01.12 at 00:22:25
 * Copyright (c) 2021
 */

namespace App\Http\Requests;

use App\Models\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentMethodRequest extends FormRequest
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
        return PaymentMethod::$rules;
    }
}

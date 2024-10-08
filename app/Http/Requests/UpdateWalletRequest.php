<?php
/*
 * File name: UpdateWalletRequest.php
 * Last modified: 2021.08.10 at 18:04:10
 * Copyright (c) 2021
 */

namespace App\Http\Requests;

use App\Models\Wallet;
use Illuminate\Foundation\Http\FormRequest;

class UpdateWalletRequest extends FormRequest
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
        return Wallet::$rules;
    }
}

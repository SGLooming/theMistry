<?php
/*
 * File name: EProviderUser.php
 * Last modified: 2021.02.01 at 22:40:43
 * Copyright (c) 2021
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EProviderUser extends Model
{
    use HasFactory;
    public $table = 'e_provider_users';
    public $timestamps = false;
}

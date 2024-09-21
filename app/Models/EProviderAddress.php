<?php
/*
 * File name: EProviderAddress.php
 * Last modified: 2021.04.20 at 11:19:32
 * Copyright (c) 2021
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EProviderAddress extends Model
{
    use HasFactory;
    public $table = 'e_provider_addresses';
    public $timestamps = false;
}

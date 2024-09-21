<?php
/*
 * File name: EServiceCategory.php
 * Last modified: 2021.03.02 at 14:35:37
 * Copyright (c) 2021
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EServiceCategory extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'e_service_categories';
}

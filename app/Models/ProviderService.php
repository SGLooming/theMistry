<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderService extends Model
{
    public $timestamps = false;
    public function provider()
    {
        return EProvider::where('id', $this->id)->name;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProviderService extends Model
{
    use HasFactory;
    public $timestamps = false;
    public function provider()
    {
        return EProvider::where('id', $this->id)->name;
    }
}

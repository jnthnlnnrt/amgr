<?php

namespace App\Models\Catalogs;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaintenanceFrequency extends Model
{
    use HasFactory;

    protected $table = 'cat_maintenance_frequencies';

    public function assets(): HasMany{
        return $this->hasMany(Asset::class);
    }
}

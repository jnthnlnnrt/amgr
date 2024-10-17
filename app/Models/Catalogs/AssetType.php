<?php

namespace App\Models\Catalogs;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssetType extends Model
{
    protected $table = 'cat_asset_types';

    public function assets(): HasMany{
        return $this->hasMany(Asset::class);
    }
}

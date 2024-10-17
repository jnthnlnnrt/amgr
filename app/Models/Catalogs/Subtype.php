<?php

namespace App\Models\Catalogs;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subtype extends Model
{
    protected $table = 'cat_asset_subtypes';

    public function assets(): HasMany{
        return $this->hasMany(Asset::class);
    }
}

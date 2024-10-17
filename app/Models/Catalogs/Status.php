<?php

namespace App\Models\Catalogs;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    protected $table = 'cat_asset_statuses';

    public function assets(): HasMany{
        return $this->hasMany(Asset::class);
    }
}

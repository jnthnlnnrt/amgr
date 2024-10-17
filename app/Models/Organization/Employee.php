<?php

namespace App\Models\Organization;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'org_employees';

    protected  $fillable = [
        'internal_id',
        'name',
        'email',
        'department_id',
        'location_id',
        'status',
        'remarks',
        'created_by',
        'updated_by'
    ];

    public function department(): BelongsTo{
        return $this->belongsTo(Department::class);
    }

    public function location(): BelongsTo{
        return $this->belongsTo(Location::class);
    }

    public function assets(): HasMany{
        return $this->hasMany(Asset::class);
    }
}

<?php

namespace App\Models;

use App\Models\Catalogs\MaintenanceFrequency;
use App\Models\Catalogs\Manufacturer;
use App\Models\Catalogs\Status;
use App\Models\Catalogs\Subtype;
use App\Models\Organization\Employee;
use App\Models\Organization\Location;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asset extends Model
{
    use HasFactory;

    protected $table = 'assets';

    protected $fillable = [
        'category_id',
        'type_id',
        'subtype_id',
        'asset_tag',
        'manufacturer_id',
        'model',
        'serial',
        'imei',
        'mac_address',
        'ip_address',
        'ipmi_address',
        'status_id',
        'employee_id',
        'location_id',
        'require_maintenance',
        'frequency_id',
        'last_maintenance',
        'carry_authorization',
        'remarks',
        'created_by',
        'updated_by'
    ];

    public function manufacturer(): BelongsTo{
        return $this->belongsTo(Manufacturer::class);
    }

    public function subtype(): BelongsTo{
        return $this->belongsTo(Subtype::class);
    }

    public function status(): BelongsTo{
        return $this->belongsTo(Status::class);
    }

    public function employee(): BelongsTo{
        return $this->belongsTo(Employee::class);
    }

    public function location(): BelongsTo{
        return $this->belongsTo(Location::class);
    }

    public function frequency(): BelongsTo{
        return $this->belongsTo(MaintenanceFrequency::class);
    }
}

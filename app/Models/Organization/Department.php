<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    protected $table = 'org_departments';

    protected  $fillable = [
        'internal_id',
        'name',
        'remarks',
        'created_by',
        'updated_by'
    ];

    public function employees(): HasMany{
        return $this->hasMany(Employee::class);
    }
}

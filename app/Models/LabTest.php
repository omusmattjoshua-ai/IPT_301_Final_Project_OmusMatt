<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LabTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_name',
        'category',
        'price',
        'normal_range',
        'unit',
    ];

    protected function casts(): array
    {
        return ['price' => 'decimal:2'];
    }

    public function labResults(): HasMany
    {
        return $this->hasMany(LabResult::class);
    }

    public function labOrders(): BelongsToMany
    {
        return $this->belongsToMany(LabOrder::class, 'lab_results')
            ->withPivot(['result_value', 'remarks', 'result_date'])
            ->withTimestamps();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'specialization',
        'license_number',
        'contact_number',
        'email',
    ];

    public function labOrders(): HasMany
    {
        return $this->hasMany(LabOrder::class);
    }
}

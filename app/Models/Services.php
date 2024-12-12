<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'services_id',
        'customer_id',
        'device_details',
        'status',
        'cost_estimate'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'services_id' => 'string',
        'status' => 'string',
        'cost_estimate' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the customer associated with the service.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customers::class, 'customer_id');
    }

    /**
     * Scope a query to filter by service status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Check if the service is in a specific status.
     *
     * @param string $status
     * @return bool
     */
    public function isStatus($status)
    {
        return $this->status === $status;
    }

    /**
     * Find a service by its services_id.
     *
     * @param string $servicesId
     * @return \App\Models\Services|null
     */
    public static function findByServicesId($servicesId)
    {
        return self::where('services_id', $servicesId)->first();
    }
}
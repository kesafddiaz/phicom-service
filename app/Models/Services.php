<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Services extends Model
{
    protected $primaryKey = 'services_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'services_id',
        'customer_id',
        'service_details',
        'status',
        'total'
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transactions::class, 'services_id', 'services_id');
    }


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'services_id' => 'string',
        'status' => 'string',
        'total' => 'float',
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
     * Find a service by its id.
     *
     * @param string $servicesId
     * @return \App\Models\Services|null
     */
    public static function findByServicesId($servicesId)
    {
        return self::where('services_id', $servicesId)->first();
    }
    

    
}
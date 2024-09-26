<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class storeDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'store_name',
        'qty'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    public function customer()
    {
        return $this->hasMany(customer::class, 'customer_id', 'id');
    }
}
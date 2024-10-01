<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hobbies extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'hobbies'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->hasOne(user::class, 'user_id', 'id');
    }
}

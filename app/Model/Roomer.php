<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Roomer extends Model
{
    protected $table = 'roomer';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'fio',
        'passport_series',
        'passport_number',
        'status',
        'number_of_check_in'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function accommodations()
    {
        return $this->hasMany(Accommodation::class, 'roomer_id');
    }
}
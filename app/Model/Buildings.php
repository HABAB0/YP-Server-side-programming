<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $table = 'Building';
    public $timestamps = false;

    protected $fillable = ['name', 'address'];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'building_id');
    }
}
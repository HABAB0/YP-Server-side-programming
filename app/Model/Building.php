<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $table = 'buildings';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'address',
        'image_path'
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'building_id');
    }
}
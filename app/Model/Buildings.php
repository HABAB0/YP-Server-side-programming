<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Buildings extends Model
{
    protected $table = 'buildings';
    public $timestamps = false;

    protected $fillable = ['name', 'address'];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'building_id');
    }
}
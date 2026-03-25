<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
class Room extends Model
{
    protected $table = 'rooms';
    public $timestamps = false;

    protected $fillable = ['building_id', 'room_number', 'capacity', 'type', 'fullness'];

    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }
    public function accommodations()
    {
        return $this->hasMany(Accommodation::class, 'room_id');
    }
}
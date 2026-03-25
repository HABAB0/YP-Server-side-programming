<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    protected $table = 'accommodation';
    public $timestamps = false;

    protected $fillable = [
        'room_id',
        'roomer_id',
        'check_in_date',
        'check_out_date',
        'status',
        'order_number'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function roomer()
    {
        return $this->belongsTo(Roomer::class, 'roomer_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'accommodation_id');
    }
}
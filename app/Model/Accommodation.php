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

    public static function isRoomerActive(int $roomerId): bool
    {
        $count = self::query()
            ->where('roomer_id', $roomerId)
            ->where('status', 'Заселён')
            ->count();

        return $count > 0;
    }

    public function checkOut(string $date = null): bool
    {
        $this->check_out_date = $date ?? date('Y-m-d');
        $this->status = 'В ожидании';
        return $this->save();
    }

    public function getDaysCount(): int
    {
        $checkIn = new \DateTime($this->check_in_date);
        $checkOut = $this->check_out_date
            ? new \DateTime($this->check_out_date)
            : new \DateTime();

        $interval = $checkIn->diff($checkOut);
        return (int) $interval->format('%a');
    }
}
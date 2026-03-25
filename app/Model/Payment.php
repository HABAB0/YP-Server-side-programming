<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    public $timestamps = false;

    protected $fillable = [
        'accommodation_id',
        'amount',
        'payment_date',
        'due_date',
        'status',
        'order_number'
    ];

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class, 'accommodation_id');
    }
}
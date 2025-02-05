<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusPass extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'nic',
        'contact_number',
        'email',
        'start_location',
        'end_location',
        'distance',
        'province',
        'district',
        'pass_type',
        'start_date',
        'end_date',
        'amount',
        'status',
        'qr_code'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'buss_pass_id');
    }
}

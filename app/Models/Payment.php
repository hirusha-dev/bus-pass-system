<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'buss_pass_id',
        'payment_method',
        'amount',
        'payment_date',
        'status',
        'payment_slip'
    ];

    public function busPass()
    {
        return $this->belongsTo(BusPass::class, 'buss_pass_id');
    }
}

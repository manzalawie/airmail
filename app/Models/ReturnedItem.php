<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnedItem extends Model
{
    use HasFactory;

    protected $table = 'returned_items';

    protected $fillable = [
        'day', 'month', 'year',
        'warehouse',
        'inbound_transit',
        'inbound_returned',
        'ordinary_mail_transit',
        'ordinary_mail_returned',
        'uv_dispatches', 'uv_items', 'uv_weight',
        'ua_dispatches', 'ua_items', 'ua_weight',
        'ul_dispatches', 'ul_items', 'ul_weight',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Ticket extends Model
{
    protected $fillable = [
        'order_item_id',
        'ticket_code',
        'qr_token_hash',
        'qr_token',
        'status',
        'checked_in_at',
    ];

    protected function casts(): array
    {
        return [
            'checked_in_at' => 'datetime',
            'qr_token' => 'encrypted',
        ];
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }
}
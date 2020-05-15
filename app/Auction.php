<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $guarded = [];

    public function auctioneer()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class, 'auction_id', 'id');
    }
}
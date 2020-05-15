<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $guarded = [];

    public function bidder()
    {
        return $this->belongsTo(User::class, 'bid_by', 'id');
    }
}

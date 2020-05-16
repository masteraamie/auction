<?php

namespace App\Http\Controllers;

use App\Auction;
use App\Bid;
use App\User;
use Illuminate\Http\Request;
use Validator;

class BidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'auction_id' => 'required|exists:auctions,id',
            'amount' => 'required|numeric|gt:0',
            'bid_by' => 'required|exists:users,id'
        ]);

        if($validation->passes())
        {
            $amount = $request->amount;
            $auction = Auction::find($request->auction_id);

            if($auction->starting_bid > $amount)
            {
                return response()->json([
                    'status' => 'ERROR',
                    'error' => 'Bid amount cannot be less than minimum bid.'
                ]);
            }

            $last_bid = User::find($request->bid_by)->last_bid($request->auction_id, $request->bid_by);
            if($last_bid && $last_bid->amount >= $amount)
            {
                return response()->json([
                    'status' => 'ERROR',
                    'error' => 'Bid amount cannot be less than previous bid.'
                ]);
            }

            $max_bid = $auction->bids->max('amount');
            if($max_bid >= $amount)
            {
                return response()->json([
                    'status' => 'ERROR',
                    'error' => 'Bid amount cannot be less than current winning bid.'
                ]);
            }
            Bid::create($request->except('_token'));
            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Bid placed successfully'
            ]);
        }
        return response()->json([
            'status' => 'ERROR',
            'error' => 'Error placing the bid'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

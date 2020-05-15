<?php

namespace App\Http\Controllers;

use App\Auction;
use App\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $auctions = Auction::where('created_by', '<>' ,$user->id)->orderBy('id', 'desc')->get();
        return view('list-auctions', \compact('auctions'));
    }

    public function my_auctions()
    {
        //return $winning_bid = Bid::where('auction_id', 3)->max('amount');
        $user = Auth::user();
        $auctions = Auction::where('created_by', $user->id)->orderBy('id', 'desc')->get();
        return view('list-my-auctions', \compact('auctions', 'user'));
    }

    public function get_bids($auction_id, Request $request)
    {
        $auction = Auction::find($auction_id);

        $bids = $auction->bids->sortByDesc('amount');

        $data = [];
        $i = 1;
        foreach($bids as $bid)
        {
            $winner = '';
            if($i == 1 && $auction->status == 'live')
                $winner = '<span class="badge bg-success text-white badge-pill">Winning</span>';

            if($i == 1 && $auction->status == 'finished')
                $winner = '<span class="badge bg-success text-white badge-pill">Winner</span>';

            $i++;
            $data[] = [
                $bid->id,
                $bid->bidder->name,
                $bid->amount,
                date('d-m-Y h:i a', strtotime($bid->created_at)),
                $winner
            ];

        }
        return response()->json(
            [
                'draw' => (int)$request->draw,
                'recordsTotal' => $bids->count(),
                'recordsFiltered' => $bids->count(),
                'data' => $data
            ]
        );

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create-auction');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate( $request,[
            'name' => 'required',
            'starting_bid' => 'required|gte:0|numeric',
            'start_at' => 'required|date|after:today',
            'end_at' => 'required|date|after:start-at',
            'image' => 'required|file|max:2048|mimes:jpeg,jpg,png,svg'
        ]);

        if($request->file('image')->isValid())
        {
            $data = $request->except(['_token', 'image']);

            $image = $request->file('image');
            // for save original image
            $filename = pathinfo($image->getClientOriginalName() , PATHINFO_FILENAME)."_".time().".".pathinfo($image->getClientOriginalName() , PATHINFO_EXTENSION);
            $path = $request->file('image')->storeAs('public/auction', $filename);
            $data['image'] = $filename;
            $data['created_by'] = Auth::user()->id;

            $data['start_at'] = strtotime($request['start_at']);
            $data['end_at'] = strtotime($request['end_at']);

            Auction::create($data);

            $request->flash();
            return redirect(route('my-auctions.index'))->with('success', 'Auction added successfully');
        }
        return back()->with('error', 'Please select an image');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $auction = Auction::find($id);
        if($auction)
            return view('view-details', \compact('auction', 'user'));
        abort(404);
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

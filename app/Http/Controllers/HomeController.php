<?php

namespace App\Http\Controllers;

use App\Auction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $auctions = Auction::where('status', 1)->orderBy('id', 'desc')->get();
        return view('bidder-home', \compact('auctions'));
    }
}

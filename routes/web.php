<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'AuctionController@index')->name('home')->middleware('auth');

Route::get('my-auctions', 'AuctionController@my_auctions')->name('my-auctions.index');

Route::get('auctions/bids/{auction_id}', 'AuctionController@get_bids')->name('auctions.bids')->middleware('auth');

Route::resource('auctions', 'AuctionController')->middleware('auth');

Route::resource('bids', 'BidController')->middleware('auth');

<?php

namespace App\Console\Commands;

use App\Auction;
use App\Bid;
use Illuminate\Console\Command;

class CheckAuctions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:checkAuctions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks Auctions for expiry and start';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $time = time();

        echo "\n\nStarted Checking End Due Auctions.\n\n";
        $end_auctions = Auction::where('status', 'live')->where('end_at', '<', $time)->get();

        foreach($end_auctions as $auction)
        {
            $winning_bid = Bid::where('auction_id', $auction->id)->orderBy('amount', 'desc')->first();
            if($winning_bid)
            {
                $auction->update([
                    'status' => 'finished',
                    'won_by' => $winning_bid->bid_by,
                    'winning_bid' => $winning_bid->id
                ]);
            }
            else
            {
                $auction->update(
                    [
                    'status' => 'finished'
                    ]
                );
            }
            echo "\n\n".$auction->id." finished.\n\n";
        }

        echo "\n\nStarted Checking Due Auctions.\n\n";
        $start_auctions = Auction::where('status', 'scheduled')->where('start_at', '<', $time)->get();

        foreach($start_auctions as $auction)
        {
            $auction->update([
                'status' => 'live'
            ]);
            echo "\n\n".$auction->id." made live.\n\n";
        }

    }
}

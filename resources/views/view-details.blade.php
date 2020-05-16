@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
<div class="container">
    <div class="row justify-content-center">

        <div class="col-12">
            <div class="property-title m-b-50">
                <div class="property-top">
                    <div class="row">
                        @if($auction->status == 'finished')
                            <div class="col-12 mb-3 text-center">
                                <div class="card p-4">
                                <h3>Won By:
                                    <span class="badge badge-pill bg-success text-white">{{$auction->winner ? $auction->winner->name: 'N/A'}}</span>
                                    Winning Bid:
                                    <span class="badge badge-pill bg-success text-white">{{$auction->winner_bid ? '₹ '.$auction->winner_bid->amount: 'N/A'}}</span>
                                </h3>
                                </div>
                            </div>
                        @endif
                        @if($auction->created_by == $user->id)
                        <div class="col-12 mb-3">
                            <div class="item-name">
                                <h3>Live Bidding <small>(updates every 3 seconds)</small></h3>
                            </div>
                            <table id='bid-table' class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Bid Id</th>
                                        <th>Bidder</th>
                                        <th>Bid Amount</th>
                                        <th>Dated</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        @endif
                        <div class="col-lg-8 col-md-12 mb-3 p-3">
                            <div class="item-name">
                                <h3>Auction Title: {{$auction->name}}</h3>
                            </div>
                            <div class="property-area text-uppercase">
                                <i aria-hidden="true" class="fa fa-th-large"></i>
                                Reference ID :
                                <a href="#">#AUC1100{{$auction->id}}</a>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-7 order-lg-0">
                            <img height="400px" width="100%" src="{{url('storage/auction', $auction->image)}}"
                                alt="Image">
                        </div>
                        <div class="col-md-12 col-lg-5 order-lg-0">
                            <div class="s-box">
                                <div class="s-box-header">
                                    <span> Auction Details </span>
                                </div>
                                <div class="popular-cat">
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>
                                                Auction Status :
                                            </span>
                                            @if($auction->status == 'scheduled')
                                                <span class="badge badge-pill bg-warning text-muted">{{strtoupper($auction->status)}}</span>
                                            @elseif($auction->status == 'live')
                                                <span class="badge badge-pill bg-success text-white">{{strtoupper($auction->status)}}</span>
                                            @else
                                                <span class="badge badge-pill bg-danger text-white">{{strtoupper($auction->status)}}</span>
                                            @endif
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>
                                                Created By
                                            </span>
                                            <span class="badge">{{$auction->auctioneer->name}}</span>
                                        </li>
                                    </ul>
                                    <ul class="list-group mt-3">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>
                                                Total Bids :
                                            </span> <span
                                                class="badge badge-primary badge-pill">{{$auction->bids->count()}}</span>
                                        </li>
                                    </ul>
                                    <ul class="list-group mt-3">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>
                                                Start Date :
                                            </span> <span
                                                class="badge badge-pill">{{date('d-m-Y h:i a', $auction->start_at)}}</span>
                                        </li>
                                    </ul>
                                    <ul class="list-group mt-3">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>
                                                End Date :
                                            </span> <span
                                                class="badge badge-pill">{{date('d-m-Y h:i a', $auction->end_at)}}</span>
                                        </li>
                                    </ul>
                                    <ul class="list-group mt-3">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>
                                                Your Last Bid :
                                            </span>                                            
                                            @if($last_bid)
                                            <span class="badge border color-666 badge-pill">
                                                <span class="mr-1 font-weight-normal">₹</span>
                                                {{$last_bid->amount}}
                                            </span>
                                            @else
                                            <span class="badge badge-warning text-muted border color-666 badge-pill">
                                                No bid placed yet
                                            </span>
                                            @endif
                                        </li>
                                        @if($auction->created_by != $user->id)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>
                                                Current Rank :
                                            </span>
                                            @if($current_rank)
                                            <span class="badge border color-666 badge-pill">
                                                {{$current_rank}}
                                            </span>
                                            @else
                                            <span class="badge badge-warning text-muted border color-666 badge-pill">
                                                No bid placed yet
                                            </span>
                                            @endif
                                        </li>
                                        @endif
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>
                                                Current Winning Bid :
                                            </span>
                                            <span class="badge badge-success border color-666 badge-pill">
                                                @if(count($auction->bids) > 0)
                                                <span class="mr-1 font-weight-normal">₹</span>
                                                    {{ $auction->bids->max('amount')}}
                                                @else
                                                N/A
                                                @endif
                                            </span>
                                        </li>
                                    </ul>
                                    <ul class="list-group mt-3">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="font-weight-bold color-666">
                                                Minimum Bid Amount :
                                            </span> <span class="badge bg-primary text-white badge-pill"><span
                                                    class="mr-1 font-weight-normal">₹</span>{{$auction->starting_bid}}</span>
                                        </li>
                                    </ul>
                                </div>
                                @if($auction->status == 'live' && $auction->created_by != $user->id)
                                <div class="list-group mt-3">
                                    <div class="list-group-item py-4">
                                        <form id='bid-form' method="POST" action="">
                                            @csrf
                                            <div class="form-group">
                                                <input class="form-control" name="auction_id" value="{{$auction->id}}"
                                                    type="hidden">
                                                <input class="form-control" name="bid_by" value="{{$user->id}}"
                                                    type="hidden">
                                                <input placeholder="Enter your bid amount here" class="form-control"
                                                    name="amount" type="number">
                                            </div>
                                            <button value="Submit" type="submit" id="place-bid"
                                                class="btn btn-success w-100 float-right has-spinner">Bid Your
                                                Amount</button>
                                        </form>
                                    </div>
                                </div>
                                @elseif($auction->created_by == $user->id)
                                <div class="list-group mt-3">
                                    <div class="list-group-item py-4">
                                        <button class="btn btn-danger w-100 float-right has-spinner">Cannot place a bid
                                            on your own auction</button>
                                    </div>
                                </div>
                                @else
                                <div class="list-group mt-3">
                                    <div class="list-group-item py-4">
                                        <button class="btn btn-danger w-100 float-right has-spinner">Cannot place a bid
                                            right now</button>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="single-blog m-t-50">
                                <div class="custom-profile-nav">
                                    <nav>
                                        <div id="nav-tab" role="tablist" class="nav nav-tabs">
                                            <a id="description"
                                                data-toggle="tab" href="#descrip" role="tab" aria-controls="descrip"
                                                aria-selected="true" class="nav-item nav-link active show">
                                                Description</a>
                                            </div>
                                    </nav>
                                    <div id="nav-tabContent" class="tab-content">
                                        <div id="descrip" role="tabpanel" aria-labelledby="description"
                                            class="tab-pane fade active show">
                                            <div class="m-t-50 m-4">
                                                <p class="single-blog-details text-justify">
                                                    {{$auction->description}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/datatables.min.js') }}" type="text/javascript"></script>
<script>



    $(document).ready(function(){
        var submitButton = $('#place-bid');
        submitButton.on('click', function (e) {
                e.preventDefault();
                var formData = $('#bid-form').serialize();
                $.ajax({
                    url: "{{route('bids.store')}}",
                    method: "POST",
                    data: formData,
                    success: function (response) {
                        if(response.status == "SUCCESS"){
                            alert('Bid Placed Successfully')
                            window.location.reload();
                        }
                        else
                        {
                            alert(response.error)
                            console.log(response);
                        }
                    }});
            }
        );


    });


    @if($auction->created_by == $user->id)
    $(function () {
        var bidTable = $('#bid-table').DataTable({
            ajax: {
                url: "{{route('auctions.bids', $auction->id)}}",
                error: function (response) { }
            },
            searching: false,
            //processing: true,
            serverSide: true,
            fixedHeader: true,
            columnDefs: [{
                sortable: false,
                targets: [0, 1]
            }],
        });

        setInterval( function () {
        bidTable.ajax.reload();
    }, 3000);

    });
    @endif

</script>

@endsection

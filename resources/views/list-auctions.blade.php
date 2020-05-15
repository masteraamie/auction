@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h3>Available Auctions</h3>

            @if(count($auctions)> 0)
            <div class="row">
                @foreach ($auctions as $item)
                <div class="col-lg-4 col-md-6 my-3">
                    <div class="card">
                        <div class="card-image-area position-relative">
                            <figure>
                                <a href="{{route('auctions.show', $item->id)}}">
                                    <img height="300px" src="{{url('storage/auction', $item->image)}}" alt="preview"
                                        class="card-img-top"></a>
                            </figure>
                        </div>
                        <div class="card-body">

                            <ul class="list-group">
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        Auction Name :
                                    </span>
                                    <span class="badge border">
                                        {{$item->name}}
                                    </span>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        Auction Status :
                                    </span>
                                    @if($item->status)
                                        <span class="badge badge-pill bg-success text-white">Active</span>
                                    @else
                                        <span class="badge badge-pill bg-danger text-white">Inactive</span>
                                    @endif
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        Created By
                                    </span>
                                    <span class="badge">{{$item->auctioneer->name}}</span>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center">

                                            <span class="font-weight-bold color-666">
                                                Minimum Bid Amount :
                                            </span> <span class="badge bg-primary text-white badge-pill"><span
                                                    class="mr-1 font-weight-normal">₹</span>{{$item->starting_bid}}</span></li>
                                </li>
                            </ul>
                            <a href="{{route('auctions.show', $item->id)}}" class="btn btn-primary form-control mt-1">View Details</a>

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            No Auctions Active Yet
            @endif

        </div>
    </div>
</div>
@endsection

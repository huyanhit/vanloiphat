@extends('layouts.home')
@section('content')
<div class="container">
    <!-- service -->
    <div class="row news-detail">
            <div class="col-md-5 col-sm-12 col-xs-12">
                <div class="service-image">
                    <div id="p-carousel" class="owl-carousel owl-theme">
                        <div class="item ">
                            <img src="{{route('get-image', $news->image_id)}}" class="img-responsive" alt="{{$news->title}}" />
                        </div>
                    </div>
                </div>
                <script>
                    // Can also be used with $(document).ready()
                    $(window).load(function() {
                        $('#p-carousel').owlCarousel({
                            loop:true,
                            margin:10,
                            responsive:{
                                1000:{
                                    items:1
                                },
                            }
                        })
                    });
                </script>
            </div>

            <div class="col-md-7 col-sm-12 col-xs-12">
                <h2 class="name">
                    {{ $news->title }}
                </h2>
                <div class="description"> {!! $news->description !!} </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12 pro-content">
                <h3 class="p-title"> <span> Chi tiết </span></h3>
                <div class="content">
                    {!! $news->content !!}
                </div>
            </div>
        </div>
    </div>
    <!-- end service -->
</div>

@endsection


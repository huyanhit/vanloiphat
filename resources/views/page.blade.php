@extends('layouts.home')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                @if(!empty($pages))
                    <div class="content-page">
                        <div class="description"> {!! $pages->description !!}</div>
                        <div class="content"> {!! $pages->content !!}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection


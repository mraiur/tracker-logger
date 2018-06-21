@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="duration-records">
                        @foreach( $records as $day => $blocks )
                            <div class="log-date-row">
                                <div class="col-md-3 log-date">
                                    <b>{{$day}}</b>
                                </div>
                                <div class="col-md-9 time">
                                    @foreach( $blocks as $block)
                                        <div class="time-duration" style="left: {{$minuteSize * $block['start']}}%; width: {{$minuteSize * $block['duration']}}% " ></div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

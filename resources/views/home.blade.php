@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Log</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="duration-records">
                        <div class="log-date-headers">
                            <div class="col-md-3 log-date-header">Date</div>
                            <div class="col-md-9 time-header">
                                <div class="time-duration-header">00:00</div>
                                <div class="time-duration-header" style="left: {{$minuteSize * 120}}%;">02:00</div>
                                <div class="time-duration-header" style="left: {{$minuteSize * 240}}%;">04:00</div>
                                <div class="time-duration-header" style="left: {{$minuteSize * 360}}%;">06:00</div>
                                <div class="time-duration-header" style="left: {{$minuteSize * 480}}%;">08:00</div>
                                <div class="time-duration-header" style="left: {{$minuteSize * 600}}%;">10:00</div>
                                <div class="time-duration-header" style="left: {{$minuteSize * 720}}%;">12:00</div>
                                <div class="time-duration-header" style="left: {{$minuteSize * 840}}%;">14:00</div>
                                <div class="time-duration-header" style="left: {{$minuteSize * 960}}%;">16:00</div>
                                <div class="time-duration-header" style="left: {{$minuteSize * 1080}}%;">18:00</div>
                                <div class="time-duration-header" style="left: {{$minuteSize * 1200}}%;">20:00</div>
                                <div class="time-duration-header" style="left: {{$minuteSize * 1320}}%;">22:00</div>
                            </div>
                        </div>
                        @foreach( $records as $day => $blocks )
                            <div class="log-date-row">
                                <div class="col-md-3 log-date">
                                    <b>{{$day}}</b>
                                </div>
                                <div class="col-md-9 time">
                                    @foreach( $blocks as $block)
                                        <div class="time-duration" style="left: {{$minuteSize * $block['start']}}%; width: {{$minuteSize * $block['duration']}}%; background-color: {{$block['color']}} " ></div>
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

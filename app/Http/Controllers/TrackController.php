<?php

namespace App\Http\Controllers;


use App\Enums\StatusCodes;
use App\EventTypeModel;
use App\Http\Requests\TrackRequest;
use App\TrackLogModel;
use Illuminate\Support\Facades\Auth;

class TrackController extends Controller
{
    public function __construct()
    {
        $this->middleware('client' );
    }

    public function save(TrackRequest $request, $event_id)
    {
        $event = EventTypeModel::find($event_id);
        if( $event )
        {
            $track = new TrackLogModel([
                'user_id' => Auth::id(),
                'event_type_id' => $event->id
            ]);
            $track->save();

            $endEvents = EventTypeModel::getEndEvents($event->id);
            foreach( $endEvents as $endEvent )
            {
                $startTracks = TrackLogModel::where('user_id', '=', Auth::id() )->where('event_type_id', '=', $endEvent->id)->get();
                foreach( $startTracks as $startTrack)
                {
                    if( $startTrack->duration === 0)
                    {
                        $startTrack->duration = $track->created_at->diffInMinutes($startTrack->created_at);
                        $startTrack->save();
                    }
                }
            }

            return response()->json(["code" => StatusCodes::SUCCESS_EVENT_SAVED ]);
        }
        return response()->json(['error'=>"missing event", "code" => StatusCodes::ERROR_EVENT_MISSING ]);
    }
}

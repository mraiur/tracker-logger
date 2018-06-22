<?php

namespace App\Http\Controllers;

use App\EventTypeModel;
use App\Http\Requests\ViewHistoryRequest;
use App\TrackLogModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @return \Illuminate\Http\Response
     */
    public function index( ViewHistoryRequest $request)
    {
        $start_date = \DateTime::createFromFormat('Y-m-d', $request->get('start_date') );
        $end_date = \DateTime::createFromFormat('Y-m-d', $request->get('end_date') );
        $records = [];

        if(!$start_date)
        {
            $start_date = new \DateTime();
            $start_date->sub( new \DateInterval('P7D') );
        }

        if(!$end_date)
        {
            $temp = clone $start_date;
            $end_date = new \DateTime(  $temp->format('Y-m-d')." 23:59:00");
            $end_date->add(new \DateInterval('P7D'));
        }

		$startEvents = EventTypeModel::where('user_id', Auth::id() )->whereNotNull("end_event_type_id")->get();
        foreach( $startEvents as $startEvent)
        {
            $startEvent->load('endEvent');
            $records = array_merge_recursive($records, TrackLogModel::getGroupedByDay($start_date, $end_date, $startEvent) );
        }

        return view('home', [
            'minuteSize' => 0.069444444, // 100 / (24*60)
            'records' => $records
        ]);
    }
}

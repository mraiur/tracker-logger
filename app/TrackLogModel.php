<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TrackLogModel extends Model
{
    protected $table = "track_log";

    protected $fillable = [
        'user_id',
        'event_type_id',
        'duration'
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function eventType(){
        return $this->hasOne( EventTypeModel::class, 'id', 'event_type_id');
    }

    public static function getGroupedByDay($start_date, $end_date, $eventType )
    {
        $records = self::where('created_at', ">", $start_date)
            ->where('created_at', "<", $end_date)
            ->where('user_id', Auth::id() )
            ->where('event_type_id', $eventType->id )
            ->get();

        $byDays = [];
        foreach($records as $item)
        {
            $duration = $item->duration;
            $created_at = $item->created_at;
            $break = 0;
            while($duration > 0 || $break < 5 )
            {
                $day = $created_at->format('Y-m-d');
                $endOfDay = Carbon::createFromTimestamp($created_at->timestamp);
                $endOfDay->hour = 23;
                $endOfDay->minute = 59;

                //echo "before duration: $duration<br />";

                if(!isset($byDays[$day]) )
                {
                    $byDays[$day] = [];
                }

                $diffEndOfDay = $created_at->diffInMinutes($endOfDay);
                if( $diffEndOfDay < $duration )
                {
                    $byDays[$day][] = [
                        "start" => ( $created_at->hour * 60) + $created_at->minute,
                        "duration" => $diffEndOfDay
                    ];
                    $created_at->hour = 00;
                    $created_at->minute = 01;
                    $created_at->addDay();

                    $duration -= $diffEndOfDay;
                }
                else
                {
                    $byDays[$day][] = [
                        "start" => ( $created_at->hour * 60) + $created_at->minute,
                        "duration" => $duration
                    ];
                    $duration = 0;
                }
                //echo "duration: $duration<br />";
                //dbg($created_at, $endOfDay, $duration, $created_at->diffInMinutes($endOfDay));
                $break++;
            }
            //dbg();

        }
        return $byDays;
    }
}

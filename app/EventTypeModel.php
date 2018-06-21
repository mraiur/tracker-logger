<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventTypeModel extends Model
{
    protected $table = "event_types";

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function logs()
    {
        return $this->hasMany( TrackLogModel::class, 'event_id', 'id');
    }

    public function endEvent()
    {
        return $this->hasOne(EventTypeModel::class, 'id', 'end_event_type_id');
    }

    public static function getEndEvents($id)
    {
        return self::where('end_event_type_id', '=', $id)->get();
    }
}

<?php
namespace App\Helpers;

use Request;
use App\ActivityUser as LogActivityModel;

class UserActivity{
    public static function AddToLog($subject){
        $log = [];
        $log['user_id'] = auth()->user()->id;
        $log['activity'] = $subject;
        $log['created_at'] = $subject;
        LogActivityModel::created($log);
    }

    public static function logActivityLists(){
        return LogActivityModel::latest()->get();
    }
}





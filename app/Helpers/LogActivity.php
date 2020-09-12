<?php
namespace App\Helpers;

use Request;
use App\Activity as LogActivityModel;

class LogActivity{
    public static function AddToLog($subject){
        $log = [];
        $log['title'] = $subject;
        $log['user_id'] = auth()->user()->id;
        $log['name'] = auth()->user()->name;
        $log['file_id'] = $subject()->id;
        $log['activity'] = $subject();
        $log['created_at'] = $subject;
        LogActivityModel::created($log);
    }

    public static function logActivityLists(){
        return LogActivityModel::latest()->get();
    }
}





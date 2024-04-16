<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\UpdateRequest;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class UpdateTotalTimeController extends Controller
{

    public function __invoke($taskId){
         $task=Task::find($taskId);
         $timeStart = new Carbon($task['start']);
         $timeStop = new Carbon();
         $total = round($task['totalTimer'] + $timeStart->diffInMinutes($timeStop));
         $task->update(['start'=> null,'totalTimer' => $total]) ;

         return $task;
    }


}

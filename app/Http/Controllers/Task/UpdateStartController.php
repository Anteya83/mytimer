<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\UpdateRequest;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class UpdateStartController extends Controller
{

    public function __invoke($taskId){
         $task=Task::find($taskId);
         $task->update(['start'=> new Carbon()]);
         return $task;

    }

}

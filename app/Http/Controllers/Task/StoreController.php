<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreRequest;
use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request, int $id){
        $data = $request->validated();

        $task = Project::active()->findOrFail($id)->tasks()
            ->save(new Task([
                'name'=> $data['name'],
                'user_id' => Auth::user()->id,
                'start'=>null
                ]));

        return $task->with('project')->find($task->id);
    }

}

<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreRequest;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{

    public function __invoke(StoreRequest $request){
         $data = $request->validated();
         $data=array_merge($data, ['created_by' => auth()->user()->id]);
         $project = Project::create($data)->toArray;
         return $project ? array_merge($project,['tasks'=>[]]) : false;
    }

}

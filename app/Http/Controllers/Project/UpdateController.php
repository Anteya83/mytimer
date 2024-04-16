<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\UpdateRequest;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class UpdateController extends Controller
{

    public function __invoke(UpdateRequest $request, Project $project){
         $data = $request->validated();
         $project->update($data);
         return $project;

    }

}

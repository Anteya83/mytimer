<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
class IndexController extends Controller
{

    public function __invoke(){
       // $this->middleware('auth');
        return Project::active()->with('tasks')->get();

    }


}

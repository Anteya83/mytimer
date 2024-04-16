<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'project_id',
        'start',
        'totalTimer'
    ];
    protected $guarded=[];
    protected $dates = ['start','totalTimer'];
    protected $with=['user'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function project(){
        return $this->belongsTo(Project::class);
    }
    public function scopeActive($query){
        return $query->whereUserId(auth()->user()->id);
    }


}

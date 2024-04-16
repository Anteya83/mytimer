<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'created_by'
    ];
    protected $guarded=[];
    protected $with = ['user'];

    public function user(){
        return $this->belongsTo(User::class);//проект относится к одному юзеру
    }

    public function tasks(){
        return $this->hasMany(Task::class);//задачи относятся к одному проекту
    }
    public function scopeActive($query){
        return $query->where('created_by',(auth()->user()->id));//ограничиваем проекты только теми которые относятся к одному юзеру

    }
}

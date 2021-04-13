<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Langauge extends Model
{
    protected $table= 'languages'; //table name

    protected $fillable = [
        'abbr', 'locale','name','direction','active','created_at','updated_at',
    ];

    public function scopeActive($query){
        return $query->where('active','1');
    }

    public function scopeselection($query){
        return $query->select('id','abbr','name','direction','active');
    }

    // public function getActiveAttribute($val){
    //    return $val == 1 ? 'مفعل' : 'غير مفعل';
    // }

    public function getActive(){
       return $this->active == 1 ? 'مفعل' : 'غير مفعل';
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\MainCategoryObserve;

class MainCategory extends Model
{
    protected $table= 'main_categories'; //table name

    protected $fillable = [
        'translation_lang', 'translation_of','name','slug','photo','active','created_at','updated_at',
    ];
    
    protected static function boot()
    {
        parent::boot();
        MainCategory::observe(MainCategoryObserve::class);
    }

    public function scopeActive($query){
        return $query->where('active','1');
    }

    public function scopeSelection($query){
        return $query->select('id','translation_lang','translation_of','name','slug','photo','active');
    }

    // public function getPhotoAtrribute($val){
    //     return ($val != null) ? asset('/storage/'.$val) : "";
    // }

    public function getActive(){
          return $this -> active == 1 ? "مفعل": "غير مفعل" ;
    }

    public function categories(){
      return  $this -> hasMany(self::class,'translation_of');
    }

    public function vendors()
    {
        return $this->hasMany('App\Models\Vendor','category_id','id');
    }
}

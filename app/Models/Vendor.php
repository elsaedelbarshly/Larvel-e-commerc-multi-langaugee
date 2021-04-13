<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Vendor extends Model
{

    use Notifiable;

    protected $table='vendors';

    protected $fillable=[
        'name','logo','mobile','address','email','category_id','active','created_at','updated_at','password'
    ];

    // protected static function boot()
    // {
    //     parent::boot();
    //     Vendor::observe(VendorObserve::class);
    // }

    protected $hidden=['category_id','password'];

    public function scopeActive($query)
    {
        return $query->where('active,1');
    }

    public function getLogAttribute($val)
    {
        return ($val !== null ) ? asset('asset/'.$val) : "";
    }

    public function scopeSelection($query)
    {
        return $query ->select('id','categoru_id','active','name','address','email','logo','mobile');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\MainCategory','category_id','id');
    }

    public function getActive()
    {
        return $this->Active==1?'مفعل':'غير مفعل';
    }

    public function setPasswordAttribute($password){
        if(!empty($password)){
            $this->attribute['password']->bcrypt($password);
        }
    }

}

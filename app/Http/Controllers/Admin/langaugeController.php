<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\langaugeRequest;
use App\Models\Langauge;
use Illuminate\Http\Request;

class langaugeController extends Controller
{
    public function index(){
        $langauges = Langauge::select()->paginate(10);
        return view('admin.langauges.index',compact('langauges')); 
    }

    public function create(){
        return view('admin.langauges.create');
    }
    public function store(langaugeRequest $request){

        try{
            
             Langauge::create($request->except(['_token']));
            return redirect()->route('admin.langauges')->with(['success'=>'تم الحفظ بنجاح']);
        }catch(Exception $ex){
         return redirect()->route('admin.langauges')->with(['error'=>'هناك خطاء ما يرجى المحاوله في وقت لاحقا']);
        }
       
    }
    public function edit($id){

         $langauge = Langauge::select()->find($id);
        if(!$langauge){
             return redirect()->route('admin.langauges')->with(['error'=>'هذه اللغة غير موجوده']);
         }   
        return view('admin.langauges.edit',compact('langauge'));
    }

    public function update($id,langaugeRequest $request){
        try{
            $langauge = Langauge::find($id);
            if(!$langauge){
                return redirect()->route('admin.langauges.edit',$id)->with(['error'=>'هذه اللغة غير موجوده']);
            }
            if(!$request->has('active')){
            $request ->request->add(['active'=>0]);
            }
            // $request->request()->add(['active'=>0]);
            $langauge->update($request->except(['_token']));
            return redirect()->route('admin.langauges')->with(['success'=>'تم تحديث اللغة بنجاح']);

        }catch(Exceptian $ex){
            return redirect()->route('admin.langauges')->with(['error'=>'هناك خطاء ما يرجى المحاوله في وقت لاحقا']);
        }
    }

    public function destroy($id){
        try{
            $langauge = Langauge::find($id);
            if(!$langauge){
                return redirect()->route('admin.langauge',$id)->with(['error'=>'هذه اللغة غير موجوده']);
            }
            $langauge->delete();
            return redirect()->route('admin.langauges')->with(['success'=>'تم الحذف اللغة بنجاح']);

        }catch(Exceptian $ex){
            return redirect()->route('admin.langauges')->with(['error'=>'هناك خطاء ما يرجى المحاوله في وقت لاحقا']);
        }
    }
}

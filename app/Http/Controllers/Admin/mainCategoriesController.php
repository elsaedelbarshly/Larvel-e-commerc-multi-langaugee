<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Models\MainCategory;
use Illuminate\Http\Request;
// use App\config\filesystems\maincategor;
use Illuminate\Support\Facades\Config;
use DB;

class mainCategoriesController extends Controller
{
    public function index(){
        $default_lang=get_defaulte_lang();
        $categories=MainCategory::where('translation_lang', $default_lang)->selection()->get();
        return view('admin.maincategories.index',compact('categories'));
    }
    public function create(){
        return view('admin.maincategories.create');
    }
    
    public function store(MainCategoryRequest $request){
        // return $request;

        try{

        $main_category = collect($request->category);
        $filter = $main_category -> filter(function($value,$key){

            return $value['abbr'] == get_defaulte_lang();
        });

        $defalut_category = array_values($filter->all()) [0];

        // $filepath='';
        // if($request->hasFile('photo')){
        //     $filepath = uploadImage('public', $request->photo);
        // }

        $filepath = "";
        if($request->hasFile('photo'));
        {
            $destnation_path ='public/maincategories';
            $image = $request->file('photo');
            $image_new_name = $image->getClientOriginalName();
            $filepath = $request->file('photo')->storeAs($destnation_path,$image_new_name);
        }
        // $main_category->photo = request()->photo->store('maincategories','public');
        
        DB::beginTransaction();

            $defalut_category_id = MainCategory::insertGetId([
            'translation_lang' => $defalut_category['abbr'],
            'translation_of' => 0,
            'name' =>$defalut_category['name'],
            'slug' =>$defalut_category['name'],
            'photo' =>$filepath
        ]);

        $categories = $main_category -> filter(function($value,$key){

            return $value['abbr'] != get_defaulte_lang();
        });

        if(isset($categories) && $categories->count())
        {
            $categories_array=[];
            foreach($categories as $category){
                $categories_array[]=[
                'translation_lang' => $category['abbr'],
                'translation_of' => $defalut_category_id,
                'name' =>$category['name'],
                'slug' =>$category['name'],
                'photo' =>$filepath
                ];
            }

           MainCategory::insert($categories_array);
        }

        DB::commit();
        
        return redirect()->route('admin.maincategories')->with(['success'=>'تم الحفظ بنجاح']);

        }catch(Exception $ex){
            DB::rollback();
            return redirect()->route('admin.maincategories')->with(['error'=>'خطا يرجا المحاوله مره اخرى']);
        }
    }

    public function edit($mainCat_id){

        $maincategory=MainCategory::with('categories')->selection()->find($mainCat_id);
        if(! $maincategory){
            return redirect()->route('admin.maincategories')->with(['error'=>'هذا الحقل غير موجود']);
        }
            return view('admin.maincategories.edit',compact('maincategory'));
        

    }

    public function update($mainCat_id,MainCategoryRequest $request){
         
        try {
       $main_category = MainCategory::with('categories')->selection()->find($mainCat_id);
       if(!$main_category){
           return redirect()->route('admin.maincategories')->with(['error'=>'هذا الحقل غير مطلوب']);
       }
       $category = array_values($request -> category)[0];

       if(!$request->has('category.0.active'))
        $request ->request->add(['active'=>0]);
        else{
            $request->request->add(['active'=>1]);
        }

        MainCategory::where(id,$mainCat_id)->update([
            'name'=>$category['name'],
            'active' => $request->active,
           
     
        ]);
            //save image
        //$filepath = $main_category->photo;
     
        if($request->hasFile('photo'));
         {
             $destnation_path ='public/maincategories';
             $image = $request->file('photo');
             $image_new_name = $image->getClientOriginalName();
             $filepath = $request->file('photo')->storeAs($destnation_path,$image_new_name);
         }  
       
         MainCategory::where(id,$mainCat_id)->update([
            
            'photo' => $filepath,
     
        ]);

       return redirect()->route('admin.maincategories')->with(['success'=>'تم التحديث بنجاح']);
       

    } catch (\Eexception $ex) {
        return redirect()->route('admin.maincategories')->with(['error'=>'حدث خطاء ما  ']);
    }

    }

  public function destroy($id)
  {
      try{
      $maincategory = MainCategory::selection()->find($id);
      if(!$maincategory)
      {
          return redirect()->route('admin.maincategories')->with(['erorr'=>'هذا القسم غير موجود']);
      }
    
      $vendors = $maincategory->vendors();
      if(isset($vendors) && $vendors->count()>0)
      {
        return redirect()->route('admin.maincategories')->with(['erorr'=>'لا يمكن حذف هذا القسم']);
      }

      $maincategory->categories()->delete();

      $maincategory -> delete();
      return redirect()->route('admin.maincategories')->with(['success'=>'تم الحذف بنجاح']);
      }catch(Exception $exception)
      {
        return redirect()->route('admin.maincategories')->with(['error'=>'حدث خطاء ما  ']);
      }
  }

  public function changestatus($id)
  {
      try
      {
        $maincategory = MainCategory::selection()->find($id);
        if(!$maincategory)
        {
            return redirect()->route('admin.maincategories')->with(['erorr'=>'هذا القسم غير موجود']);
        }

        $status=$maincategory->active==0?1:0;
        $maincategory->update(['active'=>$status]);

        return redirect()->route('admin.maincategories')->with(['success'=>'تم تفعيل القسم بنجاح']);
        
      }catch(Exception $exception)
      {
        return redirect()->route('admin.maincategories')->with(['error'=>'حدث خطاء ما  ']);  
      }
  }
}
    



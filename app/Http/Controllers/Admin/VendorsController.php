<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VendorRequest;
use App\Models\Vendor;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use Illumainate\Support\Facades\Notification;
use App\Notifiaction\VendorCreated;
use DB;

class VendorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors=Vendor::Selection()->paginate('3');
        return view('admin.vendors.index',compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=MainCategory::Active()->get();
        return view('admin.vendors.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorRequest $request)
    {
        try{

            if($request->has('active'))
            {
                $request->request->add(['active'=>0]);
            }
            else
            {
                $request->request->add(['active'=>1]);
            }

            $filePath="";
            if($request->has('logo'))
            {
                $filePath = uploadImage('vendors',$request->logo);
            }

          $vendor = Vendor::create([
               'name'=>$request->name,
               'mobile'=>$request->mobile,
               'email'=>$request->email,
               'active'=>$request->active,
               'address'=>$request->address,
               'loge'=>$filePath,
               'category_id'=>$request->category_id,
               'password'=>$request->password
           ]);

           //Notification::send($toUser,new NewMessage($fromUs));

           Notification::send($vendor,new VendorCreated($vendor));

            return redirect()->route('admin.Vendors')->with(['success'=>'تم الحفظ بنجاح']);

        }catch(Exceptian $ex){
            return $ex;
            return redirect()->route('admin.Vendors')->with(['error'=>'خطا فى البيانات']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try
        {
            $vendor = Vendor::Selection()->find($id);
            if(!$vendor){
                return \redirect()->route('admin.Vendors')->with(['erorr'=>'هذه الصفحه غير موجوده']);
            }
            $categories=MainCategory::where('translation_of',0)->Active()->get();
            
            return \view('admin.vendors.edit',compact('vendor','categories'));

            return \redirect()->route('admin.Vendors')->with(['success'=>'تم الحفظ بنجاح']);
        }catch(Exception $exception)
        {
            return redirect()->route('admin.Vendors')->with(['erorr'=>'خطا في البيانات']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VendorRequest $request, $id)
    {
        try
        {

            DB::beginTransaction();

            $vendor=Vendor::selection()->find($id);
            if(!$vendor)
            {
                return \redirect()->route('admin.Vendors')->with(['erorr'=>'هذا العنصر غير موجود']);
            }

             if($request->has('logo'))
             {
                 $filePath=uploadImage('vendores',$request->loge);
                 Vendore::where('id',$id)->update([
                     'logo'=>$filePath,
                 ]);
                
             }

             $data=$request->except('_token','id','logo','password');
             if($request->has('password'))
             {
                 $date['password']=$request->password;
             }

             Vendor::where('id',$id)->update($data);

             DB::commit();

             return \redirect()->route('admin.Vendors')->with(['success'=>'تم الامر بنجاح']); 
        }catch(Exception $exception)
        {
            DB::rollback();
            return redirect()->route('admin.Vendors')->with(['erorr'=>'خطا في البيانات']); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $vendor=Vendor::selection()->find($id);
            if(!$vendor)
            {
                return \redirect()->route('admin.Vendors')->with(['erorr'=>'هذا العنصر غير موجود']);
            }

            $vendor->delete();

            return \redirect()->route('admin.Vendors')->with(['success'=>'تم الامر بنجاح']);
        }catch(Exceotion $exception)
        {
            return redirect()->route('admin.Vendors')->with(['erorr'=>'خطا في البيانات']); 
        }
    }

    public function change_status($id)
    {
        try{
        $vendor=Vendor::selection()->find($id);
        if(!$vendor)
        {
            return \redirect()->route('admin.Vendors')->with(['erorr'=>'هذا القسم غير موجود']) ;
        }

        $status=$vendor->active==0?1:0;
        $vendor->update(['active'=>$status]);

            return \redirect()->route('admin.Vendors')->with(['success'=>'تم الامر بنجاح']);
        }catch(Exception $exception){
            return \redirect()->route('admin.Vendors')->with(['erorr'=>'خطا يرجى المجاوله في وقت لاحق']);
        }
    }
}

<?php
use Illuminate\Support\Facades\Config;

function get_language(){
  return \App\Models\Langauge::active()->selection()->get();
}

function get_defaulte_lang(){
    return Config::get('app.locale');
}

function uploadImage($folder,$image){

    $image->store('/',$folder);
    $filename = $image->hasName();
    $path = 'images/' . $folder . '/' . $filename;
    return $path;
}

// function uploadImage($folder,$image){

// }


// $destnation_path ='public/maincategories';
// $image = $request->file('photo');
// $image_new_name = $image->getClientOriginalName();
// $filepath = $request->file('photo')->storeAs($destnation_path,$image_new_name);
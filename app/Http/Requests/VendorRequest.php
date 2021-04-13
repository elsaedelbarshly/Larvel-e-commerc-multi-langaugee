<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|string|max:100',
            'logo'=>'required_without:id|mimes:png,jpg,jpeg',
            'mobile'=>'required|max:100|unique:vendors,mobile,'.$this->id,
            'email'=>'email|unique:vendors,email,'.$this->id,
            'category_id'=>'required|exists:main_categories,id',
            'address'=>'required|string|max:500',
            'password'=>'required_without:id'
        ];
    }

    public function message()
    {
        return [
            'required'=>'هذا الحقل مطلوب',
            'max'=>'هذا الحقل طويل',
            'category_id.exists'=>'هذا القسم غير موجود',
            'email.email'=>'بريد إلكترونى خاطئ',
            'name.string'=>'اسم غير صحيح',
            'address.string'=>'عنوان غير صحيح',
            'logo.required_without'=>'اختر صوره',
            'mobile.unique'=>'الهاتف غير متاح',
            'email.unique'=>'هذا البريد غير متاح'
        ];
    }
}

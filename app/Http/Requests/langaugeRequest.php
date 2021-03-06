<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class langaugeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
            'abbr'=>'required|string|max:10',
            // 'active'=>'required|in:0,1',
            'direction'=>'required|in:rtl,ltr',
        ];
    }

    public function messages(){
        return[
            'required'=>'هذه الحقل مطلوب',
            'in'=>'القيم المدخلة غير صحيحة',
            'name.string'=>'اسم اللغة لابد أن يكون أحرف',
            'name.max'=>'اسم اللغه لا يزيد عن 100 حرف',
            'abbr.max'=>'يجب الا يزيد عن 10 احرف',
            'abbr.string'=>'يجب الا يزيد عن 10 احرف',
            
           
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\News;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTestsRequest extends FormRequest
{
   /* public function authorize()
    {
        return \Gate::allows('news_edit');
    }
*/
    public function rules()
    {
        return [
            'fio' => 'required',
            'day'    => 'required',
            'location' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'fio.required' => 'Ф.И.О. обязателен для заполнения',
            'day.required' => 'Дата проведения обязательна к заполнению',
            'location.required' => 'Локация обязательна к заполнения',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdataTask extends FormRequest
{

    protected $errorBag = 'update';
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
            'name' => 'required|max:255',
            'project_id' => [
                'required',
                'integer',
                Rule::exists('projects', 'id')->where(function($query) {
                    return $query->whereIn('id',  $this->user()->projects()->pluck('id'));
                })
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '任务内容必填',
            'name.max' => '任务名称长度最大255',
            'project_id.required' => '所属项目id必填',
            'project_id.integer' => '所属项目必须是正整数',
            'project_id.exists' => '当前用户没有此项目'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->errorBag = 'update-' . $this->route('task');
        parent::failedValidation($validator);
    }
}

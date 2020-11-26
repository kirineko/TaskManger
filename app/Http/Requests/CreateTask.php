<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateTask extends FormRequest
{

    protected $errorBag = 'create';
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
            'project' => [
                'required',
                'integer',
                Rule::exists('projects', 'id')->whereIn('id', $this->user()->projects()->pluck('id')->toArray())
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '任务内容必填',
            'name.max' => '任务名称长度最大255',
            'project.required' => '所属项目id必填',
            'project.integer' => '所属项目必须是正整数',
            'project.exists' => '所属项目必须在project表中'
        ];
    }
}

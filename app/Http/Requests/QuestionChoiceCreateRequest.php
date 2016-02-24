<?php

namespace Gamify\Http\Requests;

use Gamify\Http\Requests\Request;

class QuestionChoiceCreateRequest extends Request
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
                'text'            => 'required',
                'correct'           => 'required|boolean',
                'points'            => 'required|integer'
        ];
    }
}
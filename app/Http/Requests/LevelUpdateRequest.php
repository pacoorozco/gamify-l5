<?php

namespace Gamify\Http\Requests;

use Illuminate\Validation\Rule;

class LevelUpdateRequest extends Request
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
        $level = $this->route('level');

        return [
            'name'            => ['required', 'string', Rule::unique('levels')->ignore($level->id)],
            'required_points' => ['required', 'integer', 'min:1', Rule::unique('levels')->ignore($level->id)],
            //'image'           => 'required|image',
            'active'          => ['required', 'boolean'],
        ];
    }
}

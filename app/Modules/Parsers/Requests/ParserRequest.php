<?php


namespace App\Modules\Parsers\Requests;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RegisterUserRequest
 * @package App\Http\Requests
 */
class ParserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'url' => 'required|url',
            'selector' => 'required',
            'search_link_selector' => 'required',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkingHoursRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            '*.weekday' => 'required|integer|min:0|max:6|distinct',
            '*.start_time' => 'required|date_format:H:i',
            '*.end_time' => 'required|date_format:H:i|after:start_time'
        ];
    }
}

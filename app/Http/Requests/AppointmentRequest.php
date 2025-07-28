<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Carbon\Carbon;

class AppointmentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'service_id' => ['required', 'integer', 'exists:services,id'],
            'service_provider_id' => ['required', 'integer', 'exists:users,id'],
            'client_email' => ['required', 'email'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => ['required', 'date_format:H:i'],
        ];
    }

    /**
     *  Making sure the appointment time is in the future
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $appointment_date = $this->input('appointment_date');
            $appointment_time = $this->input('appointment_time');

            if ($appointment_date && $appointment_time) {
                $datetimeString = $appointment_date . ' ' . $appointment_time;
                $appointmentDateTime = Carbon::createFromFormat('Y-m-d H:i', $datetimeString);
                $currentDateTime = now();

                if ($appointmentDateTime->lessThanOrEqualTo($currentDateTime)) {
                    $validator->errors()->add('appointment_time', 'Paslaugos laikas negali būti ankstesnis nei dabartinis');
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'appointment_date.after_or_equal' => 'Paslaugos data negali būti ankstesnė nei šiandienos'
        ];
    }
}

<?php

    namespace App\Http\Requests\Api\V1;

    use Illuminate\Foundation\Http\FormRequest;

    class ShiftRequest extends FormRequest
    {
        /**
         * Determine if the user is authorized to make this request.
         */
        public function authorize(): bool
        {
            return true;
        }

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
         */
        public function rules(): array
        {
            return [
                'start' => ['required', 'date_format:Y-m-d'],
                'end' => ['required', 'date_format:Y-m-d', 'after_or_equal:start'],
                'fuel' => ['nullable', 'boolean'],
                'first' => ['nullable', 'boolean'],
                'last' => ['nullable', 'boolean'],
            ];
        }


    }

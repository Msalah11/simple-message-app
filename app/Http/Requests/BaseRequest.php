<?php

namespace App\Http\Requests;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    use ApiResponse;

    protected function failedValidation(Validator $validator): void
    {
        if ($this->wantsJson()) {
            $errors = (new ValidationException($validator))->errors();
            throw new HttpResponseException($this->sendValidationError($errors));
        }
        parent::failedValidation($validator);
    }

    public function authorize(): bool
    {
        return true;
    }
}

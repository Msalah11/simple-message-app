<?php

namespace App\Http\Requests\Message;

use App\Http\Requests\BaseRequest;

class StoreMessage extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'message' => ['required', 'string', 'max:255'],
        ];
    }
}

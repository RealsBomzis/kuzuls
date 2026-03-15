<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'vards' => ['required','string','min:2','max:100'],
            'epasts' => ['required','email','max:190'],
            'tema' => ['nullable','string','max:200'],
            'zinojums' => ['required','string','min:5','max:2000'],
        ];
    }
}
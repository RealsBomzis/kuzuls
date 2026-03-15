<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLapaRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()->can('create', \App\Models\Lapa::class); }

    public function rules(): array
    {
        return [
            'slug' => ['required','string','max:180','regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/','unique:lapas,slug'],
            'virsraksts' => ['required','string','min:3','max:200'],
            'saturs' => ['required','string','max:10000'],
            'kategorija_id' => ['nullable','integer','exists:kategorijas,id'],
            'publicets' => ['sometimes','boolean'],
        ];
    }
}
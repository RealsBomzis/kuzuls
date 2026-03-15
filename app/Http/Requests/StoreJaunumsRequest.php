<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJaunumsRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()->can('create', \App\Models\Jaunums::class); }

    public function rules(): array
    {
        return [
            'virsraksts' => ['required','string','min:5','max:200'],
            'ievads' => ['nullable','string','max:500'],
            'saturs' => ['required','string','max:10000'],
            'kategorija_id' => ['nullable','integer','exists:kategorijas,id'],
            'publicets' => ['sometimes','boolean'],
            'publicesanas_datums' => ['nullable','date'],
        ];
    }
}
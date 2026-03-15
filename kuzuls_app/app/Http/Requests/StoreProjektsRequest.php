<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjektsRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()->can('create', \App\Models\Projekts::class); }

    public function rules(): array
    {
        return [
            'nosaukums' => ['required','string','min:3','max:200'],
            'apraksts' => ['required','string','max:7000'],
            'statuss' => ['required','in:planots,aktivs,pabeigts'],
            'sakuma_datums' => ['required','date'],
            'beigu_datums' => ['nullable','date','after_or_equal:sakuma_datums'],
            'kategorija_id' => ['nullable','integer','exists:kategorijas,id'],
            'publicets' => ['sometimes','boolean'],
        ];
    }
}
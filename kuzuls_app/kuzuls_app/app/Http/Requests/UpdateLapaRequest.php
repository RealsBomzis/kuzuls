<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLapaRequest extends FormRequest
{
    public function authorize(): bool
    {
       
        return $this->user()?->can('update', $this->route('lapa')) ?? false;
    }

    public function rules(): array
    {
        /** @var \App\Models\Lapa $lapa */
        $lapa = $this->route('lapa');
        $id = $lapa->id;

        return [
            'slug' => [
                'required',
                'string',
                'max:180',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                "unique:lapas,slug,$id",
            ],
            'virsraksts' => ['required', 'string', 'min:3', 'max:200'],
            'saturs' => ['required', 'string', 'max:10000'],
            'kategorija_id' => ['nullable', 'integer', 'exists:kategorijas,id'],
            'publicets' => ['sometimes', 'boolean'],
        ];
    }
}
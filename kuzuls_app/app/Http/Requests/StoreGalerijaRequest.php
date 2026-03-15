<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGalerijaRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()->can('create', \App\Models\Galerija::class); }

    public function rules(): array
    {
        return [
            'nosaukums' => ['required','string','min:3','max:150'],
            'apraksts' => ['nullable','string','max:1000'],
            'kategorija_id' => ['nullable','integer','exists:kategorijas,id'],
            'saistita_tips' => ['required','in:pasakumi,projekti,jaunumi,nav'],
            'saistita_id' => ['nullable','integer'],
            'publicets' => ['sometimes','boolean'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($v) {
            $tips = $this->input('saistita_tips');
            $id = $this->input('saistita_id');
            if ($tips !== 'nav' && empty($id)) {
                $v->errors()->add('saistita_id', 'Saistītais ID ir obligāts, ja tips nav "nav".');
            }
        });
    }
}
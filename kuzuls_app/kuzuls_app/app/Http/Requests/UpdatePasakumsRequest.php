<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasakumsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    protected function prepareForValidation(): void
    {
        $data = $this->all();

        if (array_key_exists('publicets', $data)) {
            $data['publicets'] = $this->boolean('publicets');
        }

        // dd/mm/yyyy -> yyyy-mm-dd
        if (!empty($data['norises_datums']) && preg_match('~^\d{2}/\d{2}/\d{4}$~', $data['norises_datums'])) {
            [$d,$m,$y] = explode('/', $data['norises_datums']);
            $data['norises_datums'] = "{$y}-{$m}-{$d}";
        }

        // Map aliases if your form uses datums/laiks
        if (empty($data['norises_datums']) && !empty($data['datums'])) {
            $data['norises_datums'] = $data['datums'];
            if (preg_match('~^\d{2}/\d{2}/\d{4}$~', $data['norises_datums'])) {
                [$d,$m,$y] = explode('/', $data['norises_datums']);
                $data['norises_datums'] = "{$y}-{$m}-{$d}";
            }
        }

        if (empty($data['sakuma_laiks']) && !empty($data['laiks'])) {
            $data['sakuma_laiks'] = $data['laiks'];
        }

        $this->replace($data);
    }

    public function rules(): array
    {
        return [
            'nosaukums' => ['required','string','max:200'],
            'apraksts' => ['nullable','string'],
            'norises_datums' => ['required','date'],
            'sakuma_laiks' => ['required','date_format:H:i'],
            'beigu_laiks' => ['nullable','date_format:H:i','after:sakuma_laiks'],
            'vieta' => ['required','string','max:200'],
            'kategorija_id' => ['nullable','integer','exists:kategorijas,id'],
            'talrunis' => ['nullable','string','max:50'],
            'epasts' => ['nullable','email','max:190'],
            'publicets' => ['sometimes','boolean'],
            'attels' => ['nullable','file','image','mimes:jpg,jpeg,png,webp','max:4096'],
        ];
    }
}
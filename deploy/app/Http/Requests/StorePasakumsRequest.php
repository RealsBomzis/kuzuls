<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePasakumsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null; // policy check happens in controller
    }

    protected function prepareForValidation(): void
    {
        $data = $this->all();

        // 1) Normalize checkbox
        if (array_key_exists('publicets', $data)) {
            $data['publicets'] = $this->boolean('publicets');
        }

        // 2) Normalize date: allow "dd/mm/yyyy" -> "yyyy-mm-dd"
        // Your screenshot shows "21/02/2026"
        if (!empty($data['norises_datums']) && preg_match('~^\d{2}/\d{2}/\d{4}$~', $data['norises_datums'])) {
            [$d, $m, $y] = explode('/', $data['norises_datums']);
            $data['norises_datums'] = "{$y}-{$m}-{$d}";
        }

        // 3) If your form uses different names (common), map them safely:
        // datums -> norises_datums, laiks -> sakuma_laiks
        if (empty($data['norises_datums']) && !empty($data['datums'])) {
            $data['norises_datums'] = $data['datums'];
            if (preg_match('~^\d{2}/\d{2}/\d{4}$~', $data['norises_datums'])) {
                [$d, $m, $y] = explode('/', $data['norises_datums']);
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
            'nosaukums' => ['required', 'string', 'max:200'],
            'apraksts' => ['nullable', 'string'],

            // Use normalized yyyy-mm-dd after prepareForValidation
            'norises_datums' => ['required', 'date'],

            'sakuma_laiks' => ['required', 'date_format:H:i'],
            'beigu_laiks' => ['nullable', 'date_format:H:i', 'after:sakuma_laiks'],

            'vieta' => ['required', 'string', 'max:200'],
            'kategorija_id' => ['nullable', 'integer', 'exists:kategorijas,id'],

            'talrunis' => ['nullable', 'string', 'max:50'],
            'epasts' => ['nullable', 'email', 'max:190'],

            'publicets' => ['sometimes', 'boolean'],

            // Safe image upload
            'attels' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }
}
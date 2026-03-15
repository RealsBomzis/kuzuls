<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGalerijaRequest extends FormRequest
{
    public function authorize(): bool
    {
        // ✅ param name MUST be {galerija}
        return $this->user()?->can('update', $this->route('galerija')) ?? false;
    }

    public function rules(): array
    {
        // Keep rules identical to store (your current intention)
        return (new StoreGalerijaRequest())->rules();
    }
}
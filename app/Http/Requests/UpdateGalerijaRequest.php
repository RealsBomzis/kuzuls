<?php

namespace App\Http\Requests;

class UpdateGalerijaRequest extends StoreGalerijaRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('galerija')) ?? false;
    }
}
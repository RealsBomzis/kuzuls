<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJaunumsRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()->can('update', $this->route('jaunumi')); }
    public function rules(): array { return (new StoreJaunumsRequest())->rules(); }
}
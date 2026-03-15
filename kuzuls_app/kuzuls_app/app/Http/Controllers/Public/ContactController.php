<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Models\KontaktZinojums;

class ContactController extends Controller
{
    public function create()
    {
        return view('public.contact');
    }

    public function store(StoreContactRequest $request)
    {
        KontaktZinojums::create([
            ...$request->validated(),
            'statuss' => 'jauns',
        ]);

        return redirect()->route('contact.create')->with('status', 'Ziņojums nosūtīts!');
    }
}
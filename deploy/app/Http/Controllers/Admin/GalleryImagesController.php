<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Galerija, GalerijasAttels};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryImagesController extends Controller
{
    public function store(Request $request, Galerija $galerija)
    {
        $this->authorize('update', $galerija);

        $validated = $request->validate([
            'image' => ['required','file','mimes:jpg,jpeg,png,webp','max:4096'],
            'alt_teksts' => ['nullable','string','max:200'],
            'seciba' => ['nullable','integer','min:0'],
        ]);

        $path = $request->file('image')->store("galerijas/{$galerija->id}", 'public');

        GalerijasAttels::create([
            'galerija_id' => $galerija->id,
            'fails_cels' => $path,
            'alt_teksts' => $validated['alt_teksts'] ?? null,
            'seciba' => (int)($validated['seciba'] ?? 0),
        ]);

        return back()->with('status', 'Attēls augšupielādēts.');
    }

    public function destroy(Galerija $galerija, GalerijasAttels $attels)
    {
        $this->authorize('update', $galerija);

        if ((int)$attels->galerija_id !== (int)$galerija->id) abort(404);

        if ($attels->fails_cels && Storage::disk('public')->exists($attels->fails_cels)) {
            Storage::disk('public')->delete($attels->fails_cels);
        }
        $attels->delete();

        return back()->with('status', 'Attēls dzēsts.');
    }
}
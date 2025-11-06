<?php

namespace App\Http\Controllers;

use App\Models\ProgramPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProgramPageController extends Controller
{

    public function index()
    {
        return ProgramPage::with('contentBlocks')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'name_bur' => 'required|string',
            'cover_url' => 'required|file|mimes:jpg,jpeg,png,webp,svg',
            'description' => 'required|string',
            'description_bur' => 'required|string',
            'reason' => 'required|string',
            'reason_bur' => 'required|string',
            'content' => 'required|string',
            'content_bur' => 'required|string',
            'img_url' => 'required|file|mimes:jpg,jpeg,png,webp,svg',
            'quote' => 'required|string',
            'quote_bur' => 'required|string'
        ]);

        // Handle file upload
        if ($request->hasFile('cover_url')) {
            $file = $request->file('cover_url');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/programs', $filename); // stored in storage/app/public/covers

            // Force permission for web access
            chmod(storage_path('app/public/programs/' . $filename), 0644);


            $coverUrl = Storage::url($path); // generates /storage/covers/xxxx.jpg
            // Optional: full URL if needed
            $coverUrl = asset($coverUrl);
        }

        // Handle file upload
        if ($request->hasFile('img_url')) {
            $file = $request->file('img_url');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/programs', $filename); // stored in storage/app/public/covers

            // Force permission for web access
            chmod(storage_path('app/public/programs/' . $filename), 0644);


            $imgURL = Storage::url($path); // generates /storage/covers/xxxx.jpg
            // Optional: full URL if needed
            $imgURL = asset($imgURL);
        }

        $programPage = ProgramPage::create([
            'name' => $validated['name'],
            'name_bur' => $validated['name_bur'],
            'description' => $validated['description'],
            'description_bur' => $validated['description_bur'],
            'reason' => $validated['reason'],
            'reason_bur' => $validated['reason_bur'],
            'content' => $validated['content'],
            'content_bur' => $validated['content_bur'],
            'quote' => $validated['quote'],
            'quote_bur' => $validated['quote_bur'],
            'cover_url' => $coverUrl,
            'img_url' => $imgURL,
        ]);

        return response()->json([
            'success' => true,
            'programPage' => $programPage,
        ], 200);
    }

    public function show($id)
    {
        return ProgramPage::with('contentBlocks')->findOrFail($id);
    }

    public function update(Request $request, ProgramPage $programPage)
    {
        $programPage->update($request->all());
        return $programPage;
    }

    public function destroy(ProgramPage $programPage)
    {
        $programPage->delete();
        return response()->noContent();
    }
}

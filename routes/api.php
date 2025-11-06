<?php

use App\Models\Carousal;
use App\Models\Post;
use App\Models\ProgramPage;
use App\Models\Publication;
use App\Models\Service;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/publications', function () {
    // Fetch all publications with required fields
    $publications = Publication::select('id', 'title', 'type', 'content')->get();

    // Group by type
    $grouped = $publications->groupBy('type');
    return response()->json($grouped);
});

Route::get('/posts/{type}', function ($type) {
    // Special case: fetch latest 4 posts
    if ($type === 'all') {
        $posts = Post::select([
            'id',
            'title',
            'title_bur',
            'cover_url',
            'content',
            'content_bur',
            'date',
            'images',
            'tags',
            'type'
        ])
            ->orderBy('date', 'desc')
            ->limit(4)
            ->get();

        return response()->json($posts);
    }

    $posts = Post::where('type', $type)
        ->select([
            'id',
            'title',
            'title_bur',
            'cover_url',
            'content',
            'content_bur',
            'date',
            'images',
            'type',
            'tags',
        ])
        ->orderBy('date', 'desc')
        ->get();

    return response()->json($posts);
});

Route::get('/post/{id}', function ($id) {
    $post = Post::select([
        'id',
        'title',
        'title_bur',
        'cover_url',
        'content',
        'content_bur',
        'date',
        'images',
        'tags',
        'type'
    ])
        ->find($id);

    if (! $post) {
        return response()->json(['message' => 'Post not found'], 404);
    }

    // ✅ Format date
    // $post->formatted_date = $post->date
    //     ? $post->date->format('d M Y') // e.g. "03 Nov 2025"
    //     : null;

    return response()->json($post);
});

Route::get('/carousal/{page}', function ($page) {
    $carousal = Carousal::with('slides')
        ->where('page', $page)
        ->first();

    if (! $carousal) {
        return response()->json(['message' => 'Carousal not found'], 404);
    }

    return response()->json($carousal);
});

Route::get('/stories', function () {
    return Story::with('blocks')->orderBy('id', 'desc')->get();
});

Route::get('/services', function () {
    return Service::select('title')
        ->distinct()
        ->orderBy('title')
        ->get();
});

Route::get('/forms', function (Request $request) {

    $serviceName = $request->query('name');

    return Service::where('title', $serviceName)
        ->with('forms')
        ->firstOrFail();
});


Route::get('/program-pages', function () {
    return ProgramPage::select([
        'id',
        'name',
        'name_bur',
        'cover_url',
        'img_url',
        'description',
        'description_bur',
        'reason',
        'reason_bur',
        'quote',
        'quote_bur',
        'created_at',
        'updated_at',
    ])->get();
});

Route::get('/program-pages/{id}', function ($id) {
    return ProgramPage::findOrFail($id);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

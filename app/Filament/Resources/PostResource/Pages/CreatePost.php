<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    // protected function afterCreate(): void
    // {
    //     $record = $this->record;

    //     Log::info("Record : ", [$record]);

    //     $template = $record->fb_template;
    //     $content  = $record->content_bur ?? '';
    //     $pageId   = config('services.facebook.page_id');
    //     $token    = config('services.facebook.page_access_token');
    //     $frontend = config('services.frontend.url');
    //     Log::info("After create : ", [$template]);
    //     if ($template === 'image_text') {
    //         $this->postImageAndText($record, $pageId, $token, $content);
    //     }
    //     if ($template === 'website_link') {
    //         $url = $frontend . "/post/" . $record->id;
    //         $this->postWebsiteLink($url, $content, $pageId, $token);
    //     }

    //     if ($template === 'gallery') {
    //         $this->postGallery($record->images, $content, $pageId, $token);
    //     }
    // }



    protected function afterCreate(): void
    {
        $record = $this->record;

        // Get all form data, including the non-database fields
        $data = $this->form->getState();

        // Access the 'fb_template' field specifically
        $template = $data['fb_template'] ?? null;
        $content  = $record->content_bur ?? '';
        $images = $record->images ?? [];
        $coverImg = $record->cover_url ?? [];
        $pageId   = config('services.facebook.page_id');
        $token    = config('services.facebook.page_access_token');
        $frontend = config('services.frontend.url');

        Log::info('Images : ', $record->images);
        Log::info("FB Template selected: ", [$template]);

        if ($template === 'image_text') {
            $this->postImageAndText($record, $pageId, $token, $content);
        } elseif ($template === 'website_link') {
            $url = $frontend . "/post/" . $record->id;
            $this->postWebsiteLink($url, $content, $pageId, $token);
        }

        // Assuming $pageId, $token, and $content are available in your class scope
        // $this->postImageAndText($this->record, $pageId, $token, $content); 
    }


    protected function postImageAndText($record, $pageId, $token, $content)
    {


        $coverImg = asset($record->cover_url) ?? '';
        Log::info("coverImg : ", [$coverImg]);
        if (!$record->cover_url) return;

        $response = Http::post("https://graph.facebook.com/v24.0/$pageId/photos", [
            'caption' => $content,
            'url' => $coverImg,
            'access_token' => $token,
        ]);

        Log::info("FB Image Post Response", $response->json());
    }

    protected function postWebsiteLink($url, $content, $pageId, $token)
    {
        $response = Http::post("https://graph.facebook.com/v24.0/$pageId/feed", [
            'message' => $content,
            'link' => $url,
            'access_token' => $token,
        ]);

        Log::info("FB Link Post Response", $response->json());
    }

    // protected function postGallery($images, $content, $pageId, $token)
    // {
    //     if (!$images || !is_array($images)) return;

    //     $mediaIds = [];

    //     foreach ($images as $img) {
    //         $imagePath = storage_path('app/public/' . $img);

    //         $upload = Http::attach(
    //             'source',
    //             file_get_contents($imagePath),
    //             basename($imagePath)
    //         )->post("https://graph.facebook.com/$pageId/photos", [
    //             'published' => false,
    //             'access_token' => $token,
    //         ]);

    //         if ($upload->successful()) {
    //             $mediaIds[] = ['media_fbid' => $upload['id']];
    //         }
    //     }

    //     // Create final carousel post
    //     $response = Http::post("https://graph.facebook.com/$pageId/feed", [
    //         'message' => $content,
    //         'attached_media' => $mediaIds,
    //         'access_token' => $token,
    //     ]);

    //     Log::info("FB Gallery Post Response", $response->json());
    // }
}

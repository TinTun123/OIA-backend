<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <!-- REQUIRED OG TAGS FOR FACEBOOK -->
    <meta property="og:title" content="{{ $post->title }}">
    <meta property="fb:app_id" content="{{ config('services.facebook.app_id') }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($post->content_bur), 140) }}">
    <meta property="og:image" content="{{ asset('storage/' . $post->cover_url) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="post">

    <!-- OPTIONAL BUT RECOMMENDED -->
    <meta name="twitter:card" content="summary_large_image">

    <title>{{ $post->title }}</title>

    <!-- REDIRECT REAL USERS TO FRONTEND SPA -->
    <script>
        window.location.href = "{{ config('services.frontend.url') }}post/{{ $post->id }}";
    </script>
</head>

<body>
    <!-- Fallback if JS fails -->
    <p>Loading...</p>
</body>

</html>
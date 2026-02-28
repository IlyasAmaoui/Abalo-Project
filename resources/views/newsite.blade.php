<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="session_id"  content="{{ session('abalo_user_id')}}">
    <title>NewSite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/js/new.js')
</head>
<body>

<div id="app"></div>

<div id="maintenance">
    <maintenance></maintenance>
</div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</html>

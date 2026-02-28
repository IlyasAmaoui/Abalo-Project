<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Neuen Artikel anlegen</title>

</head>
<body>
    <div id="new_article_app">
        <new-article></new-article>
    </div>
@vite('resources/js/app.js')
</body>
</html>

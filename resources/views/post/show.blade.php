<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <h1>{{ $post->title }}</h1>
    @can('edit_form')
    <a href="#">编辑文字</a>
    @endcan
</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>

    <style>
        body {
            background-color: rgb(110, 86, 56);
            color: rgb(212, 58, 58);
            text-align: center;
        }
    </style>
</head>

<body>

    <h1>è stato {{ $project->published ? 'published' : ' remove' }} new post</h1>
    <h3>{{ $project->name }}</h3>
</body>

</html>

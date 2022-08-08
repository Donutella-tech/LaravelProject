<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Список новостей</title>
</head>
<body>

<div class="container">
    @foreach($news as $item)
        <div class="col-8">
            <h2>{{ $item->name }}</h2>
            <p><img src="{{ Storage::url('image/news/thumbnail/'.$item->image) }}" alt=""></p>
        </div>
    @endforeach
</div>
</body>
</html>

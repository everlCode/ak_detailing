<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Загрузить изображения</title>
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
</head>
<body>
<div class="container py-5">
    <h1>Загрузить изображения</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @if(session('files'))
            <div class="mt-3">
                <h4>Сохраненные файлы</h4>
                <ul>
                    @foreach(session('files') as $f)
                        <li>Оригинал: <a href="/{{ $f['original'] }}" target="_blank">{{ $f['original'] }}</a> — WebP: <a href="/{{ $f['webp'] }}" target="_blank">{{ $f['webp'] }}</a></li>
                    @endforeach
                </ul>
            </div>
        @endif
    @endif

    <form action="{{ route('images.upload.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="target_path" class="form-label">Куда сохранить (поддиректория в public/images)</label>
            <input type="text" name="target_path" id="target_path" class="form-control" value="{{ old('target_path', '') }}" placeholder="например: services/1 или gallery">
            <div class="form-text">Если поле пустое — файлы будут сохранены в <code>public/images/</code>. Разрешены: буквы, цифры, дефис, подчёркивание и слеш (/).</div>
        </div>

        <div class="mb-3">
            <label for="images" class="form-label">Выберите изображения (до 10)</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Загрузить и конвертировать</button>
    </form>

</div>
</body>
</html>

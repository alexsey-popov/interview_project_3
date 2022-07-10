<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Прайслисты</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <header>
        @include('layout.menu')
    </header>

    <main class="container">
        @include('layout.breadscrumbs')

        <div class="bg-light p-5 rounded">
            @yield('content')
        </div>
    </main>

    @include('layout.modal')

</body>
</html>

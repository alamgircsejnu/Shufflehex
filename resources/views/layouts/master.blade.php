<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Shufflehex</title>

@yield('css')

</head>
<body>


<div id="body-content">
@include('partials.list-left-sidebar')
@include('partials.top-bar')
@yield('content')
@include('partials.right-sidebar')
</div>
@yield('js')

</body>
</html>
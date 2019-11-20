<!DOCTYPE html>
<html lang="cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>@yield('title')</title>
    @include('home.public.style')
    @include('home.public.script')
</head>
<body>
{{--header start--}}
@include('home.public.header')
{{--header end--}}

{{--main start--}}
@section('main')
@show
{{--main end--}}

{{--footer start--}}
@include('home.public.footer')
{{--footer end--}}

@include('home.public.footerjs')
</body>
</html>
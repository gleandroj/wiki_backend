<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:400,500,700" rel="stylesheet">
        <link href="{{ mix('css/style.css') }}" rel="stylesheet">

        <title>{{ config('app.name') }}</title>
    </head>
    <body ng-app="Wiki">

        <ui-view></ui-view>

        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
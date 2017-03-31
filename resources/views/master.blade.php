<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="shortcut icon" type="image/x-icon" href="/favicon.png">

        <link rel="stylesheet" href="/css/app.css">
        <script src="/js/jquery.js"></script>

        <title>SecureCloud</title>
    </head>
    <body>

        <main>

            @include('partials.header')

            <md-layout md-gutter>
                <md-layout md-gutter>
                    <md-layout></md-layout>
                    <md-layout md-gutter md-flex-xsmall="100" md-flex-small="100" md-flex-medium="95" md-flex-large="85" md-flex-xlarge="80" id="container">
                        @yield('content')
                    </md-layout>
                    <md-layout></md-layout>
                </md-layout>
            </md-layout>

        </main>

        <script src="/js/app.js"></script>

    </body>
</html>

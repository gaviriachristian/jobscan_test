<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{config('pagetitles.names.' . Route::currentRouteAction())}}{{(($page_suffix = config('pagetitles.suffix')) ? ' | ' . $page_suffix : null)}}</title>

        <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
        <link href="{{asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet">
        <link href="{{asset('css/animate.css')}}" rel="stylesheet">
        <link href="{{asset('css/style.css')}}" rel="stylesheet">
        <link href="{{asset('css/views/layouts/main.css')}}" rel="stylesheet">
        <link href="{{asset('css/views/' . str_replace('.', '/', array_key_first(view()->getFinder()->getViews())) . '.css')}}" rel="stylesheet">
        <link href="{{asset('css/jquery.growl.css')}}" rel="stylesheet">
        <link href="{{asset('css/jquery.nouislider.css')}}" rel="stylesheet">

        <link href="{{asset('css/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
        <link href="{{asset('css/datatables/dataTables.responsive.css')}}" rel="stylesheet">
        <link href="{{asset('css/datatables/dataTables.tableTools.min.css')}}" rel="stylesheet">

        <script src="{{asset('js/class.js')}}"></script>
        <script src="{{asset('js/jquery-2.1.1.js')}}"></script>
        <script src="{{asset('js/bootstrap.min.js')}}"></script>
        <script src="{{asset('js/views/layouts/main.js')}}"></script>
        <script src="{{asset('js/views/' . str_replace('.', '/', array_key_first(view()->getFinder()->getViews())) . '.js')}}"></script>
        <script src="{{asset('js/jquery.growl.js')}}"></script>
        <script src="{{asset('js/jquery.nouislider.min.js')}}"></script>

        <script src="{{asset('js/datatables/jquery.dataTables.js')}}"></script>
        <script src="{{asset('js/datatables/dataTables.bootstrap.js')}}"></script>
        <script src="{{asset('js/datatables/dataTables.responsive.js')}}"></script>
        <script src="{{asset('js/datatables/dataTables.tableTools.min.js')}}"></script>
    </head>
    <body class="gray-bg">
        <script>
            var ViewsLayoutsMainInstance = new ViewsLayoutsMain();
        </script>
        @yield('content')
    </body>
</html>
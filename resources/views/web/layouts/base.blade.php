<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--<title>首页</title>--}}

    <!-- Styles -->
    <link href="/assets/front/amazeUI-2.4.2/css/amazeui.css" rel="stylesheet" type="text/css" />
    <link href="/assets/front/amazeUI-2.4.2/css/admin.css" rel="stylesheet" type="text/css" />

    <script src="/assets/front/amazeUI-2.4.2/js/jquery.min.js"></script>
    <script src="/assets/front/amazeUI-2.4.2/js/amazeui.min.js"></script>

@yield('assets_head')

<!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

</head>
<body>

@yield('content')

<script>
    window.jQuery || document.write('<script src="/assets/front/basic/js/jquery.min.js "><\/script>');
</script>
<script src="/assets/global/plugins/jquery.form.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript" ></script>
<script src="/assets/front/js/custom.js"></script>

<script>
    $(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>
<!-- Scripts -->
@yield('assets_foot')

</body>
</html>

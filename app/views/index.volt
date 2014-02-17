<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        {{ get_title() }}
        {{ stylesheet_link('css/application.css') }}
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--meta name="description" content="Description"-->
        <meta name="author" content="Per Arnborg">
        {{ javascript_include('js/modernizr.js') }}
    </head>
    <body>
        {{ content() }}
        <!--[if lt IE 9]>
        {{ javascript_include('js/jquery-1.10.2.min.js') }}
        {{ javascript_include('js/selectivizr-min.js') }}
        <![endif]-->
        <!--[if gte IE 9]><!-->
        {{ javascript_include('js/jquery-2.0.3.min.js') }}
        <!--<![endif]-->
        {{ javascript_include('js/jquery.stringify.js') }}
        {{ javascript_include('js/application.js') }}
    </body>
</html>

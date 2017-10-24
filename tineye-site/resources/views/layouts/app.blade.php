<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Tineye - search Tinder profiles</title>

        <!-- CSS And JavaScript -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <style>
            @media min-width: 200px {
                body {
                    font-size: 44px;
                }
            }
        </style>
        <script src="http://code.jquery.com/jquery-3.2.1.min.js"  crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script type="text/javascript">
            var cities_map = $.parseJSON('<?php echo $cities_map?>');
        </script>
        @if (env("APP_ENV") == "production")
            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=UA-108501536-1"></script>
            <script>
              window.dataLayer = window.dataLayer || [];
              function gtag(){dataLayer.push(arguments);}
              gtag('js', new Date());

              gtag('config', 'UA-108501536-1');
            </script>
        @endif
    </head>

    <body>
        @yield('navbar')
        <div class="container">
        @yield('content')
        </div>
    </body>
</html>
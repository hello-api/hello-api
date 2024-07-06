<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PraiseCharts API - {{strtoupper(env('APP_ENV'))}}</title>
    <link rel="stylesheet" type="text/css" href="{{config('app.url').'/assets/documentation/css/swagger-ui.css'}}"/>
    <link rel="stylesheet" type="text/css" href="{{config('app.url').'/assets/documentation/css/index.css'}}"/>
    <link rel="icon" type="image/png" href="{{config('app.url').'/assets/documentation/png/favicon-32x32.png'}}"
          sizes="32x32"/>
    <link rel="icon" type="image/png" href="{{config('app.url').'/assets/documentation/png/favicon-16x16.png'}}"
          sizes="16x16"/>
</head>

<body>
<div id="swagger-ui"></div>
<script>
    const specsUrls = @json($urls, JSON_THROW_ON_ERROR);
</script>
<script src="{{config('apiato.api.url').'/assets/documentation/js/swagger-ui-bundle.js'}}" charset="UTF-8"></script>
<script src="{{config('apiato.api.url').'/assets/documentation/js/swagger-ui-standalone-preset.js'}}" charset="UTF-8"></script>
<script src="{{config('apiato.api.url').'/assets/documentation/js/swagger-initializer.js'}}" charset="UTF-8"></script>
</body>
</html>

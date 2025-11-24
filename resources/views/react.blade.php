<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Auth Demo React</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Set Vite base for API if needed
        window.VITE_BASE_URL = '{{ rtrim(config('app.url'), '/') }}';
    </script>
    <style>
        body { margin: 0; padding: 24px; }
        button { padding: 8px 12px; }
        input, select { padding: 6px 8px; }
    </style>
  </head>
  <body>
    <div id="react-root"></div>
  </body>
</html>
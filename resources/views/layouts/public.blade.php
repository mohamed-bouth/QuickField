<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>QuickField Public Layout</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-b from-green-50/40 via-white to-gray-50 flex flex-col">

  <!-- Header -->
    @include('public.partials.navbar')

    <main>
        @yield('content')
    </main>

  <!-- Footer -->
    @include('public.partials.footer')

</body>
</html>
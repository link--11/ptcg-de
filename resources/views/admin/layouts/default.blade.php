<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/styles/tailwind.css', 'resources/scripts/admin.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('admin.layouts.navigation')

            <!-- Page Heading -->
            @if (isset($title))
                <div class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ $title }}
                        </h2>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main>
                <div class="py-10">
                    <div class="flex flex-col gap-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
                        {{ $slot }}
                    </div>
                </div>
            </main>

        </div>
    </body>
</html>

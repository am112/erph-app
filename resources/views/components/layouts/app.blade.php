<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @filamentStyles
    @vite('resources/css/app.css')

    <script data-navigate-once>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (
            localStorage.getItem("color-theme") === "dark" ||
            (!("color-theme" in localStorage) &&
                window.matchMedia("(prefers-color-scheme: dark)").matches)
        ) {
            document.documentElement.classList.add("dark");
        } else {
            document.documentElement.classList.remove("dark");
        }
    </script>

</head>

<body class="min-h-screen ">
    <div class="min-h-screen antialiased bg-gray-50 dark:bg-gray-900">
        <!-- Header -->
        <x-layouts.app.header />

        <!-- Sidebar -->
        <x-layouts.app.aside />

        <!-- Main -->
        <main class="md:p-8 md:pt-16 md:ml-64 h-full min-h-full p-4 pt-16">
            {{ $slot }}
        </main>
        @persist('toast')
            <livewire:toast />
        @endpersist
    </div>
    @filamentScripts
    @vite('resources/js/app.js')
</body>

</html>

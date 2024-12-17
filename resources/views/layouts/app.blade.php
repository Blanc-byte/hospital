<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Sidebar styles */
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                width: 200px;
                background-color: white;
                border-right: 1px solid #e2e8f0;
                padding: 16px;
                box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            }

            
            .content {
                margin-left: 200px;
                padding: 16px;
                min-height: 100vh;
                background-color: #1b5846;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div>
            <!-- Sidebar Navigation -->
            <div class="sidebar">
                @if(Auth::user()->role === 'Admin')
                    @include('layouts.navigation')
                @elseif(Auth::user()->role === 'Patient')
                    @include('layouts.patientNav')
                @endif
            </div>

            <!-- Main Content -->
            <div class="content bg-gray-100">
                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">

    {{-- The navbar with `sticky` and `full-width` --}}
    <x-nav sticky full-width>

        <x-slot:brand>
            {{-- Drawer toggle for "main-drawer" --}}
            <label for="main-drawer" class="lg:hidden mr-3">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>

            {{-- Brand --}}
            <div>
                {{-- BRAND --}}
                <div class="custom-app-brand">
                    <div class="flex items-center">
                        <!-- Custom Brand Logo -->
                        <img src="https://lilyogis.in/SiteImages/RocketLearningLogo.jpg" alt="Rocket Learning Logo" class="brand-logo w-10 h-10">

                        <!-- Custom Brand Name -->
                        <span class="ml-2 text-xl font-bold">
                            Rocket Learning
                        </span>
                    </div>
                </div>
            </div>
        </x-slot:brand>

        {{-- Right side actions --}}
        <x-slot:actions>
            <x-dropdown class="btn-warning">
                <x-slot:trigger>
                    <x-button icon="o-bell" class="btn-circle btn-warning" />
                </x-slot:trigger>
                <x-menu-item title="Archive" />
                <x-menu-item title="Move" />
            </x-dropdown>
            <x-theme-toggle class="btn btn-circle" />
            <x-dropdown label="Ashish Dubey">
                <x-menu-item title="Edit - Profile" icon="o-user" />
                <x-menu-item title="Logout" icon="o-power" />
            </x-dropdown>
        </x-slot:actions>
    </x-nav>

    {{-- The main content with `full-width` --}}
    <x-main with-nav full-width>

        {{-- This is a sidebar that works also as a drawer on small screens --}}
        {{-- Notice the `main-drawer` reference here --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-200">

            {{-- User --}}
            @if($user = auth()->user())
            <x-list-item :item="$user" value="name" sub-value="email" no-separator no-hover class="pt-2">
                <x-slot:actions>
                    <x-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff" no-wire-navigate link="/logout" />
                </x-slot:actions>
            </x-list-item>

            <x-menu-separator />
            @endif

            {{-- Activates the menu item when a route matches the `link` property --}}
            <x-menu activate-by-route>
                <x-menu-item title="Home" icon="o-home" link="###" />
                <x-menu-separator />
                <x-menu-sub title="Users" icon="o-users">
                    <x-menu-item title="Browse Users" icon="o-list-bullet" />
                    <x-menu-item title="Invite" icon="o-envelope" />
                    <x-menu-item title="Roles" icon="o-list-bullet" />
                    <x-menu-item title="Permissions" icon="o-list-bullet" />
                </x-menu-sub>
                <x-menu-separator />
                <x-menu-sub title="Virtual Numbers" icon="o-phone" link="###">
                    <x-menu-item title="Browse Virtual Numbers" icon="o-list-bullet" link="{{ route('vnumbers.browse') }}" wire-navigate />
                    <x-menu-item title="Create Virtual Number" icon="o-plus-circle" />
                </x-menu-sub>
                <x-menu-separator />
                <x-menu-item title="Organizations" icon="o-briefcase" link="###" />
                <x-menu-separator />
                <x-menu-item title="Moderators" icon="o-user-group" link="###" />
                <x-menu-separator />
                <x-menu-item title="Groups" icon="o-users" link="###" />
                <x-menu-separator />
                <x-menu-item title="Schools" icon="o-academic-cap" link="###" />
                <x-menu-separator />
                <x-menu-item title="Families" icon="o-users" link="###" />
                <x-menu-separator />
                <x-menu-item title="Activities" icon="o-list-bullet" link="###" />
                <x-menu-separator />
                <x-menu-item title="Polls" icon="o-puzzle-piece" link="###" />
                <x-menu-separator />
                <x-menu-item title="Interventions" icon="o-paper-airplane" link="###" />
                <x-menu-separator />
                <x-menu-item title="Job Status" icon="o-information-circle" link="###" />
                <x-menu-separator />
                <x-menu-item title="Report Card" icon="o-pencil" link="###" />
                <x-menu-separator />
                <x-menu-item title="Survey Form" icon="o-clipboard" link="###" />
                <x-menu-separator />
                <x-menu-item title="Analytics" icon="o-chart-bar" link="###" />
                <x-menu-separator />
                <x-menu-item title="Video Compilations" icon="o-video-camera" link="###" />
                <x-menu-separator />
                <x-menu-item title="Certificates" icon="o-trophy" link="###" />
                <x-menu-separator />
                <x-menu-item title="Questions" icon="o-question-mark-circle" link="###" />
                <x-menu-separator />
                <x-menu-item title="Quiz" icon="o-clock" link="###" />
                <x-menu-separator />
            </x-menu>

        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>

    {{-- TOAST area --}}
    <x-toast />
    @livewireScripts
</body>

</html>
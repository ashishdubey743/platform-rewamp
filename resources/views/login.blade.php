<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Flow</title>
    <link rel="stylesheet" href="https://flow.mary-ui.com/build/assets/app-7BCGbtJc.css">
    <script type="module" src="https://flow.mary-ui.com/build/assets/app-zfEY35Ms.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">
    <main class="w-full mx-auto">
        <div class="flex items-center justify-center min-h-screen">
            <div class="w-full max-w-md p-6">
                <div class="text-center">
                    <div class="flex items-center">
                        <x-theme-toggle class="btn btn-circle hidden" />
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
                    </div>
                </div>
                <div class="flex items-center justify-center mb-2">
                    <a href="/">
                        <div class="flex">
                            <span class="font-bold text-3xl bg-gradient-to-r from-purple-500 to-pink-300 bg-clip-text text-transparent">
                                Login
                            </span>
                        </div>
                    </a>
                </div>


                <x-form class="flex flex-col space-y-4">
                    <x-input label="E-mail" inline />
                    <x-input label="Password" inline type="password" />
                    <div class="flex items-center justify-between">
                        <x-checkbox wire:model="item4" class="self-start">
                            <x-slot:label>
                                Remember Me
                            </x-slot:label>
                        </x-checkbox>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800">Forgot Your Password?</a>
                    </div>
                    <div class="flex justify-end">
                        <x-button type="submit" class="btn btn-primary normal-case hover:bg-purple-600 transition duration-200">
                            <svg class="inline w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"></path>
                            </svg>
                            Login
                        </x-button>
                    </div>
                </x-form>
            </div>
        </div>
    </main>
</body>

</html>
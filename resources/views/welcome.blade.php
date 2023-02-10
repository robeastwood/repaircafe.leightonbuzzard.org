<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>Leighton Buzzard Repair Cafe</title>

        @vite('resources/js/app.js')
    </head>
    <body class="antialiased">
        <div class="grid h-screen place-items-center">
            <figure
                class="md:flex justify-center bg-slate-100 rounded-xl p-8 md:p-0 dark:bg-slate-800 w-1/2"
            >
                <img
                    class="w-24 h-24 md:rounded-full mx-auto"
                    src="https://picsum.photos/200"
                    alt=""
                    width="384"
                    height="512"
                />
                <div class="pt-6 md:p-8 text-center space-y-4">
                    <blockquote>
                        <p class="text-lg font-medium">
                            Leighton Buzzard Repair Cafe
                        </p>
                    </blockquote>
                    <figcaption class="font-medium">
                        <div class="text-sky-500 dark:text-sky-400">
                            Coming Soon!
                        </div>
                        <div class="text-slate-700 dark:text-slate-500">
                            check back later
                        </div>
                    </figcaption>
                </div>
            </figure>
        </div>
    </body>
</html>

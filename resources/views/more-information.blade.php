<x-layouts.public title="More Information">
    <!-- Hero Section -->
    <div class="relative pt-16 pb-32 flex content-center items-center justify-center" style="min-height: 40vh">
        <div class="absolute top-0 w-full h-full bg-center bg-cover"
            style="background-image: url('https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=1267&amp;q=80');">
            <span id="blackOverlay" class="w-full h-full absolute opacity-75 bg-black"></span>
        </div>
        <div class="container relative mx-auto">
            <div class="items-center flex flex-wrap">
                <div class="w-full px-4 ml-auto mr-auto text-center">
                    <h1 class="text-white font-semibold text-5xl">
                        More Information
                    </h1>
                    <p class="mt-4 text-lg text-gray-300">
                        Everything you need to know about our Repair Café
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <section class="py-12 -mt-20 relative z-10">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="relative flex flex-col min-w-0 break-words bg-white w-full shadow-lg rounded-2xl backdrop-blur-sm bg-white/90 p-8">
                    <h2 class="text-3xl font-semibold mb-6 text-gray-800">
                        About Repair Café Leighton Buzzard
                    </h2>

                    <div class="space-y-6 text-gray-700">
                        <p class="text-lg leading-relaxed">
                            This page will contain comprehensive information about the Repair Café, including:
                        </p>

                        <ul class="list-disc list-inside space-y-3 pl-4">
                            <li>Detailed history of the Repair Café movement</li>
                            <li>Our specific location and venue information</li>
                            <li>Opening times and event schedules</li>
                            <li>What to expect when you visit</li>
                            <li>How to prepare your items for repair</li>
                            <li>Information about our volunteer team</li>
                            <li>Statistics and impact of our repairs</li>
                            <li>Community partnerships and supporters</li>
                        </ul>

                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 my-6">
                            <p class="text-blue-700">
                                <strong>Note:</strong> This is a placeholder page. Content will be added soon with detailed information about our Repair Café services, team, and community impact.
                            </p>
                        </div>

                        <div class="mt-8">
                            <h3 class="text-2xl font-semibold mb-4 text-gray-800">Get Involved</h3>
                            <p class="leading-relaxed">
                                Whether you're looking to get something repaired, share your repair skills, or simply learn more about sustainable living, we'd love to hear from you.
                            </p>
                        </div>

                        <div class="mt-6 text-center">
                            <a href="{{ route('contact') }}" class="inline-block px-8 py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition-colors">
                                Contact Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>

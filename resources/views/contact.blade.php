<x-layouts.public title="Contact Us">
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
                        Contact Us
                    </h1>
                    <p class="mt-4 text-lg text-gray-300">
                        Get in touch with the organisers
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <section class="py-12 -mt-20 relative z-10">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

                    <!-- Contact Information Card -->
                    <div class="relative flex flex-col min-w-0 break-words bg-white w-full shadow-lg rounded-2xl backdrop-blur-sm bg-white/90 p-8">
                        <div class="flex items-center mb-6">
                            <div class="text-white p-3 inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-blue-500 mr-4">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h2 class="text-2xl font-semibold text-gray-800">
                                Get In Touch
                            </h2>
                        </div>

                        <div class="text-gray-700 space-y-6">
                            <div>
                                <h3 class="font-semibold text-lg mb-2 flex items-center">
                                    <i class="fas fa-at text-blue-500 mr-3"></i>
                                    Email
                                </h3>
                                <p class="text-gray-600 pl-9">
                                    <a href="mailto:repaircafe@leightonbuzzard.org" class="hover:text-blue-600">repaircafe@leightonbuzzard.org</a>
                                </p>
                            </div>

                            <div>
                                <h3 class="font-semibold text-lg mb-2 flex items-center">
                                    <i class="fab fa-facebook text-blue-500 mr-3"></i>
                                    Facebook
                                </h3>
                                <p class="text-gray-600 pl-9">
                                    <a href="https://www.facebook.com/groups/repaircafelb" target="_blank" class="hover:text-blue-600">
                                        Repair Café LB Facebook Group
                                    </a>
                                </p>
                            </div>

                            <div>
                                <h3 class="font-semibold text-lg mb-2 flex items-center">
                                    <i class="fas fa-map-marker-alt text-blue-500 mr-3"></i>
                                    Location
                                </h3>
                                <p class="text-gray-600 pl-9">
                                    Come say hello at one of our events!<br/>Check the details of each event to find out where it's being held
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links Card -->
                    <div class="relative flex flex-col min-w-0 break-words bg-white w-full shadow-lg rounded-2xl backdrop-blur-sm bg-white/90 p-8">
                        <div class="flex items-center mb-6">
                            <div class="text-white p-3 inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-green-500 mr-4">
                                <i class="fas fa-link"></i>
                            </div>
                            <h2 class="text-2xl font-semibold text-gray-800">
                                Quick Links
                            </h2>
                        </div>

                        <div class="text-gray-700 space-y-4">
                            <p class="leading-relaxed">
                                Looking for something specific? Here are some helpful links:
                            </p>
                            <ul class="space-y-3">
                                <li>
                                    <a href="{{ route('more-information') }}" class="flex items-center text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-info-circle mr-3"></i>
                                        More Information
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('repair-disclaimer') }}" class="flex items-center text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-exclamation-triangle mr-3"></i>
                                        Repair Disclaimer
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('policies') }}" class="flex items-center text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-file-alt mr-3"></i>
                                        Our Policies
                                    </a>
                                </li>
                                <li>
                                    <a href="https://totallylb.wordpress.com" target="_blank" class="flex items-center text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-external-link-alt mr-3"></i>
                                        Totally Leighton Buzzard
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>

                <!-- Contact Form Placeholder -->
                <div class="relative flex flex-col min-w-0 break-words bg-white w-full shadow-lg rounded-2xl backdrop-blur-sm bg-white/90 p-8">
                    <div class="flex items-center mb-6">
                        <div class="text-white p-3 inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-purple-500 mr-4">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <h2 class="text-2xl font-semibold text-gray-800">
                            Send Us a Message
                        </h2>
                    </div>

                    <div class="bg-blue-50 border-l-4 border-blue-400 p-6 rounded-r-lg">
                        <div class="flex items-start">
                            <div class="text-blue-600 mr-4 mt-1">
                                <i class="fas fa-info-circle text-xl"></i>
                            </div>
                            <div class="text-blue-700">
                                <p class="font-semibold mb-2">Contact Form Coming Soon</p>
                                <p>
                                    We're working on a contact form for this page. In the meantime, please feel free to reach out to us via email or Facebook using the contact information above.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 text-gray-700">
                        <h3 class="text-xl font-semibold mb-4">What can we help you with?</h3>
                        <ul class="list-disc list-inside space-y-2 pl-4">
                            <li>Questions about bringing items for repair</li>
                            <li>Volunteering opportunities</li>
                            <li>Event dates and locations</li>
                            <li>General inquiries about our services</li>
                            <li>Partnerships and collaborations</li>
                        </ul>
                    </div>

                    <div class="mt-8 text-center">
                        <a href="{{ url('/') }}" class="inline-block px-8 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition-colors">
                            Back to Home
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-layouts.public>

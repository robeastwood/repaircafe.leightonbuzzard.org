<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18]">


        <!-- Header -->
        <header class="w-full absolute top-0 left-0 z-10 p-4 flex justify-end">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 bg-white border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>
                        @if (Auth::user()->can('access-admin-panel'))
                            <a
                                href="{{ url('/admin') }}"
                                class="inline-block px-5 py-1.5 bg-white border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                            >
                                Admin
                            </a>
                        @endif
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 bg-white text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 bg-white border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <!-- Hero Section -->
        <div class="relative pt-16 pb-32 flex content-center items-center justify-center" style="min-height: 75vh">
            <div class="absolute top-0 w-full h-full bg-center bg-cover"
                style="
                        background-image: url('https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=1267&amp;q=80');
                    ">
                <span id="blackOverlay" class="w-full h-full absolute opacity-75 bg-black"></span>
            </div>
            <div class="container relative mx-auto">
                <div class="flex justify-center mb-8">
                    <img src="{{ asset('images/logo.svg') }}" class="w-64 h-64" alt="Logo" />
                </div>
                <div class="items-center flex flex-wrap">
                    <div class="w-full lg:w-8/12 px-4 ml-auto mr-auto text-center">
                        <div>                            
                            <h1 class="text-white font-semibold text-5xl">
                                Got something that's busted?<br />
                                Don't bin it, repair it!
                            </h1>
                            <p class="mt-4 text-lg text-gray-300">
                                Have you got small household items that need some tender loving care (TLC) and you haven't
                                got the time or skills to fix them yourself? Don't bin them, bring them to the Repair Café
                                Leighton Buzzard and let our volunteer fixers try to mend them or give advice.
                            </p>
                        </div>
                    </div>
                </div>                
            </div>
        </div>

        <!-- Container for the feature section -->
        <section class="py-12 -mt-32 relative z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Grid container for the feature boxes -->
                <!-- 
                    - `grid`: Establishes a grid layout.
                    - `grid-cols-1`: On mobile, stack the cards in a single column.
                    - `md:grid-cols-3`: On medium screens and up, display cards in three columns.
                    - `gap-8`: Adds consistent spacing between the grid items.
                -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                    <!-- Card 1: Save Money -->
                    <!-- 
                        - `h-full`: Ensures the card expands to the full height of the grid row.
                        - `flex flex-col`: Allows the content within the card to be aligned vertically.
                    -->
                    <div class="relative flex flex-col h-full min-w-0 break-words bg-white w-full shadow-lg rounded-2xl backdrop-blur-sm bg-white/90">
                        <!-- 
                            - `flex-grow`: Allows this container to expand and fill the available vertical space, pushing the content down.
                            - `flex flex-col items-center`: Centers the content within the card.
                        -->
                        <div class="px-6 py-8 flex-grow flex flex-col items-center text-center">
                            <div class="text-white p-3 inline-flex items-center justify-center w-20 h-20 mb-6 shadow-lg rounded-full bg-yellow-400">
                                <i class="fas fa-2xl fa-sterling-sign"></i>
                            </div>
                            <h6 class="text-xl font-semibold text-gray-800">
                                Save Money
                            </h6>
                            <p class="mt-2 mb-4 text-gray-600">
                                We're all looking for ways to save. Many household items are replaced unnecessarily for a minor issue that could be easily repaired for free, or for a fraction of the cost.
                            </p>
                        </div>
                    </div>

                    <!-- Card 2: Reduce Waste -->
                    <div class="relative flex flex-col h-full min-w-0 break-words bg-white w-full shadow-lg rounded-2xl backdrop-blur-sm bg-white/90">
                        <div class="px-6 py-8 flex-grow flex flex-col items-center text-center">
                            <div class="text-white p-3 inline-flex items-center justify-center w-20 h-20 mb-6 shadow-lg rounded-full bg-green-400">
                                <i class="fas fa-2xl fa-recycle"></i>
                            </div>
                            <h6 class="text-xl font-semibold text-gray-800">
                                Reduce Waste
                            </h6>
                            <p class="mt-2 mb-4 text-gray-600">
                                On average, we each throw away 23.9kg of e-waste per year. The UK is set to become the world's largest producer by 2024. Let's limit the effects of our throwaway society.
                            </p>
                        </div>
                    </div>

                    <!-- Card 3: Learn New Skills -->
                    <div class="relative flex flex-col h-full min-w-0 break-words bg-white w-full shadow-lg rounded-2xl backdrop-blur-sm bg-white/90">
                        <div class="px-6 py-8 flex-grow flex flex-col items-center text-center">
                            <div class="text-white p-3 inline-flex items-center justify-center w-20 h-20 mb-6 shadow-lg rounded-full bg-pink-400">
                                <i class="fas fa-2xl fa-brain"></i>
                            </div>
                            <h6 class="text-xl font-semibold text-gray-800">
                                Learn New Skills
                            </h6>
                            <p class="mt-2 mb-4 text-gray-600">
                                Repair cafes are all about sharing skills to maintain and repair goods. It's amazing how much you can fix with a few tips, tricks, and a little confidence. Come share your knowledge!
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- What is a Repair Cafe? Section -->
        <section class="py-6">
            <div class="container mx-auto px-4">
                <div class="overflow-hidden"> <!-- Clearfix container -->

                    <!-- Floated Feature Box -->
                    <div class="w-full md:w-5/12 px-4 mb-6 md:float-right md:ml-8">
                        <div class="relative flex flex-col min-w-0 break-words w-full shadow-lg rounded-2xl backdrop-blur-sm bg-white/90">
                            <img alt="Repair cafe volunteers fixing items" src="{{ asset('images/repair_cafe.jpg') }}" class="w-full h-64 object-cover rounded-t-2xl" />
                            <div class="relative p-8">
                                <div class="absolute -top-12 left-1/2 transform -translate-x-1/2">
                                    <div class="text-white p-3 inline-flex items-center justify-center w-20 h-20 shadow-lg rounded-full bg-pink-500">
                                        <i class="fas fa-2xl fa-wrench"></i>
                                    </div>
                                </div>
                                <h4 class="text-2xl font-bold text-gray-800 text-center mb-4">
                                    What is a Repair Café?
                                </h4>
                                <p class="text-gray-600 leading-relaxed">
                                    A Repair Café is a pop-up community event that matches people who need stuff fixed with people who like to fix things. A key principle of a Repair Café is that when you bring an item to be repaired, you sit with the repairer whilst they attempt to carry out the fix, so that you learn more about the item and the repair process.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Main Text Section -->
                    <div class="px-4">
                        <p class="text-2xl text-light leading-relaxed mt-4 mb-4 text-gray-700">
                            <a href="https://totallylb.wordpress.com/">Totally Leighton Buzzard</a> host monthly Repair Café events in Leighton Buzzard. We bring the cake, you bring your
                            broken items! Everyone brings a willingness to share and learn.
                        </p>
                        <h3 class="text-3xl mt-4 mb-2 font-semibold leading-normal">
                            Why do we run a Repair Café?
                        </h3>
                        <p class="text-lg text-light leading-relaxed mt-4 mb-4 text-gray-700">
                            Repair Cafés are part of fixing our relationship with our belongings and things and helping
                            reduce waste and landfill. The first Repair Café started in 2009 in Amsterdam, Holland and has
                            grown worldwide to over 2000 cafes in various forms.
                        </p>
                        <h3 class="text-3xl mt-4 mb-2 font-semibold leading-normal">
                            What types of items can be brought for repair?
                        </h3>
                        <p class="text-lg text-light leading-relaxed mt-4 mb-4 text-gray-700">
                            We welcome small household items and appliances that you can bring to our events. These for
                            example include:
                        </p>

                        <div class="flex items-center">
                            <span
                                class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-green-600 bg-green-200 mr-3">
                                <i class="fas fa-check"></i>
                                Textiles and clothing repairs
                            </span>
                        </div>
                        <p class="text-gray-600 mb-3">Textiles and clothing repairs, upholstery and similar</p>

                        <div class="flex items-center">
                            <span
                                class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-green-600 bg-green-200 mr-3">
                                <i class="fas fa-check"></i>
                                Household electrical and mechanical
                            </span>
                        </div>
                        <p class="text-gray-600 mb-3">Items such as clocks, toasters, blenders, kettles, lamps, sewing
                            machines, coffee machines, fans etc</p>

                        <div class="flex items-center">
                            <span
                                class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-green-600 bg-green-200 mr-3">
                                <i class="fas fa-check"></i>
                                Electronics
                            </span>
                        </div>
                        <p class="text-gray-600 mb-3">Electronics such as headphones, CD/DVD Players, hi-fi systems,
                            portable entertainment, cameras, childrens toys, etc</p>

                        <div class="flex items-center">
                            <span
                                class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-green-600 bg-green-200 mr-3">
                                <i class="fas fa-check"></i>
                                Computers
                            </span>
                        </div>
                        <p class="text-gray-600 mb-3">Desktops and laptops; Windows or Mac. (Printers - best effort only)
                        </p>

                        <h3 class="text-xl mt-4 mb-2 font-semibold leading-normal">
                            Things we can't help with at the moment:
                        </h3>

                        <div class="flex items-center">
                            <span
                                class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-red-600 bg-red-200 mr-3">
                                <i class="fas fa-times"></i>
                                Large White Goods
                            </span>
                        </div>
                        <p class="text-gray-600 mb-3">Washing machines, dishwashers, microwaves etc. These are too big and
                            bulky to bring in.</p>

                        <div class="flex items-center">
                            <span
                                class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-red-600 bg-red-200 mr-3">
                                <i class="fas fa-times"></i>
                                Mobile phones & TVs
                            </span>
                        </div>
                        <p class="text-gray-600 mb-3">We're not set up for reparing screens of any sort.</p>

                        <div class="flex items-center">
                            <span
                                class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-red-600 bg-red-200 mr-3">
                                <i class="fas fa-times"></i>
                                Bicycles
                            </span>
                        </div>
                        <p class="text-gray-600 mb-3">We can't accept bicycles for now, however the Buzz Cycles group runs
                            existing regular <i>Dr Bike</i> repair sessions.
                            Find out more <a href="https://www.facebook.com/Leightonbuzzcycles">here</a>
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="py-6 bg-gray-50">
            <div class="container mx-auto px-4">
                <h2 class="text-4xl font-semibold text-center mb-16 text-gray-800">
                    Frequently Asked Questions
                </h2>                
                <div class="max-w-4xl mx-auto space-y-12">
                    <div>
                        <h3 class="text-2xl font-semibold mb-4 text-gray-800 flex items-start">
                            <i class="fas fa-wrench text-gray-400 mr-4 mt-1"></i>
                            <span>How much does it cost?</span>
                        </h3>
                        <p class="text-gray-600 leading-relaxed pl-10">
                            Our Repair Café operates on a donation basis. We don't charge for attending or repairs, as our volunteers donate their time and expertise. However, we welcome donations to help cover our running costs, such as venue hire, tools, equipment, and refreshments.<br/>
                            If your repair requires specific replacement parts, you may need to cover those costs. We can advise you on this during the assessment of your item, and where possible we can help you find out where you can purchase the parts. You can then bring the replacement parts with you to the next Repair Café.
                        </p>
                    </div>

                    <div>
                        <h3 class="text-2xl font-semibold mb-4 text-gray-800 flex items-start">
                            <i class="fas fa-wrench text-gray-400 mr-4 mt-1"></i>
                            <span>Do I need to book in advance?</span>
                        </h3>
                        <p class="text-gray-600 leading-relaxed pl-10">
                            While booking isn't always required, we recommend registering your item through our website. This saves time when you visit, helps us ensure we have the right repairers available and can manage the flow of repairs effectively. Some items may require specific tools or expertise, so letting us know in advance helps us prepare. However, we always welcome walk-ins and will do our best to accommodate everyone.
                        </p>
                    </div>

                    <div>
                        <h3 class="text-2xl font-semibold mb-4 text-gray-800 flex items-start">
                            <i class="fas fa-wrench text-gray-400 mr-4 mt-1"></i>
                            <span>How does it work on the day?</span>
                        </h3>
                        <p class="text-gray-600 leading-relaxed pl-10">
                            When you arrive, you will be required to check-in your item, and sign a disclaimer if you have not already done so online.
                            <br/>
                            Depending on the availability of volunteer repairers available at that time, there could be a short wait before a relevant repairer is free to look at your item. Please use this opportunity to buy a drink or some cake and have a chat with others.
                            <br/>
                            When a relevant repairer becomes available, you are encouraged to sit with them, watch the repair process and ask questions (and even assist, if you can). Repair Cafés are essentially about sharing skills and knowledge. 
                        </p>
                    </div>
                    
                    <div>
                        <h3 class="text-2xl font-semibold mb-4 text-gray-800 flex items-start">
                            <i class="fas fa-wrench text-gray-400 mr-4 mt-1"></i>
                            <span>What if my item can't be fixed?</span>
                        </h3>
                        <p class="text-gray-600 leading-relaxed pl-10">
                            Sometimes, despite our best efforts, items may be beyond repair or the repair might not be economically viable. In these cases, our repairers will explain the issue and might be able to suggest alternatives or recommend reliable places for replacement. The learning experience is still valuable - you'll understand what went wrong and might be able to make a more informed decision next time you purchase a similar item. We will also help inform on how you can dispose of the item responsibly. 
                        </p>
                    </div>
                    
                    <div>
                        <h3 class="text-2xl font-semibold mb-4 text-gray-800 flex items-start">
                            <i class="fas fa-wrench text-gray-400 mr-4 mt-1"></i>
                            <span>Can I become a volunteer repairer?</span>
                        </h3>
                        <p class="text-gray-600 leading-relaxed pl-10">
                            Absolutely! We're always looking for people with repair skills to join our team. Whether you're a professional or an experienced hobbyist, if you have skills in electronics, mechanics, textiles, or general repairs, we'd love to hear from you. You don't need to commit to every session - even helping out occasionally makes a big difference. It's a great way to share your knowledge, meet like-minded people, and contribute to reducing waste in our community. Please register on our website and let us know what skills you can donate, or contact us for more information.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="relative bg-gray-300 mt-12 pt-8 pb-6">
            <div class="bottom-auto top-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden -mt-20"
                style="height: 80px;">
                <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg"
                    preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                    <polygon class="text-gray-300 fill-current" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap">
                    <div class="w-full md:w-6/12 px-4">
                        <h4 class="text-3xl font-semibold">Let's keep in touch!</h4>
                        <h5 class="text-lg mt-0 mb-2 text-gray-700">
                            Find us on social media.
                        </h5>
                        <div class="mt-6 flex">
                            <a href="https://www.facebook.com/groups/repaircafelb"
                                class="bg-white text-blue-600 shadow-lg font-normal h-10 w-10 flex items-center justify-center rounded-full outline-none focus:outline-none mr-2"
                                type="button">
                                <i class="fab fa-facebook"></i>
                            </a>
                        </div>
                    </div>
                    <div class="w-full md:w-6/12 px-4">
                        <div class="flex flex-wrap items-top mb-6">
                            <div class="w-full md:w-6/12 px-4 ml-auto">
                                <span class="block uppercase text-gray-600 text-sm font-semibold mb-2">Find out more</span>
                                <ul class="list-unstyled [&>li>a]:text-gray-700 [&>li>a]:hover:text-gray-900 [&>li>a]:font-semibold [&>li>a]:block [&>li>a]:pb-2 [&>li>a]:text-sm">                                    
                                    <li><a href="/privacy-policy">Privacy Policy</a></li>
                                    <li><a href="health-and-safety">Health &amp; Safety Policy</a></li>
                                    <li><a href="volunteer-policy">Volunteer Policy</a></li>
                                    <li><a href="repair-disclaimer">Repair Disclaimer</a></li>
                                    <li><a href="/contact">Contact Us</a></li>
                                </ul>
                            </div>
                            <div class="w-full md:w-6/12 px-4">
                                <span class="block uppercase text-gray-600 text-sm font-semibold mb-2">Helpful Links</span>
                                <ul class="list-unstyled [&>li>a]:text-gray-700 [&>li>a]:hover:text-gray-900 [&>li>a]:font-semibold [&>li>a]:block [&>li>a]:pb-2 [&>li>a]:text-sm">
                                    <li><a href="https://totallylb.wordpress.com">Totally Leighton Buzzard</a></li>
                                    <li><a href="https://www.repaircafe.org/en/">Repair Cafe movement</a></li>
                                    <li><a href="https://restarters.net/group/view/821">Restarters group</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </body>
</html>

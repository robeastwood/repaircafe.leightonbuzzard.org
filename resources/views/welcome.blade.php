<x-guest-layout>
    <div class="relative pt-16 pb-32 flex content-center items-center justify-center" style="min-height: 75vh">
        <div class="absolute top-0 w-full h-full bg-center bg-cover"
            style="
                    background-image: url('https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=1267&amp;q=80');
                ">
            <span id="blackOverlay" class="w-full h-full absolute opacity-75 bg-black"></span>
        </div>
        <div class="container relative mx-auto">
            <div class="items-center flex flex-wrap">
                <div class="w-full lg:w-8/12 px-4 ml-auto mr-auto text-center">
                    <div>
                        <x-jet-application-mark class="ml-auto mr-auto w-64 h-64 text-white" />
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

                    @if ($nextEvent)
                        <h2 class="text-xl text-gray-100 dark:text-white my-2">
                            Our next Repair Cafe event is:
                        </h2>
                        <livewire:event-card :event="$nextEvent">
                        @else
                            <h2 class="text-xl text-gray-100 dark:text-white my-2">
                                Check back soon for details of the next event!
                            </h2>
                    @endif

                </div>
            </div>
        </div>
        <div class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden"
            style="height: 70px">
            <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"
                version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                <polygon class="text-gray-300 fill-current" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>
    <section class="pb-20 bg-gray-300 -mt-24">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap">
                <div class="pt-6 pt-6 w-full md:w-4/12 px-4 text-center">
                    <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg">
                        <div class="px-4 py-5 flex-auto">
                            <div
                                class="text-white p-3 text-center inline-flex items-center justify-center w-20 h-20 mb-5 shadow-lg rounded-full bg-yellow-400">
                                <i class="fas fa-2xl fa-gbp"></i>
                            </div>
                            <h6 class="text-xl font-semibold">
                                Save Money
                            </h6>
                            <p class="mt-2 mb-4 text-gray-600">
                                We're all looking for ways to save money these days. Many household items are replaced
                                unnecessarily because of a minor issue that could be
                                easily repaired for free, or for a fraction of the cost of a replacement.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-4/12 px-4 text-center">
                    <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg">
                        <div class="px-4 py-5 flex-auto">
                            <div
                                class="text-white p-3 text-center inline-flex items-center justify-center w-20 h-20 mb-5 shadow-lg rounded-full bg-green-400">
                                <i class="fas fa-2xl fa-recycle"></i>
                            </div>
                            <h6 class="text-xl font-semibold">
                                Reduce Waste
                            </h6>
                            <p class="mt-2 mb-4 text-gray-600">
                                It is estimated that on average an item of clothing lasts 3.3 years and around 300,000
                                tonnes a year are sent to landfill in the UK, and on average we each throw away 23.9kg
                                of Electronic waste (or e-waste) per year. The UK is set to become the world's
                                largest e-waste producer by 2024. We should do all we can to limit the effects of our
                                throwaway society.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="pt-6 w-full md:w-4/12 px-4 text-center">
                    <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg">
                        <div class="px-4 py-5 flex-auto">
                            <div
                                class="text-white p-3 text-center inline-flex items-center justify-center w-20 h-20 mb-5 shadow-lg rounded-full bg-pink-400">
                                <i class="fas fa-2xl fa-brain"></i>
                            </div>
                            <h6 class="text-xl font-semibold">
                                Learn New Skills
                            </h6>
                            <p class="mt-2 mb-4 text-gray-600">
                                A repair cafe is all about sharing the skills needed to maintain and repair household
                                goods - it's amazing how much you can fix with just a few tips, tricks and confidence.
                                On the other hand, if you've a fix-it mentality, come along to see if you can help out
                                others in your community and share your knowledge!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap mt-10">
                <div class="w-full md:w-5/12 px-4 mr-auto ml-auto">
                    <div
                        class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded-lg bg-pink-600">
                        <img alt="..." src="./img/repair_cafe.jpg" class="w-full align-middle rounded-t-lg" />
                        <blockquote class="relative p-8 mb-4">
                            <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 583 95"
                                class="absolute left-0 w-full block" style="height: 95px; top: -94px">
                                <polygon points="-30,95 583,95 583,65" class="text-pink-600 fill-current"></polygon>
                            </svg>
                            <h4 class="text-xl font-bold text-white">
                                What is a Repair Café?
                            </h4>
                            <p class="text-md font-light mt-2 text-white">
                                They are above-all pop-up community events that match people who need stuff fixed with
                                people who like to fix things. A key principle of a Repair Café is that you sit with the
                                repairer whilst they attempt to carry out the repair, so that you learn more about the
                                item and the repair process.
                            </p>
                        </blockquote>
                    </div>
                </div>
                <div class="w-full md:w-7/12 px-4 mr-auto ml-auto">
                    <p class="text-2xl text-light leading-relaxed mt-4 mb-4 text-gray-700">
                        <a href="https://totallylocallyleightonbuzzard.wordpress.com/">Totally Leighton Buzzard</a> are
                        planning to host monthly Repair Café events in our town. We bring the cake! You bring your
                        items! Everyone brings a willingness to share and learn!
                    </p>
                    <h3 class="text-3xl mt-4 mb-2 font-semibold leading-normal">
                        Why are we organising a Repair Café?
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
    <section class="relative py-20">
        <div class="bottom-auto top-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden -mt-20"
            style="height: 80px">
            <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg"
                preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                <polygon class="text-white fill-current" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
        <div class="container mx-auto px-4">
            <div class="items-center flex flex-wrap">
                <div class="w-full md:w-8/12 ml-auto mr-auto px-4">
                    <div class="md:pr-12">
                        <div
                            class="text-pink-600 p-3 text-center inline-flex items-center justify-center w-16 h-16 mb-6 shadow-lg rounded-full bg-pink-300">
                            <i class="fas fa-wrench text-xl"></i>
                        </div>
                        <h3 class="text-3xl font-semibold">
                            FAQ
                        </h3>
                        <ul class="list-none mt-6">
                            <li class="py-2">
                                <div class="flex items-center">
                                    <div>
                                        <span
                                            class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-pink-600 bg-pink-200 mr-3">
                                            <i class="fas fa-question"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <h4 class="text-xl text-gray-600">
                                            What is the cost of attending the Repair Café?
                                        </h4>
                                    </div>
                                </div>
                                <p class="mt-4 text-lg leading-relaxed text-gray-600">
                                    Attendance to the repair café is free, but we would gladly accept donations towards
                                    our costs. We are a non-profit community group, and Repair Cafés
                                    work on the basis of donations which are welcome to cover the cost of venue hire,
                                    insurance costs, training and general supplies and tools.
                                </p>
                                <p class="mt-4 text-lg leading-relaxed text-gray-600">
                                    You will be expected to cover the cost of any parts needed (if required) to complete
                                    a repair of your item. In this case, the repairer will attmept to provide you
                                    with the exact part numbers, approximate costs, and suitable suppliers.
                                </p>
                                <p class="mt-4 text-lg leading-relaxed text-gray-600">
                                    Once you have purchased the part(s), you're welcome to return to another repair
                                    café session with the item and the part so your repair can be completed.
                                </p>
                            </li>
                            <li class="py-2">
                                <div class="flex items-center">
                                    <div>
                                        <span
                                            class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-pink-600 bg-pink-200 mr-3">
                                            <i class="fas fa-question"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <h4 class="text-xl text-gray-600">
                                            How can I book to attend the Repair Café?
                                        </h4>
                                    </div>
                                </div>
                                <p class="mt-4 text-lg leading-relaxed text-gray-600">
                                    It is really helpful for our repairers to have some idea of the nature and condition
                                    of the item. Please provide as much information
                                    as possible about what the item is and what might be wrong with the item. We will
                                    try to have a combination of both pre-booked and
                                    walk-in slots.
                                </p>
                                <p class="mt-4 text-lg leading-relaxed text-gray-600">
                                    Please <a href="{{ route('register') }}">register here</a> and put your name down
                                    to attend one of the upcoming events.
                                </p>
                            </li>
                            <li class="py-2">
                                <div class="flex items-center">
                                    <div>
                                        <span
                                            class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-pink-600 bg-pink-200 mr-3">
                                            <i class="fas fa-question"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <h4 class="text-xl text-gray-600">
                                            How does it work on the day?
                                        </h4>
                                    </div>
                                </div>
                                <p class="mt-4 text-lg leading-relaxed text-gray-600">
                                    Depending on the time that you attend and the number of volunteer repairers
                                    available at that time, there could be a short wait before a relevant
                                    repairer is available. Please use this opportunity to buy a drink or some cake and
                                    have a chat with others.</p>
                                <p class="mt-4 text-lg leading-relaxed text-gray-600">
                                    You will also be required to sign a disclaimer if you have not already done so
                                    online.
                                </p>
                                <p class="mt-4 text-lg leading-relaxed text-gray-600">
                                    When a relevant repairer is available, you are encouraged to sit with them, watch
                                    the repair and ask questions
                                    (and even assist, if you can). Repair Cafés are essentially about sharing skills and
                                    knowledge.
                                </p>
                                <p class="mt-4 text-lg leading-relaxed text-gray-600">
                                    If your item is not repairable, the repairer will explain the reasons and offer info
                                    on the safest and easiest way to dispose of the item.<br />
                                    We cannot dispose of items that are unrepairable although we might be able to use
                                    some items for small parts in future repairs (but this might happen
                                    on case by case basis).
                                </p>
                            </li>
                            <li class="py-2">
                                <div class="flex items-center">
                                    <div>
                                        <span
                                            class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-pink-600 bg-pink-200 mr-3">
                                            <i class="fas fa-question"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <h4 class="text-xl text-gray-600">
                                            Who are our repairers and can I become a volunteer?
                                        </h4>
                                    </div>
                                </div>
                                <p class="mt-4 text-lg leading-relaxed text-gray-600">
                                    Repair Café Leighton Buzzard volunteers are mixture of people who want to help. Most
                                    are amateurs and others have professional repair expertise,
                                    while others provide equally welcome support skills front of house.<br />Please
                                    speak to one of the team if you are interested in volunteering either
                                    as a fixer or doing admin/front of house activities. Every little helps!
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="w-full md:w-4/12 ml-auto mr-auto px-4">
                    <img alt="Spanner" class="max-w-full rounded-lg shadow-lg"
                        src="https://images.unsplash.com/photo-1611288875785-f62fb9b044a7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=697&q=80" />
                </div>
            </div>
        </div>
    </section>
    <!--
        <section class="pt-20 pb-48">
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap justify-center text-center mb-24">
                    <div class="w-full lg:w-6/12 px-4">
                        <h2 class="text-4xl font-semibold">
                            Here are our heroes
                        </h2>
                        <p class="text-lg leading-relaxed m-4 text-gray-600">
                            According to the National Oceanic and Atmospheric
                            Administration, Ted, Scambos, NSIDClead scentist,
                            puts the potentially record maximum.
                        </p>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <div class="w-full md:w-6/12 lg:w-3/12 lg:mb-0 mb-12 px-4">
                        <div class="px-6">
                            <img
                                alt="..."
                                src="./img/team-1-800x800.jpg"
                                class="shadow-lg rounded-full max-w-full mx-auto"
                                style="max-width: 120px"
                            />
                            <div class="pt-6 text-center">
                                <h5 class="text-xl font-bold">Ryan Tompson</h5>
                                <p
                                    class="mt-1 text-sm text-gray-500 uppercase font-semibold"
                                >
                                    Web Developer
                                </p>
                                <div class="mt-6">
                                    <button
                                        class="bg-blue-400 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                                        type="button"
                                    >
                                        <i class="fab fa-twitter"></i></button
                                    ><button
                                        class="bg-blue-600 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                                        type="button"
                                    >
                                        <i
                                            class="fab fa-facebook-f"
                                        ></i></button
                                    ><button
                                        class="bg-pink-500 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                                        type="button"
                                    >
                                        <i class="fab fa-dribbble"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-6/12 lg:w-3/12 lg:mb-0 mb-12 px-4">
                        <div class="px-6">
                            <img
                                alt="..."
                                src="./img/team-2-800x800.jpg"
                                class="shadow-lg rounded-full max-w-full mx-auto"
                                style="max-width: 120px"
                            />
                            <div class="pt-6 text-center">
                                <h5 class="text-xl font-bold">Romina Hadid</h5>
                                <p
                                    class="mt-1 text-sm text-gray-500 uppercase font-semibold"
                                >
                                    Marketing Specialist
                                </p>
                                <div class="mt-6">
                                    <button
                                        class="bg-red-600 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                                        type="button"
                                    >
                                        <i class="fab fa-google"></i></button
                                    ><button
                                        class="bg-blue-600 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                                        type="button"
                                    >
                                        <i class="fab fa-facebook-f"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-6/12 lg:w-3/12 lg:mb-0 mb-12 px-4">
                        <div class="px-6">
                            <img
                                alt="..."
                                src="./img/team-3-800x800.jpg"
                                class="shadow-lg rounded-full max-w-full mx-auto"
                                style="max-width: 120px"
                            />
                            <div class="pt-6 text-center">
                                <h5 class="text-xl font-bold">Alexa Smith</h5>
                                <p
                                    class="mt-1 text-sm text-gray-500 uppercase font-semibold"
                                >
                                    UI/UX Designer
                                </p>
                                <div class="mt-6">
                                    <button
                                        class="bg-red-600 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                                        type="button"
                                    >
                                        <i class="fab fa-google"></i></button
                                    ><button
                                        class="bg-blue-400 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                                        type="button"
                                    >
                                        <i class="fab fa-twitter"></i></button
                                    ><button
                                        class="bg-gray-800 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                                        type="button"
                                    >
                                        <i class="fab fa-instagram"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-6/12 lg:w-3/12 lg:mb-0 mb-12 px-4">
                        <div class="px-6">
                            <img
                                alt="..."
                                src="./img/team-4-470x470.png"
                                class="shadow-lg rounded-full max-w-full mx-auto"
                                style="max-width: 120px"
                            />
                            <div class="pt-6 text-center">
                                <h5 class="text-xl font-bold">Jenna Kardi</h5>
                                <p
                                    class="mt-1 text-sm text-gray-500 uppercase font-semibold"
                                >
                                    Founder and CEO
                                </p>
                                <div class="mt-6">
                                    <button
                                        class="bg-pink-500 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                                        type="button"
                                    >
                                        <i class="fab fa-dribbble"></i></button
                                    ><button
                                        class="bg-red-600 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                                        type="button"
                                    >
                                        <i class="fab fa-google"></i></button
                                    ><button
                                        class="bg-blue-400 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                                        type="button"
                                    >
                                        <i class="fab fa-twitter"></i></button
                                    ><button
                                        class="bg-gray-800 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                                        type="button"
                                    >
                                        <i class="fab fa-instagram"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="pb-20 relative block bg-gray-900">
            <div
                class="bottom-auto top-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden -mt-20"
                style="height: 80px"
            >
                <svg
                    class="absolute bottom-0 overflow-hidden"
                    xmlns="http://www.w3.org/2000/svg"
                    preserveAspectRatio="none"
                    version="1.1"
                    viewBox="0 0 2560 100"
                    x="0"
                    y="0"
                >
                    <polygon
                        class="text-gray-900 fill-current"
                        points="2560 0 2560 100 0 100"
                    ></polygon>
                </svg>
            </div>
            <div class="container mx-auto px-4 lg:pt-24 lg:pb-64">
                <div class="flex flex-wrap text-center justify-center">
                    <div class="w-full lg:w-6/12 px-4">
                        <h2 class="text-4xl font-semibold text-white">
                            Build something
                        </h2>
                        <p
                            class="text-lg leading-relaxed mt-4 mb-4 text-gray-500"
                        >
                            Put the potentially record low maximum sea ice
                            extent tihs year down to low ice. According to the
                            National Oceanic and Atmospheric Administration,
                            Ted, Scambos.
                        </p>
                    </div>
                </div>
                <div class="flex flex-wrap mt-12 justify-center">
                    <div class="w-full lg:w-3/12 px-4 text-center">
                        <div
                            class="text-gray-900 p-3 w-12 h-12 shadow-lg rounded-full bg-white inline-flex items-center justify-center"
                        >
                            <i class="fas fa-medal text-xl"></i>
                        </div>
                        <h6 class="text-xl mt-5 font-semibold text-white">
                            Excelent Services
                        </h6>
                        <p class="mt-2 mb-4 text-gray-500">
                            Some quick example text to build on the card title
                            and make up the bulk of the card's content.
                        </p>
                    </div>
                    <div class="w-full lg:w-3/12 px-4 text-center">
                        <div
                            class="text-gray-900 p-3 w-12 h-12 shadow-lg rounded-full bg-white inline-flex items-center justify-center"
                        >
                            <i class="fas fa-poll text-xl"></i>
                        </div>
                        <h5 class="text-xl mt-5 font-semibold text-white">
                            Grow your market
                        </h5>
                        <p class="mt-2 mb-4 text-gray-500">
                            Some quick example text to build on the card title
                            and make up the bulk of the card's content.
                        </p>
                    </div>
                    <div class="w-full lg:w-3/12 px-4 text-center">
                        <div
                            class="text-gray-900 p-3 w-12 h-12 shadow-lg rounded-full bg-white inline-flex items-center justify-center"
                        >
                            <i class="fas fa-lightbulb text-xl"></i>
                        </div>
                        <h5 class="text-xl mt-5 font-semibold text-white">
                            Launch time
                        </h5>
                        <p class="mt-2 mb-4 text-gray-500">
                            Some quick example text to build on the card title
                            and make up the bulk of the card's content.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <section class="relative block py-24 lg:pt-0 bg-gray-900 pb-20">
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap justify-center lg:-mt-64 -mt-48">
                    <div class="w-full lg:w-6/12 px-4">
                        <div
                            class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-gray-300"
                        >
                            <div class="flex-auto p-5 lg:p-10">
                                <h4 class="text-2xl font-semibold">
                                    Want to work with us?
                                </h4>
                                <p
                                    class="leading-relaxed mt-1 mb-4 text-gray-600"
                                >
                                    Complete this form and we will get back to
                                    you in 24 hours.
                                </p>
                                <div class="relative w-full mb-3 mt-8">
                                    <label
                                        class="block uppercase text-gray-700 text-xs font-bold mb-2"
                                        for="full-name"
                                        >Full Name</label
                                    ><input
                                        type="text"
                                        class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full"
                                        placeholder="Full Name"
                                        style="transition: all 0.15s ease 0s"
                                    />
                                </div>
                                <div class="relative w-full mb-3">
                                    <label
                                        class="block uppercase text-gray-700 text-xs font-bold mb-2"
                                        for="email"
                                        >Email</label
                                    ><input
                                        type="email"
                                        class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full"
                                        placeholder="Email"
                                        style="transition: all 0.15s ease 0s"
                                    />
                                </div>
                                <div class="relative w-full mb-3">
                                    <label
                                        class="block uppercase text-gray-700 text-xs font-bold mb-2"
                                        for="message"
                                        >Message</label
                                    ><textarea rows="4" cols="80"
                                        class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full"
                                        placeholder="Type a message..."></textarea>
                                </div>
                                <div class="text-center mt-6">
                                    <button
                                        class="bg-gray-900 text-white active:bg-gray-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1"
                                        type="button"
                                        style="transition: all 0.15s ease 0s"
                                    >
                                        Send Message
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        -->
</x-guest-layout>

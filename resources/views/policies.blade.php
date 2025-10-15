<x-layouts.public title="Policies">
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
                        Our Policies
                    </h1>
                    <p class="mt-4 text-lg text-gray-300">
                        Important policies and procedures for our Repair Café
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <section class="py-12 -mt-20 relative z-10">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto space-y-6">

                <!-- Privacy Policy -->
                <div class="relative flex flex-col min-w-0 break-words bg-white w-full shadow-lg rounded-2xl backdrop-blur-sm bg-white/90 p-8">
                    <button onclick="togglePolicy('privacy')" class="flex items-center justify-between w-full text-left hover:opacity-80 transition-opacity cursor-pointer">
                        <div class="flex items-center">
                            <div class="text-white p-3 inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-blue-500 mr-4">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h2 class="text-3xl font-semibold text-gray-800">
                                Privacy Policy
                            </h2>
                        </div>
                        <div class="ml-4">
                            <i id="privacy-icon" class="fas fa-chevron-down transition-transform duration-200"></i>
                        </div>
                    </button>

                    <p id="privacy-summary" class="text-gray-600 mt-4 text-sm leading-relaxed">
                        How we collect, use, and protect your personal information in accordance with UK GDPR.
                    </p>

                    <div id="privacy-content" class="text-gray-700 space-y-4 mt-6 hidden">
                        <p class="leading-relaxed">
                            In accordance with the UK's General Data Protection Regulation (UK GDPR and other relevant legislation) and as a responsible local community group, Totally Leighton Buzzard is committed to protecting your privacy and to making sure all your personal information is handled in a safe and responsible way.
                        </p>
                        <p class="leading-relaxed">
                            This policy explains more about why we need or hold your data, our purpose in holding personal data and what your rights are and how we aim to adhere to excellent data protection principles as a community group.
                        </p>

                        <h3 class="text-xl font-semibold text-gray-800 mt-6">Definition of Personal Data</h3>
                        <p class="leading-relaxed">
                            Personal Data means any information that can be used to identify a person -- such as name, address, telephone number etc. By providing your personal data, you agree that we can use it in accordance with this policy. Please make sure you take time to read our policy and understand it.
                        </p>

                        <h3 class="text-xl font-semibold text-gray-800 mt-6">Who we are</h3>
                        <p class="leading-relaxed">
                            Totally Leighton Buzzard (including the Repair Cafe Leighton Buzzard)<br>
                            Email: totallylocallyleightonbuzzard@outlook.com
                        </p>

                        <h3 class="text-xl font-semibold text-gray-800 mt-6">When and what information we collect</h3>
                        <p class="leading-relaxed">
                            You provide personal information such as your name and email address when you either email, make an online enquiry or booking to attend one of our Repair Café events or one of our other community events such as Fun Palaces.
                        </p>
                        <p class="leading-relaxed">
                            We also collect personal information if you want to become a volunteer.
                        </p>
                        <p class="leading-relaxed">
                            We will only collect, store and use the minimum amount of data that we need for clear purposes, and will not collect, store or use data that we do not need.
                        </p>
                        <p class="leading-relaxed">
                            We will only collect, store and use data for:
                        </p>
                        <ul class="list-disc list-inside space-y-2 pl-4">
                            <li>Purposes for which an individual has given explicit consent, or</li>
                            <li>Purposes that are in our group's legitimate interests, or</li>
                            <li>To protect someone's life, or</li>
                            <li>To comply with legal obligations</li>
                        </ul>
                        <p class="leading-relaxed">
                            Your information may be stored securely on a third party website (ie Google Drive) for administration purposes, such as issuing of a newsletter or to advise you of group activities.
                        </p>
                        <p class="leading-relaxed">
                            Your information is never shared or passed on to any other third party groups, organisations or individuals without your consent.
                        </p>

                        <h3 class="text-xl font-semibold text-gray-800 mt-6">How your information is used</h3>
                        <p class="leading-relaxed">
                            Our use of your personal data will always have a lawful basis. Your data will be used because you have consented to our use of your personal data and because it is in our legitimate interests.
                        </p>
                        <p class="leading-relaxed">
                            We require your details to understand and respond to your enquiry, to provide you with a prompt and reliable service, and to send marketing communications and/or newsletters when they become available and if you have opted in to receive them.
                        </p>

                        <h3 class="text-xl font-semibold text-gray-800 mt-6">Who has access to your information?</h3>
                        <p class="leading-relaxed">
                            We will not sell, distribute, or lease your personal information to third parties. Any personal information we request will be safeguarded under current legislation.
                        </p>
                        <p class="leading-relaxed">
                            Your personal data will be kept for as long as it is needed in order to use it as described in this privacy policy, and/or for as long as we have your permission to keep it. Personal data can be deleted on request.
                        </p>

                        <h3 class="text-xl font-semibold text-gray-800 mt-6">Your choices</h3>
                        <p class="leading-relaxed">
                            You have a choice about whether or not you wish to receive information from us. We will not contact you for marketing purposes by email unless you have given your prior consent. We will not pass your details to any third parties for marketing purposes. Also, you can change your marketing preferences at any time by contacting us by email.
                        </p>
                        <p class="leading-relaxed">
                            You have a right to request a copy of the personal information we hold about you and have any inaccuracies corrected. Any such requests should be made via email.
                        </p>
                        <p class="leading-relaxed">
                            To withdraw your consent to us using your personal data at any time, and to request that we delete it, please email the group.
                        </p>
                        <p class="leading-relaxed">
                            We will not keep your personal data for any longer than is necessary.
                        </p>

                        <h3 class="text-xl font-semibold text-gray-800 mt-6">Security</h3>
                        <p class="leading-relaxed">
                            Data security is very important to us. We have taken suitable measures to safeguard and secure data collected, such as ensuring that any computers used by the group are password protected.
                        </p>
                        <p class="leading-relaxed">
                            We will endeavour not to have data breaches. In the event of a data breach, we will endeavour to rectify the breach by getting any lost or shared data back. We will evaluate our processes and understand how to avoid it happening again. Serious data breaches which may risk someone's personal rights or freedoms will be reported to the Information Commissioner's Office within 72 hours, and to the individual concerned.
                        </p>

                        <h3 class="text-xl font-semibold text-gray-800 mt-6">Review of this policy</h3>
                        <p class="leading-relaxed">
                            We keep this policy under regular review and always welcome your comments. If you have concerns about this our privacy policy or believe that Totally Leighton Buzzard has not adhered to this policy, please contact us and we will take reasonable efforts to promptly determine and remedy any issue.
                        </p>

                        <p class="leading-relaxed mt-6 text-sm italic text-gray-600">
                            Totally Leighton Buzzard - 9 February 2023
                        </p>

                    </div>
                </div>

                <!-- Health & Safety Policy -->
                <div class="relative flex flex-col min-w-0 break-words bg-white w-full shadow-lg rounded-2xl backdrop-blur-sm bg-white/90 p-8">
                    <button onclick="togglePolicy('health')" class="flex items-center justify-between w-full text-left hover:opacity-80 transition-opacity cursor-pointer">
                        <div class="flex items-center">
                            <div class="text-white p-3 inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-red-500 mr-4">
                                <i class="fas fa-hard-hat"></i>
                            </div>
                            <h2 class="text-3xl font-semibold text-gray-800">
                                Health &amp; Safety Policy
                            </h2>
                        </div>
                        <div class="ml-4">
                            <i id="health-icon" class="fas fa-chevron-down transition-transform duration-200"></i>
                        </div>
                    </button>

                    <p id="health-summary" class="text-gray-600 mt-4 text-sm leading-relaxed">
                        Our commitment to ensuring a safe environment for all volunteers and visitors. This covers our safe handling procedures, first aid, and emergency protocols.
                    </p>

                    <div id="health-content" class="text-gray-700 space-y-4 mt-6 hidden">
                        <h3 class="text-xl font-semibold text-gray-800 mt-6">Mission Statement</h3>
                        <p class="leading-relaxed">
                            Totally Leighton Buzzard and the Repair Café Leighton Buzzard is committed to providing a safe repair cafe event.
                        </p>
                        <p class="leading-relaxed">
                            This Health and Safety Policy demonstrates our commitment to our volunteers and visitors.
                        </p>
                        <p class="leading-relaxed">
                            You should also refer to our Disclaimer and this should be signed and dated before any repair work is conducted.
                        </p>

                        <h3 class="text-xl font-semibold text-gray-800 mt-6">Introduction</h3>

                        <h4 class="text-lg font-semibold text-gray-800 mt-4">The Set-up</h4>
                        <ul class="list-disc list-inside space-y-2 pl-4">
                            <li>Extension leads must be taped to the floor (where possible) and kept out of the flow of foot traffic.</li>
                            <li>Check with the hosts of a Restart Party before soldering. Ventilation is an issue in some venues.</li>
                            <li>Hosts or the designated safety volunteer will locate and draw your attention to fire extinguishers and fire exits. If you miss this announcement, please inform yourself.</li>
                            <li>A first aider will be identified as such when present.</li>
                        </ul>

                        <h4 class="text-lg font-semibold text-gray-800 mt-4">Basics</h4>
                        <ul class="list-disc list-inside space-y-2 pl-4">
                            <li>Children must be accompanied at all times by their guardians and kept an appropriate distance from chemicals, soldering and dangerous tools.</li>
                            <li>When using blades or sharp instruments, always cut away from your body, and we recommend you use gloves.</li>
                            <li>Be mindful when opening a device or using any force as bits may go flying (into someone's eye). If this is a risk, ask for eye protection and/or move away from others.</li>
                            <li>Careful with drinks! Do not consume spillable drinks at repair tables.</li>
                        </ul>

                        <h4 class="text-lg font-semibold text-gray-800 mt-4">Electricity</h4>
                        <ul class="list-disc list-inside space-y-2 pl-4">
                            <li>If you have any doubts or questions, find the host who will call over a designated safety volunteer</li>
                            <li>All mains-operated devices must be PAT tested before you start a repair and on completion.</li>
                            <li>We do not repair a component of a device unless we are able to safety test the full device on the spot</li>
                            <li>Only repair mains equipment if you are competent to do so. To plug in a mains appliance, use an RCD or a dedicated mains isolating transformer. Use insulated tools.</li>
                            <li>Beware of stored high voltage in capacitors, even a very long time after a device has been disconnected from the mains. Always test if they are charged with a voltmeter. If they are charged and you are not experienced in discharging them do not progress with the repair.</li>
                            <li>Put the device back together before testing it under mains power. If you have to test device while it is both plugged in to the power network and dismantled, only do so with a second Restarter present.</li>
                            <li>If you smell burning immediately unplug at the power plug and then assess the problem with our designated safety volunteer.</li>
                            <li>Beware of rechargeable batteries. If shorted or abused, they can be toxic and a fire risk.</li>
                            <li>We usually do not repair power tools or high-wattage electricals. We can make exceptions, but they will be assigned by hosts to experienced volunteers. If in doubt, ask a host.</li>
                            <li>For any old electrical device, always check that the wiring in the mains plug is to good standards.</li>
                            <li>If a device has been shorting out electrical circuits, connect the device only after being certain you have found and corrected the problem.</li>
                        </ul>

                        <h4 class="text-lg font-semibold text-gray-800 mt-4">Using cans and chemicals</h4>
                        <ul class="list-disc list-inside space-y-2 pl-4">
                            <li>Keep them away from any flame or direct sunlight.</li>
                            <li>Do not spray flammable or volatile liquid on a live circuit or close to a soldering iron.</li>
                            <li>Keep chemicals such as solvents far away from other people, especially children.</li>
                        </ul>

                        <p class="leading-relaxed mt-6 text-sm italic text-gray-600">
                            Totally Leighton Buzzard - 14 March 2023
                        </p>
                    </div>
                </div>

                <!-- Volunteer Policy -->
                <div class="relative flex flex-col min-w-0 break-words bg-white w-full shadow-lg rounded-2xl backdrop-blur-sm bg-white/90 p-8">
                    <button onclick="togglePolicy('volunteer')" class="flex items-center justify-between w-full text-left hover:opacity-80 transition-opacity cursor-pointer">
                        <div class="flex items-center">
                            <div class="text-white p-3 inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-green-500 mr-4">
                                <i class="fas fa-hands-helping"></i>
                            </div>
                            <h2 class="text-3xl font-semibold text-gray-800">
                                Volunteer Policy
                            </h2>
                        </div>
                        <div class="ml-4">
                            <i id="volunteer-icon" class="fas fa-chevron-down transition-transform duration-200"></i>
                        </div>
                    </button>

                    <p id="volunteer-summary" class="text-gray-600 mt-4 text-sm leading-relaxed">
                        Information for our valued volunteers about roles, responsibilities, training, and support. Click to read about what to expect when volunteering with us.
                    </p>

                    <div id="volunteer-content" class="text-gray-700 space-y-4 mt-6 hidden">
                        <h3 class="text-xl font-semibold text-gray-800 mt-6">Mission Statement</h3>
                        <p class="leading-relaxed">
                            Totally Leighton Buzzard and the Repair Café Leighton Buzzard is committed to providing a high quality, dependable and transparent advice and repair service to all our visitors. Everyone is welcome and we endeavour to ensure that all volunteers and visitors enjoy the best possible Repair Café experience.
                        </p>
                        <p class="leading-relaxed">
                            This Volunteer Policy demonstrates our commitment to our volunteers, our consistency in our decision-making process and information on how volunteers can expect to be treated in their roles.
                        </p>

                        <h3 class="text-xl font-semibold text-gray-800 mt-6">Introduction</h3>
                        <p class="leading-relaxed">
                            The Repair Café Leighton Buzzard is a volunteer-led community project that offers a range of social, environmental and economic benefits to its local community. Our main aim is to enable the repairing of a personal or household possession instead of throwing it away. We offer a social meeting place where people of all ages and backgrounds can bring their damaged, broken or torn possessions to be repaired. This means we recognise and value those who have a wide range of hands-on practical and interpersonal skills and rely on a committed team of volunteers to deliver and maintain a high-quality and reliable repair and advice service. There is no charge but visitors are welcome to leave a donation.
                        </p>

                        <h3 class="text-xl font-semibold text-gray-800 mt-6">Recruitment</h3>
                        <p class="leading-relaxed">
                            Volunteers are recruited by word of mouth, by the publicity we send out and our website, or as the result of visiting the Repair Café. New volunteers are invited to visit an event and asked to complete a Volunteer Application form giving their contact details, information on the skills they can offer and the reason they wish to volunteer. They are also asked to disclose any serious health issues and to complete an Emergency Contact form.
                        </p>
                        <p class="leading-relaxed">
                            We do not carry out DBS checks or take up references. We may ask volunteers to assist a more experienced member at their first session, or at any time if they need more support.
                        </p>

                        <h3 class="text-xl font-semibold text-gray-800 mt-6">Induction and Training</h3>
                        <p class="leading-relaxed">
                            A full explanation of how a repair café session operates is given at the pre-repair café meeting. We ask volunteers, particularly non-repairers, what role they would like. Every effort is made to ensure that volunteers are happy and comfortable with what is being asked of them.
                        </p>
                        <p class="leading-relaxed">
                            Repairers are not required to show proof of their professional qualifications and/or training but they should only attempt repairs for which they have the necessary skills, competence and expertise. Repairers are encouraged to work together and learn from each other and to involve visitors wherever possible.
                        </p>

                        <h3 class="text-xl font-semibold text-gray-800 mt-6">Equal Opportunities and Diversity</h3>
                        <p class="leading-relaxed">
                            Totally Leighton Buzzard is committed to the promotion of equal opportunities through the way we manage the group and run events. No person should suffer or experience less favourable treatment, discrimination or lack of opportunities on any of the grounds set out in the Equality Act 2010. We welcome volunteers and visitors from diverse backgrounds.
                        </p>

                        <h3 class="text-xl font-semibold text-gray-800 mt-6">Health and Safety</h3>
                        <p class="leading-relaxed">
                            Totally Leighton Buzzard accepts that it has a duty of care to avoid exposing our volunteers to any risks which may affect their health, safety and well-being. The Emergency Contact form completed by all volunteers names a relative or friend who can be contacted in the event of an emergency. A Risk Assessment covering the normal activities undertaken at Repair Café sessions is available to all volunteers on request. This is reviewed and updated on an annual basis.
                        </p>
                        <p class="leading-relaxed">
                            All volunteers are expected to take responsibility for their own health and safety whilst on the premises and follow the correct safety procedures when fulfilling their Repair Café roles.
                        </p>

                        <h3 class="text-xl font-semibold text-gray-800 mt-6">Insurance</h3>
                        <p class="leading-relaxed">
                            In addition to the Public Liability insurance provided at the current venue, Totally Leighton Buzzard has additional public liability insurance to cover all the higher risk activities listed in the Risk Assessment.
                        </p>

                        <h3 class="text-xl font-semibold text-gray-800 mt-6">Confidentiality</h3>
                        <p class="leading-relaxed">
                            Unless notified to the contrary, it is assumed that volunteers are happy that their personal email addresses and optional contact phone number are shared with the Repair Cafe organising team. These details are not shared with other volunteers or Repair Cafe visitors.
                        </p>
                        <p class="leading-relaxed">
                            Volunteers are asked to provide their email address when completing the Repair Cafe registration form so that they can be informed about future Repair Café events. Reminder messages about Repair Café events will be sent via email, which can be unsubscribed from at any point.
                        </p>
                        <p class="leading-relaxed">
                            Volunteers are asked to provide their phone number if they wish to receive SMS or calls in case of urgent updates, for example a repair cafe event being cancelled at short notice.
                        </p>

                        <h3 class="text-xl font-semibold text-gray-800 mt-6">Expenses</h3>
                        <p class="leading-relaxed">
                            No volunteer should ever be out-of-pocket and reimbursement of any purchases or other expenses will be made as soon as possible for agreed purchases on behalf of the Repair Cafe. Volunteers are asked to produce a receipt if possible. If a purchase is made via the internet, a copy of the e-invoice should be passed to Edwina Osborne. Motor mileage and subsistence expenses are currently not covered. Volunteers are encouraged to ask the organisers for any specific tools, consumables or equipment they need.
                        </p>

                        <h3 class="text-xl font-semibold text-gray-800 mt-6">Problem-Solving</h3>
                        <p class="leading-relaxed">
                            In the event of a problem or concern, volunteers are asked to speak to Edwina, Karen or Marsha in the first instance.
                        </p>

                        <h3 class="text-xl font-semibold text-gray-800 mt-6">Roles and Responsibilities of the Repairers / Sewing Team</h3>
                        <p class="leading-relaxed">
                            a. All repairers are reminded that the Repair Café Leighton Buzzard acts as a 'clinic' and not a 'hospital'. With this in mind, repairers are asked to make as quick a diagnosis of a problem as possible and a decision on whether to proceed with the repair. If a repair is likely to take a long time, the repairer should consider whether it is worth their time to proceed.
                        </p>
                        <p class="leading-relaxed">
                            b. Repairers have the right to refuse any item for repair that:
                        </p>
                        <ul class="list-disc list-inside space-y-2 pl-4">
                            <li>is likely to take too long to fix</li>
                            <li>requires extra consumables such as plugs and fuses that the client has not provided</li>
                            <li>requires specialist skills and/or equipment and tools that are not available at the Repair Café</li>
                            <li>is considered to be a potential danger to the repairer</li>
                            <li>is in so bad a state of disrepair/damage that a repair is unlikely to succeed and could be a potential hazard to the repairer and the client</li>
                            <li>is too dirty/unpleasant to handle or too badly torn to make a repair viable</li>
                            <li>is still in warranty</li>
                        </ul>
                        <p class="leading-relaxed">
                            c. If a repairer is unable or does not wish to attempt a repair for any reason, s/he is not required to justify this decision but should offer as much advice as possible to the client.
                        </p>
                        <p class="leading-relaxed">
                            d. Repairers are expected to involve the client in the repair of the item as much as is safely and practically possible. They are also asked to share their skills with the client when appropriate.
                        </p>
                        <p class="leading-relaxed">
                            e. It is not the policy of the Repair Café that repairers should take items home in order to complete a repair. Should a repairer wish to make a private arrangement with a client, it is at the sole discretion and responsibility of the repairer and contact details should be exchanged. As a precaution, it is preferable to and inform the management team that such an arrangement has been made.
                        </p>
                        <p class="leading-relaxed">
                            f. Visitors are not supposed to leave an item with a repairer and collect it later. Should a visitor wish to do this, repairers should refer to Edwina for a decision, as this situation may be acceptable in extenuating circumstances.
                        </p>

                        <h3 class="text-xl font-semibold text-gray-800 mt-6">Roles and Responsibilities of Reception / Front-of-House</h3>
                        <p class="leading-relaxed">
                            As the first point of contact, the reception volunteers should greet all visitors and make them feel welcome. Reception and front-of-house volunteers work closely together, the latter acting as the interface between registration and the repair zone.
                        </p>
                        <p class="leading-relaxed">
                            Volunteers have a responsibility to:
                        </p>
                        <ul class="list-disc list-inside space-y-2 pl-4">
                            <li>Treat everyone fairly and with respect and be polite at all times;</li>
                            <li>Clearly explain the registration and repair zone procedures to all first-time clients;</li>
                            <li>Check clients' items brought for repair so that the correct details are recorded on the registration form;</li>
                            <li>Offer assistance to members of the public who have mobility or other issues;</li>
                            <li>Deal with any difficult situation arising with a member of the public in a calm, firm and polite manner and refer the matter to the organiser;</li>
                            <li>Direct clients to the café area after registration and keep them regularly informed in the event of any delay in moving to the repair zone;</li>
                            <li>Ensure that clients' items for repair are stored safely and do not present a trip hazard in the café or reception area;</li>
                            <li>If someone arrives with a pet please advise them that pets are not allowed on the premises.</li>
                        </ul>

                        <h3 class="text-xl font-semibold text-gray-800 mt-6">Role and Responsibilities of the Organisers</h3>
                        <ul class="list-disc list-inside space-y-2 pl-4">
                            <li>To keep all volunteers safe and secure during each session;</li>
                            <li>To ensure that volunteers feel comfortable and contented in their roles;</li>
                            <li>To ensure that every new volunteer is welcomed and works alongside a regular to help them get used to the system;</li>
                            <li>To provide free refreshments to all volunteers throughout the session. Volunteers are asked to notify Edwina, Marsha or Karen if they have any special dietary requirements that are not being met;</li>
                            <li>To encourage volunteers to give regular feedback and promptly fulfil requests for tools and/or consumables;</li>
                            <li>To consult all volunteers in the event of any planned changes and to treat all comments and opinions equally and with respect. However, the organisers reserve the right to make the final decision when a consensus cannot be reached. The sustainability of Repair Café is always the top priority in any decision;</li>
                            <li>To respect and value everyone's contribution to the project and do its best to meet the individual wishes of each volunteer;</li>
                            <li>To ensure that all visitors and volunteers are welcomed and treated politely and fairly.</li>
                        </ul>

                        <p class="leading-relaxed mt-6 text-sm italic text-gray-600">
                            19 February 2023 - Totally Leighton Buzzard
                        </p>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border-l-4 border-blue-400 p-6 rounded-r-lg">
                    <p class="text-blue-700">
                        <strong>Note:</strong> Click on each policy section above to expand and read the full details. If you have any questions about our policies, please <a href="{{ route('contact') }}" class="text-blue-600 underline hover:text-blue-800">contact us here</a>
                    </p>
                </div>

            </div>
        </div>
    </section>

    <script>
        function togglePolicy(policyId) {
            const content = document.getElementById(policyId + '-content');
            const icon = document.getElementById(policyId + '-icon');
            const summary = document.getElementById(policyId + '-summary');

            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.classList.add('rotate-180');
                summary.classList.add('hidden');
            } else {
                content.classList.add('hidden');
                icon.classList.remove('rotate-180');
                summary.classList.remove('hidden');
            }
        }
    </script>
</x-layouts.public>

<x-app-layout>
    <!-- Header/Navigation -->
    <header class="bg-blue-50 py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="ml-2 font-bold">La Maison</span>
            </div>

            <nav class="hidden md:flex items-center space-x-8">
                <a href="#" class="text-gray-800 hover:text-blue-700">Home</a>
                <a href="#" class="text-gray-800 hover:text-blue-700">About Us</a>
                <a href="#" class="text-gray-800 hover:text-blue-700">Properties</a>
                <a href="#" class="text-gray-800 hover:text-blue-700">Agents</a>
            </nav>

            <div>
                <a href="#" class="border border-gray-800 rounded-md px-4 py-2 text-gray-800 hover:bg-gray-800 hover:text-white transition">Find A House</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <div class="bg-blue-50 py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <!-- Left content - text and stats -->
                <div class="space-y-6">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight">Find A House<br>That Suits You</h1>
                    <p class="text-gray-600">Want to find a home? We are ready to help you find one that suits your lifestyle and needs</p>

                    <div>
                        <a href="#" class="inline-block bg-black text-white px-6 py-3 rounded hover:bg-gray-800 transition">Get Started</a>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 pt-6">
                        <div>
                            <h3 class="text-2xl font-bold">1200 +</h3>
                            <p class="text-sm text-gray-600">Listed Properties</p>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold">4500 +</h3>
                            <p class="text-sm text-gray-600">Happy Customers</p>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold">100 +</h3>
                            <p class="text-sm text-gray-600">Awards</p>
                        </div>
                    </div>
                </div>

                <!-- Right content - image -->
                <div class="hidden md:block">
                    <img src="https://images.unsplash.com/photo-1564013799919-ab600027ffc6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80" alt="Modern home" class="rounded-lg shadow-xl w-full h-auto" />
                </div>
            </div>
        </div>
    </div>

    <!-- Search Box -->
    <div class="container mx-auto px-4 -mt-16 relative z-10">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-medium mb-4">Search for available properties</h3>
            <form class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                    <div class="relative">
                        <select id="location" name="location" class="block w-full rounded border-gray-300 py-2 pl-3 pr-10 text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-blue-500">
                            <option>Select location</option>
                            <option>Banana Island, Lagos</option>
                            <option>Parkview Estate, Lagos</option>
                            <option>Eko Atlantic, Lagos</option>
                            <option>Ikoyi, Lagos</option>
                            <option>Victoria Island, Lagos</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7 7l3-3 3 3m0 6l-3 3-3-3"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="property_type" class="block text-sm font-medium text-gray-700 mb-1">Property Type</label>
                    <div class="relative">
                        <select id="property_type" name="property_type" class="block w-full rounded border-gray-300 py-2 pl-3 pr-10 text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-blue-500">
                            <option>Select type</option>
                            <option>Apartment</option>
                            <option>House</option>
                            <option>Villa</option>
                            <option>Penthouse</option>
                            <option>Commercial</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7 7l3-3 3 3m0 6l-3 3-3-3"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="budget" class="block text-sm font-medium text-gray-700 mb-1">Budget</label>
                    <div class="relative">
                        <select id="budget" name="budget" class="block w-full rounded border-gray-300 py-2 pl-3 pr-10 text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-blue-500">
                            <option>Select budget</option>
                            <option>Under ₦100,000,000</option>
                            <option>₦100,000,000 - ₦200,000,000</option>
                            <option>₦200,000,000 - ₦500,000,000</option>
                            <option>Over ₦500,000,000</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7 7l3-3 3 3m0 6l-3 3-3-3"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="flex items-end">
                    <button type="submit" class="w-full bg-black hover:bg-gray-800 text-white py-2 px-4 rounded transition">Search Now</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Popular Properties Section -->
    <div class="container mx-auto px-4 py-16">
        <div class="flex items-center justify-between mb-8">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-8 h-0.5 bg-gray-800"></div>
                    <span class="uppercase text-sm font-medium">POPULAR</span>
                </div>
                <h2 class="text-3xl font-bold">Our Popular Homes</h2>
            </div>
            <a href="#" class="text-gray-800 hover:text-black flex items-center gap-2">
                Explore All
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>

        <!-- Property Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Property Card 1 -->
            <div class="bg-white rounded-lg overflow-hidden shadow-md">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1570129477492-45c003edd2be?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Property image" class="w-full h-56 object-cover">
                    <div class="absolute bottom-0 left-0 bg-black bg-opacity-70 text-white px-3 py-1 rounded-tr-md flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Banana Island, Lagos
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex flex-wrap justify-between mb-4 text-sm text-gray-600">
                        <div class="flex items-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            5 Bed
                        </div>
                        <div class="flex items-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                            </svg>
                            10x10 m
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            1600 m
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <a href="#" class="bg-gray-900 hover:bg-black text-white py-1 px-4 rounded-md text-sm">Book Now</a>
                        <div class="text-right">
                            <span class="block font-bold text-xl">₦100,000,000</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Property Card 2 -->
            <div class="bg-white rounded-lg overflow-hidden shadow-md">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2074&q=80" alt="Property image" class="w-full h-56 object-cover">
                    <div class="absolute bottom-0 left-0 bg-black bg-opacity-70 text-white px-3 py-1 rounded-tr-md flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Parkview Estate, Lagos
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex flex-wrap justify-between mb-4 text-sm text-gray-600">
                        <div class="flex items-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            4 Bed
                        </div>
                        <div class="flex items-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                            </svg>
                            10x10 m
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            1600 m
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <a href="#" class="bg-gray-900 hover:bg-black text-white py-1 px-4 rounded-md text-sm">Book Now</a>
                        <div class="text-right">
                            <span class="block font-bold text-xl">₦200,000,000</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Property Card 3 -->
            <div class="bg-white rounded-lg overflow-hidden shadow-md">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1613490493576-7fde63acd811?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2071&q=80" alt="Property image" class="w-full h-56 object-cover">
                    <div class="absolute bottom-0 left-0 bg-black bg-opacity-70 text-white px-3 py-1 rounded-tr-md flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Eko Atlantic, Lagos
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex flex-wrap justify-between mb-4 text-sm text-gray-600">
                        <div class="flex items-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            3 Bed
                        </div>
                        <div class="flex items-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                            </svg>
                            10x10 m
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            1600 m
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <a href="#" class="bg-gray-900 hover:bg-black text-white py-1 px-4 rounded-md text-sm">Book Now</a>
                        <div class="text-right">
                            <span class="block font-bold text-xl">₦500,000,000</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonial Footer -->
    <div class="bg-black text-white py-12 mt-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
                <div>
                    <h3 class="text-lg font-medium">Kevin Durant</h3>
                    <p class="text-gray-400 text-sm">Founder, La Maison</p>
                </div>
                <div class="col-span-2">
                    <div class="text-2xl font-light italic">"Our business is built off of close relationships and we are glad that we are able to share our positive real estate experience with clients"</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

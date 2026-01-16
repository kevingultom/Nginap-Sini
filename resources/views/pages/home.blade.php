@extends('layouts.app')

@section('content')
    <!-- Modern Gradient Background with Organic Shapes -->
    <div id="Background" class="absolute top-0 w-full h-[320px] bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 overflow-hidden">
        <div class="absolute top-10 right-10 w-64 h-64 bg-green-200/30 rounded-full blur-3xl"></div>
        <div class="absolute -top-20 -left-20 w-96 h-96 bg-emerald-200/20 rounded-full blur-3xl"></div>
    </div>

    <!-- Top Navigation - Modern Glass Effect -->
    <div id="TopNav" class="relative flex items-center justify-between px-6 mt-12">
        <div class="flex flex-col gap-1">
            <p class="text-gray-600 text-sm font-medium">Good day,</p>
            <h1 class="font-bold text-2xl bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">Find Your Haven</h1>
        </div>
        <a href="#" class="w-12 h-12 flex items-center justify-center shrink-0 rounded-2xl glass-effect hover:scale-110 transition-transform duration-300">
            <img src="assets/images/icons/notification.svg" class="w-6 h-6" alt="icon">
        </a>
    </div>

    <!-- Categories Section - Enhanced Design -->
    <div id="Categories" class="swiper w-full overflow-x-hidden mt-8 relative">
        <div class="swiper-wrapper">
            @foreach($categories as $category)
            <div class="swiper-slide !w-fit pb-8">
                <a href="{{ route('category.show', $category->slug) }}" class="card group">
                    <div class="flex flex-col items-center w-[130px] shrink-0 rounded-3xl p-5 gap-3 bg-white shadow-lg shadow-green-100/50 text-center hover:shadow-xl hover:shadow-green-200/60 hover:-translate-y-2 transition-all duration-300 border-2 border-transparent hover:border-green-200">
                        <div class="w-[75px] h-[75px] rounded-2xl flex shrink-0 overflow-hidden ring-4 ring-green-50 group-hover:ring-green-100 transition-all duration-300">
                            <img src="{{ asset('storage/' . $category->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" alt="thumbnail">
                        </div>
                        <div class="flex flex-col gap-1">
                            <h3 class="font-semibold text-gray-800 group-hover:text-green-600 transition-colors">{{ $category->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $category->boardingHouses->count() }} Places</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Popular Section - Card Redesign -->
    <section id="Popular" class="flex flex-col gap-5 relative">
        <div class="flex items-center justify-between px-6">
            <h2 class="font-bold text-xl text-gray-800">✨ Popular Stays</h2>
            <a href="#" class="flex items-center gap-2 text-green-600 hover:text-green-700 font-medium group">
                <span class="text-sm">See all</span>
                <img src="assets/images/icons/arrow-right.svg" class="w-5 h-5 group-hover:translate-x-1 transition-transform" alt="icon">
            </a>
        </div>
        
        <div class="swiper w-full overflow-x-hidden">
            <div class="swiper-wrapper">
                @foreach($popularBoardingHouses as $boardingHouse)
                <div class="swiper-slide !w-fit">
                    <a href="{{ route('kos.show', $boardingHouse->slug) }}" class="card group">
                        <div class="flex flex-col w-[270px] shrink-0 rounded-3xl bg-white p-4 gap-4 shadow-lg shadow-green-100/50 hover:shadow-xl hover:shadow-green-200/60 hover:-translate-y-2 transition-all duration-300 border-2 border-green-50 hover:border-green-200">
                            <div class="relative flex w-full h-[160px] shrink-0 rounded-2xl overflow-hidden">
                                <img src="{{ asset('storage/' . $boardingHouse->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="thumbnail">
                                <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-full shadow-lg">
                                    <span class="text-xs font-bold text-green-600">Popular</span>
                                </div>
                            </div>
                            
                            <div class="flex flex-col gap-3">
                                <h3 class="font-bold text-lg leading-tight line-clamp-2 min-h-[56px] text-gray-800 group-hover:text-green-600 transition-colors">{{ $boardingHouse->name }}</h3>
                                
                                <div class="flex flex-col gap-2">
                                    <div class="flex items-center gap-2">
                                        <div class="p-1.5 bg-green-50 rounded-lg">
                                            <img src="assets/images/icons/location.svg" class="w-4 h-4" alt="icon">
                                        </div>
                                        <p class="text-sm text-gray-600">{{ $boardingHouse->city->name }}</p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="p-1.5 bg-emerald-50 rounded-lg">
                                            <img src="assets/images/icons/3dcube.svg" class="w-4 h-4" alt="icon">
                                        </div>
                                        <p class="text-sm text-gray-600">{{ $boardingHouse->category->name }}</p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="p-1.5 bg-teal-50 rounded-lg">
                                            <img src="assets/images/icons/profile-2user.svg" class="w-4 h-4" alt="icon">
                                        </div>
                                        <p class="text-sm text-gray-600">{{ $boardingHouse->capacity }} People</p>
                                    </div>
                                </div>
                                
                                <div class="pt-3 border-t border-gray-100">
                                    <p class="font-bold text-xl bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                                        Rp {{ number_format($boardingHouse->price, 0, ',', '.') }}
                                        <span class="text-sm text-gray-500 font-normal">/month</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Cities Section - Modern Grid -->
    <section id="Cities" class="flex flex-col px-6 py-8 gap-5 bg-gradient-to-br from-green-50/50 to-emerald-50/30 mt-8 rounded-t-[40px]">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800">🏙️ Browse Cities</h2>
            <a href="#" class="flex items-center gap-2 text-green-600 hover:text-green-700 font-medium group">
                <span class="text-sm">See all</span>
                <img src="assets/images/icons/arrow-right.svg" class="w-5 h-5 group-hover:translate-x-1 transition-transform" alt="icon">
            </a>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            @foreach($cities as $city)
            <a href="cities.html" class="card group">
                <div class="flex items-center rounded-2xl p-4 gap-3 bg-white shadow-md shadow-green-100/50 hover:shadow-lg hover:shadow-green-200/60 transition-all duration-300 border-2 border-transparent hover:border-green-200 hover:-translate-y-1">
                    <div class="w-14 h-14 flex shrink-0 rounded-xl overflow-hidden ring-4 ring-green-50 group-hover:ring-green-100 transition-all">
                        <img src="{{ asset('storage/' . $city->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" alt="icon">
                    </div>
                    <div class="flex flex-col gap-0.5">
                        <h3 class="font-semibold text-gray-800 group-hover:text-green-600 transition-colors">{{ $city->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $city->boardingHouses->count() }} Places</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </section>

    <!-- All Places Section -->
    <section id="Best" class="flex flex-col gap-5 px-6 mt-8 pb-32">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800">🌟 All Great Places</h2>
            <a href="#" class="flex items-center gap-2 text-green-600 hover:text-green-700 font-medium group">
                <span class="text-sm">See all</span>
                <img src="assets/images/icons/arrow-right.svg" class="w-5 h-5 group-hover:translate-x-1 transition-transform" alt="icon">
            </a>
        </div>
        
        <div class="flex flex-col gap-4">
            @foreach ($boardingHouses as $boardingHouse)
            <a href="{{ route('kos.show', $boardingHouse->slug) }}" class="card group">
                <div class="flex rounded-3xl bg-white p-4 gap-4 shadow-lg shadow-green-100/50 hover:shadow-xl hover:shadow-green-200/60 transition-all duration-300 border-2 border-green-50 hover:border-green-200 hover:-translate-y-1">
                    <div class="flex w-[130px] h-[190px] shrink-0 rounded-2xl overflow-hidden">
                        <img src="{{ asset('storage/' . $boardingHouse->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="icon">
                    </div>
                    
                    <div class="flex flex-col gap-3 w-full">
                        <h3 class="font-bold text-lg leading-tight line-clamp-2 min-h-[56px] text-gray-800 group-hover:text-green-600 transition-colors">{{ $boardingHouse->name }}</h3>
                        
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center gap-2">
                                <div class="p-1.5 bg-green-50 rounded-lg">
                                    <img src="assets/images/icons/location.svg" class="w-4 h-4" alt="icon">
                                </div>
                                <p class="text-sm text-gray-600">{{ $boardingHouse->city->name }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="p-1.5 bg-emerald-50 rounded-lg">
                                    <img src="assets/images/icons/profile-2user.svg" class="w-4 h-4" alt="icon">
                                </div>
                                <p class="text-sm text-gray-600">4 People</p>
                            </div>
                        </div>
                        
                        <div class="pt-2 mt-auto border-t border-gray-100">
                            <p class="font-bold text-lg bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                                Rp {{ number_format($boardingHouse->price, 0, ',', '.') }}
                                <span class="text-sm text-gray-500 font-normal">/month</span>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </section>

    @include('includes.navigation')
@endsection 
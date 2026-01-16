@extends('layouts.app')

@section('content')
<!-- Modern Gradient Background -->
<div id="Background" class="absolute top-0 w-full h-[480px] bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 overflow-hidden">
    <div class="absolute top-10 right-10 w-72 h-72 bg-green-200/30 rounded-full blur-3xl"></div>
    <div class="absolute -top-20 -left-20 w-96 h-96 bg-emerald-200/20 rounded-full blur-3xl"></div>
</div>

<div class="relative flex flex-col gap-8 my-16 px-6">
    <div class="text-center">
        <h1 class="font-bold text-4xl leading-tight mb-3">
            <span class="bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">Discover Your</span><br>
            <span class="text-gray-800">Perfect Stay</span>
        </h1>
        <p class="text-gray-600 mt-2">Find the best accommodation for you</p>
    </div>
    <form action="{{ route('find-kos.result') }}" method="GET"
        class="flex flex-col rounded-3xl p-7 gap-6 glass-effect shadow-2xl shadow-green-900/10 border border-white/40">
        <div id="InputContainer" class="flex flex-col gap-5">
            <div class="flex flex-col w-full gap-3">
                <p class="font-semibold text-gray-700 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                    Property Name
                </p>
                <label class="flex items-center w-full rounded-2xl p-4 gap-3 bg-white ring-2 ring-gray-100 focus-within:ring-green-400 hover:ring-green-200 transition-all duration-300">
                    <img src="{{ asset('assets/images/icons/note-favorite-grey.svg') }}" class="w-5 h-5 flex shrink-0" alt="icon">
                    <input type="text" name="search" id=""
                        class="appearance-none outline-none w-full font-medium text-gray-800 placeholder:text-gray-400 placeholder:font-normal"
                        placeholder="Search by name...">
                </label>
            </div>
            <div class="flex flex-col w-full gap-3">
                <p class="font-semibold text-gray-700 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                    Choose City
                </p>
                <label class="relative flex items-center w-full rounded-2xl p-4 gap-2 bg-white ring-2 ring-gray-100 focus-within:ring-green-400 hover:ring-green-200 transition-all duration-300">
                    <img src="{{ asset('assets/images/icons/location.svg') }}"
                        class="absolute w-5 h-5 flex shrink-0 transform -translate-y-1/2 top-1/2 left-4"
                        alt="icon">
                    <select name="city" id="" class="appearance-none outline-none w-full bg-transparent pl-8 pr-10 font-medium text-gray-800">
                        <option value="" hidden>Select your city</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                    <img src="{{ asset('assets/images/icons/arrow-down.svg') }}" class="absolute right-4 w-5 h-5" alt="icon">
                </label>
            </div>
            
            <div class="flex flex-col w-full gap-3">
                <p class="font-semibold text-gray-700 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-teal-500 rounded-full"></span>
                    Choose Category
                </p>
                <label class="relative flex items-center w-full rounded-2xl p-4 gap-2 bg-white ring-2 ring-gray-100 focus-within:ring-green-400 hover:ring-green-200 transition-all duration-300">
                    <img src="{{ asset('assets/images/icons/3dcube.svg') }}"
                        class="absolute w-5 h-5 flex shrink-0 transform -translate-y-1/2 top-1/2 left-4"
                        alt="icon">
                    <select name="category" id="" class="appearance-none outline-none w-full bg-transparent pl-8 pr-10 font-medium text-gray-800">
                        <option value="" hidden>Select category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <img src="{{ asset('assets/images/icons/arrow-down.svg') }}" class="absolute right-4 w-5 h-5" alt="icon">
                </label>
            </div>
            
            <button type="submit" class="btn-primary mt-2 py-4 text-base shadow-xl shadow-green-500/30 hover:shadow-2xl hover:shadow-green-500/40 hover:scale-[1.02]">
                🔍 Search Now
            </button>
                </div>
            </form>
        </div>

        @include('includes.navigation')
@endsection
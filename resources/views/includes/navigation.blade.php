<div id="BottomNav" class="relative flex w-full h-[138px] shrink-0">
    <nav class="fixed bottom-5 w-full max-w-[640px] px-5 z-50">
        <div class="grid grid-cols-4 h-fit rounded-[32px] justify-between py-4 px-6 glass-effect shadow-2xl shadow-green-900/10 border border-white/40">
            
            <a href="{{ route('home') }}" class="flex flex-col items-center text-center gap-2 group">
                <div class="p-2.5 rounded-2xl {{ request()->routeIs('home') ? 'bg-gradient-to-br from-green-500 to-emerald-500 shadow-lg shadow-green-500/30' : 'bg-gray-100 group-hover:bg-green-50' }} transition-all duration-300">
                    <img src="assets/images/icons/global{{ request()->routeIs('home') ? '-green' : '' }}.svg"
                         class="w-6 h-6 flex shrink-0 {{ request()->routeIs('home') ? 'brightness-0 invert' : '' }}"
                         alt="icon">
                </div>
                <span class="font-semibold text-xs {{ request()->routeIs('home') ? 'text-green-600' : 'text-gray-500 group-hover:text-green-600' }} transition-colors">Explore</span>
            </a>

            <a href="{{ route('check-booking') }}" class="flex flex-col items-center text-center gap-2 group">
                <div class="p-2.5 rounded-2xl {{ request()->routeIs('check-booking') ? 'bg-gradient-to-br from-green-500 to-emerald-500 shadow-lg shadow-green-500/30' : 'bg-gray-100 group-hover:bg-green-50' }} transition-all duration-300">
                    <img src="assets/images/icons/note-favorite{{ request()->routeIs('check-booking') ? '-green' : '' }}.svg"
                        class="w-6 h-6 flex shrink-0 {{ request()->routeIs('check-booking') ? 'brightness-0 invert' : '' }}"
                        alt="icon">
                </div>
                <span class="font-semibold text-xs {{ request()->routeIs('check-booking') ? 'text-green-600' : 'text-gray-500 group-hover:text-green-600' }} transition-colors">Bookings</span>
            </a>

            <a href="{{ route('find-kos') }}" class="flex flex-col items-center text-center gap-2 group">
                <div class="p-2.5 rounded-2xl {{ request()->routeIs('find-kos') ? 'bg-gradient-to-br from-green-500 to-emerald-500 shadow-lg shadow-green-500/30' : 'bg-gray-100 group-hover:bg-green-50' }} transition-all duration-300">
                    <img src="assets/images/icons/search-status{{ request()->routeIs('find-kos') ? '-green' : '' }}.svg"
                        class="w-6 h-6 flex shrink-0 {{ request()->routeIs('find-kos') ? 'brightness-0 invert' : '' }}"
                        alt="icon">
                </div>
                <span class="font-semibold text-xs {{ request()->routeIs('find-kos') ? 'text-green-600' : 'text-gray-500 group-hover:text-green-600' }} transition-colors">Search</span>
            </a>

            <a href="#" class="flex flex-col items-center text-center gap-2 group">
                <div class="p-2.5 rounded-2xl {{ request()->routeIs('help') ? 'bg-gradient-to-br from-green-500 to-emerald-500 shadow-lg shadow-green-500/30' : 'bg-gray-100 group-hover:bg-green-50' }} transition-all duration-300">
                    <img src="assets/images/icons/24-support{{ request()->routeIs('help') ? '-green' : '' }}.svg"
                        class="w-6 h-6 flex shrink-0 {{ request()->routeIs('help') ? 'brightness-0 invert' : '' }}"
                        alt="icon">
                </div>
                <span class="font-semibold text-xs {{ request()->routeIs('help') ? 'text-green-600' : 'text-gray-500 group-hover:text-green-600' }} transition-colors">Help</span>
            </a>

        </div>
    </nav>
</div>

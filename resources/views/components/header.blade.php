@if (Request::path() == 'login')
@else
    <header class="z-20 py-4 shadow-md bg-gray-900 sticky top-0 w-full">

        <div class="container flex items-center @if (!str_contains(url()->current(), 'public')) justify-between md:justify-end @else @endif h-full px-6 mx-auto text-white">
            <!-- Mobile hamburger -->
            <button class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-lime"
                @click="toggleSideMenu" aria-label="Menu">
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
            <div class="flex @if (!str_contains(url()->current(), 'public')) md:justify-between @else @endif w-full">
                <span id='ct7' class="w-full md:w-auto text-center @if (!str_contains(url()->current(), 'public')) md:text-left @endif"></span>
                @if (isset(auth()->user()->name) && !str_contains(url()->current(), 'public'))
                    <p class="hidden md:block">Hi <span
                            class="mr-2 font-bold text-amber-500">{{ auth()->user()->name }}</span></p>
                @endif
            </div>
            @if (isset(auth()->user()->name) && !str_contains(url()->current(), 'public'))
                <ul class="md:flex items-center flex-shrink-0 space-x-6 hidden">

                    <li>
                        <button @click="openModal" id="lgbtn2" class="hidden lg:block"><i
                                class="fa-solid fa-right-from-bracket"></i>
                            Logout</button>
                        <script>
                            $('#lgbtn2').click(function() {
                                console.log('btn clicked');
                                $('#modal').removeClass('hidden');
                                $('#modalbg').removeClass('hidden');
                                $('#modalbg').addClass('flex');
                            });
                        </script>
                    </li>
                </ul>
            @endif
        </div>
    </header>
@endif

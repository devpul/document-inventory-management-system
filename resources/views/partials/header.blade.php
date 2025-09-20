<header class="bg-white shadow-md p-4 flex justify-between items-center">
    <h1 class="text-md font-semibold">
        <span class="text-md font-normal">DMS /</span> 
        @yield('title')
    </h1>
        <div class="flex items-center space-x-4">
            <a href="{{ route('dashboard.manage_edit_user', Auth()->user()->id) }}">
                <div class="flex space-x-2 justify-center items-center">
                    <div class="w-10 h-10 rounded-full  overflow-hidden">
                        <img 
                        src="{{ Auth()->user()->image
                                    ? asset('storage/profile-image/' . Auth()->user()->image) 
                                    : asset('storage/profile-image/default-avatar.jpg') }}" 
                        class="w-full h-full object-cover"
                        alt="{{ Auth()->user()->nama ?? 'User' }}">
                    </div>
                    <div class="cursor-pointer font-bold hidden lg:block">{{ getInitialName(auth()->user()->nama ) }}</div>
                </div>
            </a>
        </div>
</header>
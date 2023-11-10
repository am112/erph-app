<aside
    class="fixed top-0 left-0 z-40 md:z-30 w-64 h-screen pt-3 transition-transform -translate-x-full bg-white md:bg-transparent  md:translate-x-0 dark:bg-gray-800 md:dark:bg-transparent"
    aria-label="Sidenav" id="drawer-navigation">
    <div class="overflow-y-auto py-16 px-3 h-full dark:bg-gray-800 md:dark:bg-transparent">
        <div class="pb-5 mb-0">
            <livewire:semester-select :semester="request()->semester?->id ?? App\Models\Semester::active()->first()->id" routeName="{{ request()->path() }}" lazy />
        </div>
        <ul class="space-y-2">
            @php
                $routeList = [
                    [
                        'name' => __('Halaman Utama'),
                        'link' => route('dashboard', ['semester' => request()->semester]),
                        'routeName' => 'dashboard',
                        'icon' => 'heroicon-s-home',
                        'subitems' => [],
                    ],
                    [
                        'name' => __('Matlamat dan Objektif'),
                        'link' => route('objectives', ['semester' => request()->semester]),
                        'routeName' => 'objectives',
                        'icon' => 'heroicon-s-globe-alt',
                        'subitems' => [],
                    ],
                    [
                        'name' => __('Takwim'),
                        'link' => route('takwim', ['semester' => request()->semester]),
                        'routeName' => 'takwim',
                        'icon' => 'heroicon-m-book-open',
                        'subitems' => [],
                    ],
                    [
                        'name' => __('Kalendar Aktiviti'),
                        'link' => route('curriculum.index', ['semester' => request()->semester]),
                        'routeName' => 'curriculum',
                        'icon' => 'heroicon-s-calendar-days',
                        'subitems' => [],
                    ],
                    [
                        'name' => __('Profil'),
                        'link' => '#',
                        'routeName' => 'profile',
                        'icon' => 'heroicon-s-user-group',
                        'subitems' => [
                            [
                                'name' => __('Tabika'),
                                'link' => route('profile.schools.edit', ['semester' => request()->semester]),
                                'routeName' => 'profile.schools',
                                'icon' => 'heroicon-o-home',
                            ],
                            [
                                'name' => __('PM / PPMS'),
                                'link' => route('profile.teachers.index', ['semester' => request()->semester]),
                                'routeName' => 'profile.teachers',
                                'icon' => 'heroicon-o-home',
                            ],
                            [
                                'name' => __('AJK'),
                                'link' => route('profile.committees.index', ['semester' => request()->semester]),
                                'routeName' => 'profile.committees',
                                'icon' => 'heroicon-o-home',
                            ],
                            [
                                'name' => __('Kanak Kanak'),
                                'link' => route('profile.students.index', ['semester' => request()->semester]),
                                'routeName' => 'profile.students',
                                'icon' => 'heroicon-o-home',
                            ],
                        ],
                    ],
                    [
                        'name' => __('Rancangan Pelajaran'),
                        'link' => route('courses.index', ['semester' => request()->semester]),
                        'routeName' => 'courses',
                        'icon' => 'heroicon-m-academic-cap',
                        'subitems' => [],
                    ],
                    [
                        'divider' => true,
                        'name' => __('RPH'),
                        'link' => route('rph.index', ['semester' => request()->semester]),
                        'routeName' => 'rph',
                        'icon' => 'heroicon-o-document-plus',
                        'subitems' => [],
                    ],
                ];

            @endphp

            @foreach ($routeList as $route)
                @if (sizeOf($route['subitems']) == 0)
                    @isset($route['divider'])
                        <div class="my-5 space-y-2 border-t border-gray-200 dark:border-gray-700"></div>
                    @endisset
                    @php
                        $activeClass = strpos(Route::currentRouteName(), $route['routeName']) !== false ? 'text-primary-500 bg-gray-100 dark:bg-gray-800' : 'text-gray-600 dark:text-gray-500';
                    @endphp
                    <li>
                        <a href="{{ $route['link'] }}"
                            class="flex items-center p-2 text-base font-medium {{ $activeClass }} rounded-lg hover:bg-gray-200 dark:hover:bg-gray-800 group">
                            @svg($route['icon'], [
                                'class' => 'w-6 h-6 text-gray-500 transition duration-75',
                            ])
                            <span class="ml-3">{{ $route['name'] }}</span>
                        </a>
                    </li>
                @else
                    <li>
                        @php
                            $subItemsRouteName = collect($route['subitems'])->pluck('routeName');
                        @endphp
                        <div class="flex items-center p-2 w-full text-base font-medium text-gray-600">
                            @svg($route['icon'], [
                                'class' => 'w-6 h-6 text-gray-500 transition duration-75',
                            ])
                            <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ $route['name'] }}</span>
                        </div>
                        {{-- <button type="button"
                            class="flex items-center p-2 w-full text-base font-medium text-gray-600 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-gray-500 dark:hover:bg-gray-800"
                            aria-controls="dropdown-pages-{{ $loop->index }}"
                            data-collapse-toggle="dropdown-pages-{{ $loop->index }}">


                            <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button> --}}
                        <ul id="dropdown-pages-{{ $loop->index }}" class="py-2 space-y-2">
                            {{-- class="{{ strpos(Route::currentRouteName(), $route['routeName']) !== false ? '' : 'hidden' }} py-2 space-y-2"> --}}
                            @foreach ($route['subitems'] as $subRoute)
                                @php
                                    $activeClass = strpos(Route::currentRouteName(), $subRoute['routeName']) !== false ? 'text-primary-500 bg-gray-100 dark:bg-gray-800' : 'text-gray-600 dark:text-gray-500';
                                @endphp
                                <li>
                                    <a href="{{ $subRoute['link'] }}"
                                        class="flex pl-11 items-center p-2 text-base font-medium {{ $activeClass }} rounded-lg hover:bg-gray-200 dark:hover:bg-gray-800 group">
                                        {{ $subRoute['name'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</aside>

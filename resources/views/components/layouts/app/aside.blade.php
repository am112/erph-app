<aside
    class="fixed top-0 left-0 z-30 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidenav" id="drawer-navigation">

    <div class="overflow-y-auto py-5 px-3 h-full bg-white dark:bg-gray-800">
        <div class="pb-5 mb-0">
            <livewire:semester-select :semester="request()->semester?->id ?? App\Models\Semester::active()->first()->id" />
        </div>
        <ul class="space-y-2">
            @php
                $routeList = [
                    [
                        'name' => __('Halaman Utama'),
                        'link' => route('semester.dashboard', ['semester' => request()->semester]),
                        'routeName' => 'semester.dashboard',
                        'icon' => 'heroicon-s-home',
                        'subitems' => [],
                    ],
                    [
                        'name' => __('Matlamat dan Objektif'),
                        'link' => route('semester.objectives', ['semester' => request()->semester]),
                        'routeName' => 'semester.objectives',
                        'icon' => 'heroicon-s-home',
                        'subitems' => [],
                    ],
                    [
                        'name' => __('Takwim'),
                        'link' => route('semester.takwim', ['semester' => request()->semester]),
                        'routeName' => 'semester.takwim',
                        'icon' => 'heroicon-s-home',
                        'subitems' => [],
                    ],
                    [
                        'name' => __('Kalendar Aktiviti'),
                        'link' => route('semester.curriculum.index', ['semester' => request()->semester]),
                        'routeName' => 'semester.curriculum.index',
                        'icon' => 'heroicon-s-home',
                        'subitems' => [],
                    ],
                    [
                        'name' => __('Profil'),
                        'link' => '#',
                        'routeName' => 'semester.dashboard',
                        'icon' => 'heroicon-s-user-group',
                        'subitems' => [
                            [
                                'name' => __('Tabika'),
                                'link' => route('semester.schools.create', ['semester' => request()->semester]),
                                'routeName' => 'semester.schools.create',
                                'icon' => 'heroicon-o-home',
                            ],
                            [
                                'name' => __('PM / PPMS'),
                                'link' => route('semester.staffs.index', ['semester' => request()->semester]),
                                'routeName' => 'semester.staffs.index',
                                'icon' => 'heroicon-o-home',
                            ],
                        ],
                    ],
                    [
                        'name' => __('Rancangan Pelajaran'),
                        'link' => route('semester.courses.index', ['semester' => request()->semester]),
                        'routeName' => 'semester.dashboards',
                        'icon' => 'heroicon-s-home',
                        'subitems' => [],
                    ],
                ];

            @endphp

            @foreach ($routeList as $route)
                @if (sizeOf($route['subitems']) == 0)
                    @php
                        $activeClass = request()
                            ->route()
                            ->named($route['routeName'])
                            ? 'text-primary-600 bg-gray-100 dark:bg-gray-700'
                            : 'text-gray-600';
                    @endphp
                    <li>
                        <a href="{{ $route['link'] }}"
                            class="flex items-center p-2 text-base font-medium {{ $activeClass }} rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            @svg($route['icon'], [
                                'class' => 'w-6 h-6 {{ $activeClass }} transition duration-75 dark:text-gray-400 group-hover:text-primary-500 dark:group-hover:text-white',
                            ])
                            <span class="ml-3">{{ $route['name'] }}</span>
                        </a>
                    </li>
                @else
                    <li>
                        @php
                            $subItemsRouteName = collect($route['subitems'])->pluck('routeName');
                        @endphp
                        <button type="button"
                            class="flex items-center p-2 w-full text-base font-medium text-gray-600 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                            aria-controls="dropdown-pages-{{ $loop->index }}"
                            data-collapse-toggle="dropdown-pages-{{ $loop->index }}">
                            @svg($route['icon'], [
                                'class' => 'w-6 h-6 {{ $activeClass }} transition duration-75 dark:text-gray-400 group-hover:text-primary-500 dark:group-hover:text-white',
                            ])
                            <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ $route['name'] }}</span>
                            <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <ul id="dropdown-pages-{{ $loop->index }}"
                            class="{{ in_array(request()->route()->getName(),$subItemsRouteName->toArray())? '': 'hidden' }} py-2 space-y-2">
                            @foreach ($route['subitems'] as $subRoute)
                                @php
                                    $activeClass = request()
                                        ->route()
                                        ->named($subRoute['routeName'])
                                        ? 'text-primary-600 bg-gray-100 dark:bg-gray-700'
                                        : 'text-gray-600';
                                @endphp
                                <li>
                                    <a href="{{ $subRoute['link'] }}"
                                        class="flex items-center p-2 pl-11 w-full text-base font-medium {{ $activeClass }} rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                        {{ $subRoute['name'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endforeach
            <div class="my-5 space-y-2 border-t border-gray-200 dark:border-gray-700">
            </div>
            <li>
                <a href="#"
                    class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                    <svg aria-hidden="true"
                        class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                        <path fill-rule="evenodd"
                            d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">ERPH</span>
                    <span
                        class="inline-flex justify-center items-center w-5 h-5 text-xs font-semibold rounded-full text-primary-800 bg-primary-100 dark:bg-primary-200 dark:text-primary-800">
                        4
                    </span>
                </a>
            </li>
        </ul>
    </div>
</aside>

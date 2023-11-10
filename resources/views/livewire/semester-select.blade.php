<?php
use function Livewire\Volt\{computed, mount, state, updated, placeholder};
use App\Models\Semester;

state(['semester' => '', 'currentUrl' => '']);

mount(function (int $semester, string $routeName) {
    if ($this->semester == '') {
        $this->semester = $semester;
    }
    $this->currentUrl = $routeName;
});

$semesters = computed(fn() => App\Models\Semester::all());

updated([
    'semester' => function ($value) {
        return $this->redirect('/' . $this->semester . substr($this->currentUrl, 1));
        /*
            For single page application
            $url = str_replace(config('app.url') ,'' ,route($this->currentUrl, ['semester' => $value]));
            return $this->redirect($url, navigate:true);
        */
    },
]);

placeholder('
<div class="flex items-center justify-center bg-gray-50 border border-gray-200 text-gray-600 font-medium rounded-lg w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-300">
    <svg class="text-primary-500" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><style>.spinner_OSmW{transform-origin:center;animation:spinner_T6mA .75s step-end infinite}@keyframes spinner_T6mA{8.3%{transform:rotate(30deg)}16.6%{transform:rotate(60deg)}25%{transform:rotate(90deg)}33.3%{transform:rotate(120deg)}41.6%{transform:rotate(150deg)}50%{transform:rotate(180deg)}58.3%{transform:rotate(210deg)}66.6%{transform:rotate(240deg)}75%{transform:rotate(270deg)}83.3%{transform:rotate(300deg)}91.6%{transform:rotate(330deg)}100%{transform:rotate(360deg)}}</style><g class="spinner_OSmW"><rect x="11" y="1" width="2" height="5" opacity=".14"/><rect x="11" y="1" width="2" height="5" transform="rotate(30 12 12)" opacity=".29"/><rect x="11" y="1" width="2" height="5" transform="rotate(60 12 12)" opacity=".43"/><rect x="11" y="1" width="2" height="5" transform="rotate(90 12 12)" opacity=".57"/><rect x="11" y="1" width="2" height="5" transform="rotate(120 12 12)" opacity=".71"/><rect x="11" y="1" width="2" height="5" transform="rotate(150 12 12)" opacity=".86"/><rect x="11" y="1" width="2" height="5" transform="rotate(180 12 12)"/></g></svg>
</div>
');

?>

<div>
    <select id="countries" wire:model.live="semester"
        class="bg-gray-50 border border-gray-200 text-gray-600 font-medium rounded-lg block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-300">
        @foreach ($this->semesters as $item)
            <option value="{{ $item->id }}">{{ $item->name }}</option>
        @endforeach
    </select>
</div>

<?php
use function Livewire\Volt\{computed, mount, state, updated};
use Illuminate\Support\Facades\Route;
use App\Models\Semester;

state(['semester' => '', 'currentUrl' => '']);

mount(function (Semester $semester) {
    if ($this->semester == '') {
        $this->semester = $semester;
    }
    $this->currentUrl = Route::currentRouteName();
});

$semesters = computed(fn() => App\Models\Semester::all());

updated([
    'semester' => function ($value) {
        return redirect()->route($this->currentUrl, ['semester' => $value]);
        /*
            For single page application
            $url = str_replace(config('app.url') ,'' ,route($this->currentUrl, ['semester' => $value]));
            return $this->redirect($url, navigate:true);
        */
    },
]);

?>

<select id="countries" wire:model.live="semester"
    class="bg-gray-50 border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
    @foreach ($this->semesters as $item)
        <option value="{{ $item->id }}">{{ $item->name }}</option>
    @endforeach
</select>

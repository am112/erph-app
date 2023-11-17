<?php

namespace App\Livewire;

use Livewire\Component;

class TimetableAnalyst extends Component
{

    public $record;
    public $total;

    public function mount($data){
        // manipulate the data;
        $this->total = [
            'bm' => 0,
            'bi' => 0,
        ];

        foreach($data->unique('field_id') as $item){
            $this->record[] = [
                'name' => $item->field->name,
                'sum_bm' => $data->where('field_id', $item->field_id)->where('language_id', 5)->sum('total_time'),
                'sum_bi' => $data->where('field_id', $item->field_id)->where('language_id', 8)->sum('total_time'),
                'total' => $data->where('field_id', $item->field_id)->sum('total_time'),
            ];
            $this->total['bm'] += $data->where('field_id', $item->field_id)->where('language_id', 5)->sum('total_time');
            $this->total['bi'] += $data->where('field_id', $item->field_id)->where('language_id', 8)->sum('total_time');
        }

        $this->record = collect($this->record);
    }

    public function render()
    {
        return view('livewire.timetable-analyst', [
            'data'=> $this->record,
            'total' => $this->total,
        ]);
    }
}

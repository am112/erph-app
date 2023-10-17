<?php

namespace App\Filament\Resources\RegionResource\Pages;

use App\Enums\RegionTag;
use App\Filament\Resources\RegionResource;
use App\Models\Region;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ListRegions extends ListRecords
{
    protected static string $resource = RegionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $data = Region::select('tag', DB::raw('COUNT(*) as count'))
            ->groupBy('tag')
            ->get();
            // dd();
        return [
            'all' => Tab::make('All Region')
                ->badge($data->sum('count')),
            RegionTag::STATE => Tab::make('State')
                ->badge($data->where('tag', RegionTag::STATE)->first()?->count ?? 0)
                ->modifyQueryUsing(fn(Builder $query)=> $query->where('tag', RegionTag::STATE)),
            RegionTag::PARLIMENT => Tab::make('Parliment')
                ->badge($data->where('tag', RegionTag::PARLIMENT)->first()?->count ?? 0)
                ->modifyQueryUsing(fn(Builder $query)=> $query->where('tag', RegionTag::PARLIMENT)),
            RegionTag::DUN => Tab::make('Dun')
                ->badge($data->where('tag', RegionTag::DUN)->first()?->count ?? 0)
                ->modifyQueryUsing(fn(Builder $query)=> $query->where('tag', RegionTag::DUN)),
        ];
    }
}

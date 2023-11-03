<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class FileService
{
    public function __construct(public readonly Model $model)
    {
        
    }

    public function storeToCollection($file, string $collection, bool $replace = false): void
    {   
        if($file == null){
            return;
        }

        if($replace){
            $this->model->clearMediaCollection($collection);
        }

        $this->model->addMediaFromDisk($file->getRealPath(), 'do')
            ->sanitizingFileName(function($fileName) {
                return strtolower(str_replace(['#', '/', '\\', ' '], '-', $fileName));
            })
            ->toMediaCollection($collection, 'do');
    }

    public function deleteAllFromCollection(string $collection): void
    {
        $this->model->clearMediaCollection($collection);
    }
}
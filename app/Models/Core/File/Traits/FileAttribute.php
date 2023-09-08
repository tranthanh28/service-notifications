<?php


namespace App\Models\Core\File\Traits;


use App\Helpers\Core\Traits\FileHandler;
use Illuminate\Support\Facades\Storage;

trait FileAttribute
{
    use FileHandler;

    public function getFullUrlAttribute()
    {
        if (in_array(config('filesystems.default'), ['local', 'public'])) {
            return request()->root().$this->path;
        }elseif (config('filesystems.default')==='s3'){
            return Storage::disk('s3')->url($this->path);
        }
        return $this->path;
    }
}

<?php


namespace App\Helpers\Core\Traits;


use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

trait FileHandler
{
    protected string $storagePrefix = 'public';
    protected bool $isOriginalName = false;

    public function storeFile(UploadedFile $file, $folder = 'avatar'): string
    {
        $name = $this->generateUploadingFileName($file);

        $file->storeAs("{$this->storagePrefix}/{$folder}", $name);

        return Storage::disk(config('filesystems.default'))->url($folder . '/' . $name);
    }

    private function generateUploadingFileName(UploadedFile $file): string
    {
        $name = $this->getDefaultName();

        if ($this->isOriginalName) {
            $name = Str::of($file->getClientOriginalName())
                ->replaceMatches("/[.].*/", '')
                ->snake()
                ->limit(30, '');
            $name = $name . "-" . uniqid();
        }

        return $name . "." . $file->getClientOriginalExtension();
    }

    private function getDefaultName(): string
    {
        return Str::random(40);
    }

    public function uploadImage(UploadedFile $uploadedFile = null, $folder = "logo", $height = 300)
    {
        if (is_null($uploadedFile))
            return null;
        $file = $this->saveImage($uploadedFile, $folder, $height);
        if ($file->success){
            return (config('filesystems.default') === 's3') ? $file->path : Storage::url($file->path);
        }
        return null;
    }

    public function saveImage(UploadedFile $file, $subdirectory = 'logo', $height = 300): object
    {
        $file_name = uniqid() . '.' . $file->getClientOriginalExtension();
        $file_path =  $subdirectory . '/' . $file_name;
        try {
            $file = $this->makeImage($file, $height)->stream(); //resizing image
            Storage::disk(config('filesystems.default'))->put( ((config('filesystems.default') === 's3') ? '' : $this->storagePrefix) . '/' . $file_path, $file);
        } catch (Exception $exception) {
            Storage::disk(config('filesystems.default'))->putFileAs( ((config('filesystems.default') === 's3') ? '' : $this->storagePrefix) . '/' . $subdirectory, $file, $file_name);
        }
        $uploadedImagePath = ((config('filesystems.default') === 's3') ? '' : $this->storagePrefix) . '/' . $file_path;
        return (object)["success" => true, "message" => "File has been uploaded successfully", "path" => $uploadedImagePath];
    }

    public function makeImage(UploadedFile $file, $height = 300): \Intervention\Image\Image
    {
        return Image::make($file)->resize(null, $height, function ($constraint) {
            $constraint->aspectRatio();
        })->save();
    }

    public function deleteImage(string $path = null): bool
    {
        return $this->deleteFile($path);
    }

    public function deleteFile(string $path = null): bool
    {
        $path = ((config('filesystems.default') === 's3') ? '' : $this->storagePrefix) . '/' . $this->removeStorage($path);
        if ($this->isFile($path)){
            return Storage::disk(config('filesystems.default'))->delete($path);
        }

        return false;
    }

    public function removeStorage($path): string
    {
        return str_replace('/storage', '', $path);
    }

    public function isFile(string $path = null): bool
    {
        return Storage::disk(config('filesystems.default'))->exists($path);
    }


    public function deleteMultipleFile($paths)
    {
        foreach ($paths as $path) {
            $this->deleteFile($path);
        }

        return true;
    }

    public function filePath(string $path = null): ?string
    {
        $path = $this->removeStorage($path);
        if ($this->isFile($path))
            return Storage::disk(config('filesystems.default'))->url("{$this->storagePrefix}/{$path}");
        return null;
    }

    private function isWithOriginalName($flag = true)
    {
        $this->isOriginalName = $flag;
        return $this;
    }

}

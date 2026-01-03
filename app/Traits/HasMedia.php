<?php


namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Media;

trait HasMedia
{

    public function uploadMedia(UploadedFile $file): Media
    {
        $path = $file->store('uploads');

        return $this->media()->create([
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }


    public function uploadMultipleMedia(array $files)
    {
        $uploaded = [];
        foreach ($files as $file) {
            $uploaded[] = $this->uploadMedia($file);
        }
        return $uploaded;
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }


    public function deleteMedia(Media $media)
    {
        Storage::delete($media->file_path);
        $media->delete();
    }
}

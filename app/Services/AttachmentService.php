<?php

namespace App\Services;
use App\Models\Attachment;
use Gumlet\ImageResize;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AttachmentService extends Service
{

    private string $disk;
    private string $path;

    public function __construct()
    {
        $this->disk = Attachment::$disk;
        $this->path = Attachment::$path;
    }

    public function makeUpload(
        UploadedFile $file,
        Model $model,
        $type,
        $scale = null,
        $title = ''
    ){

        $address = Storage::disk($this->disk)->put($this->path, $file);
        if ($scale != null) {
            $realPath = str_replace('public', 'storage', $address);
            $image = new ImageResize($realPath);
            $image->scale($scale);
            $image->save($realPath);   
        }
        return Attachment::create([
            'title' => $title,
            'disk' => $this->disk,
            'path' => str_replace('public', 'storage', $address),
            'extension' => $file->getMimeType(),
            'mime' => $file->getClientMimeType(),
            'original_name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'user_id' => auth()->user()->id,
            'type' => $type,
            'attachable_id' => $model->getKey(),
            'attachable_type' => $model->getMorphClass(),
        ]);
    }

    public function deleteAttachment(Attachment $attachment)
    {
        Storage::delete($attachment->realpath);
        $attachment->delete();
    }
}
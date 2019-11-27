<?php

namespace App\Services;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public $file;
    public $disk;

    /**
     * FileService constructor.
     * @param array|null $file
     * @param string $disk
     */
    public function __construct(?array $file, string $disk = 'public')
    {
        $this->disk = $disk;
        $this->file = $file;
    }

    /**
     * @return bool
     */
    public function isImage(): bool
    {
        return strpos($this->getMimeType(), 'image') !== false;
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->file['mime_type'] ?? '';
    }

    /**
     * @param UploadedFile $file
     * @return array
     */
    public static function save(UploadedFile $file)
    {
        $path = $file->storePubliclyAs('uploads', $file->hashName(), ['disk' => 'public']);

        return [
            'mime_type' => $file->getMimeType(),
            'name' => $file->getClientOriginalName(),
            'url' => $path,
        ];
    }

    /**
     * @return array
     */
    public function toArray()
    {
        if (!$this->file) {
            return [];
        }

        $file = [];

        $file['url'] = Storage::disk($this->disk)->url($this->file['url']);
        $file['mime_type'] = $this->getMimeType();
        $file['is_image'] = $this->isImage();

        if (!$this->isImage()) {
            $file['name'] = $this->file['name'];
        }

        return $file;
    }
}

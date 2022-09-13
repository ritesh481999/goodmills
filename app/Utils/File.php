<?php

namespace App\Utils;

use Storage;
use Illuminate\Http\UploadedFile;

class File
{
    private $storage;
    private $disk;
    private $path;

    private function __construct(string $disk, string $path = null)
    {
        $this->setDisk($disk);
        if(!empty($path))
            $this->setFilePath($path);
    }

    public function setFilePath(string $path)
    {
        $this->path = self::storageFriendlyPath($path);
        return $this;
    }

    public function setDisk(string $disk)
    {
        $this->disk = $disk;
        $this->storage = Storage::disk($disk);
        return $this;
    }

    public function upload(UploadedFile $file, string $prefix = '')
    {
        $extension = $file->getClientOriginalExtension() ?? 'jpg';
        $folder = $this->path . '/';
        $fileName = self::createFileName($extension, $prefix);
        
        while($this->storage->exists($folder.$fileName))
        {
            // break while loop when file not found
            $fileName = self::createFileName($extension, $prefix);
        }
        
        $this->storage->putFileAs($folder, $file, $fileName);
        
        return $folder . $fileName;
    }

    public function url(int $expiresIn = null): string
    {
        if(in_array($this->disk, ['public', 's3']) )
            return $this->storage->url($this->path); 
        
        $url = [
            'path' => $this->path,
            'disk' => $this->disk,
            'expiresIn' => now()->addMinutes($expiresIn)->timestamp
        ];
        return route('getFileFromUrl', encrypt($url));
    }

    public function destroy()
    {
        return $this->storage->exists($this->path) && $this->storage->delete($this->path);
    }

    public function download($headers = [])
    {
        $this->storage->download($this->path, $headers);
    }

    static public function storageFriendlyPath(string $path): string
    {
        if(substr($path, 0, 1) == '/')
            $path = substr($path, 1);
        return $path;
    }

    static private function createFileName(string $extension, string $prefix = ''): string
    {
        if(!empty($prefix))
            $prefix.='-';
        return  $prefix.str_random(10).'.'.$extension;
    }

    static public function make(string $path, string $disk = null)
    {
        if(empty($disk))
            $disk = env('FILESYSTEM_DRIVER', 'public');
        return new self($disk, $path);
    }
}

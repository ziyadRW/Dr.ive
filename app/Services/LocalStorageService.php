<?php
namespace App\Services;

use App\Interfaces\StorageInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LocalStorageService implements StorageInterface
{
    public function store(string $uniqueIdentifier, string $data): void
    {
        Storage::disk('local')->put($uniqueIdentifier, $data);
    }

    public function retrieve(string $uniqueIdentifier): string
    {
        return Storage::disk('local')->get($uniqueIdentifier);
    }
}

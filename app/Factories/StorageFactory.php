<?php
namespace App\Factories;

use App\Enums\StorageType;
use App\Services\LocalStorageService;
use App\Services\S3StorageService;
use App\Services\DatabaseStorageService;
use App\Interfaces\StorageInterface;
use Illuminate\Support\Facades\Log;

class StorageFactory
{
    public static function make(string $type): StorageInterface
    {
        switch ($type) {
            case 's3':
                return new S3StorageService();

            case 'database':
                return new DatabaseStorageService();

            case 'local':
                return new LocalStorageService();

            default:
                throw new \InvalidArgumentException("Invalid storage type: {$type}");
        }
    }

}

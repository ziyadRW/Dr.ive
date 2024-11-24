<?php
namespace App\Factories;

use App\Enums\StorageType;
use App\Services\LocalStorageService;
use App\Services\S3StorageService;
use App\Services\DatabaseStorageService;

class StorageFactory
{
    public static function make(string $type)
    {
        switch ($type) {
            case StorageType::S3:
                return new S3StorageService();

            case StorageType::DATABASE:
                return new DatabaseStorageService();

            default:
                return new LocalStorageService();
        }
    }
}

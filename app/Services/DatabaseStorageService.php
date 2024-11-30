<?php
namespace App\Services;

use App\Interfaces\StorageInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DatabaseStorageService implements StorageInterface
{
    public function store(string $uniqueIdentifier, string $data): void
    {
        DB::table('ive_data')->insert([
            'unique_identifier' => $uniqueIdentifier,
            'data' => $data,
        ]);
    }

    public function retrieve(string $uniqueIdentifier): string
    {
        $result = DB::table('ive_data')->where('unique_identifier', $uniqueIdentifier)->first();

        if (!$result) {
            throw new \Exception("Data not found");
        }

        return $result->data;
    }
}

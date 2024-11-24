<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ive extends Model
{
    use HasFactory;

    protected $fillable = ['unique_identifier', 'type', 'size', 'storage'];

    public static function saveMetadata(string $uniqueIdentifier, string $storage)
    {
        self::create([
            'unique_identifier' => $uniqueIdentifier,
            'storage' => $storage,
            'size' => 0,
        ]);
    }

    public static function findByUniqueIdentifier(string $uniqueIdentifier)
    {
        return self::where('unique_identifier', $uniqueIdentifier)->first();
    }
}

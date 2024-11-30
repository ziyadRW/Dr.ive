<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ive extends Model
{
    use HasFactory;

    protected $table = 'ives_metadata';
    protected $fillable = ['unique_identifier', 'type', 'size', 'storage', 'filename', 'filetype'];

    public static function saveMetadata(string $uniqueIdentifier, string $storageType, array $metadata)
    {
        self::create([
            'unique_identifier' => $uniqueIdentifier,
            'storage' => $storageType,
            'filename' => $metadata['filename'],
            'filetype' => $metadata['filetype'],
            'size' => $metadata['size'],
        ]);
    }

    public static function findByUniqueIdentifier(string $uniqueIdentifier)
    {
        return self::where('unique_identifier', $uniqueIdentifier)->first();
    }
}

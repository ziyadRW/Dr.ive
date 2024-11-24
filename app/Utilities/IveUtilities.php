<?php
namespace App\Utilities;

use App\Enums\StorageType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IveUtilities
{
    public static function validateStore(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'unique_identifier' => 'required|string|unique:ives,unique_identifier',
            'data' => 'required|string',
            'storage' => 'nullable|in:local,s3,database',
        ]);

        if ($validator->fails()) {
            abort(400, $validator->errors()->first());
        }

        return $validator->validated();
    }

    public static function decodeData(string $data): string
    {
        $decoded = base64_decode($data, true);
        if ($decoded === false) {
            abort(400, 'invalid base64 data');
        }
        return $decoded;
    }
}

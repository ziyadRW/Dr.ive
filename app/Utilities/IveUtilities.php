<?php
namespace App\Utilities;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class IveUtilities
{
    public static function validateStore(Request $request): array
    {
        $hasFile = $request->hasFile('file');
        $rules = [
            'unique_identifier' => [
                'required',
                'string',
                'unique:ives_metadata,unique_identifier',
            ],
            'storage' => 'nullable|in:local,s3,database',
        ];

        if ($hasFile) {
            $rules['file'] = 'required|file|max:20480|mimes:jpeg,png,jpg,pdf,docx';
        } else {
            $rules['data'] = 'required|string';
        }

        $input = $request->all();
        if ($hasFile) {
            unset($input['data']);
        }

        $validator = Validator::make($input, $rules, [
            'unique_identifier.required' => 'The unique identifier field is mandatory.',
            'unique_identifier.unique' => 'The unique identifier must be unique.',
            'data.required' => 'The data field is mandatory if no file is provided.',
            'data.string' => 'The data field must be a string.',
            'file.required' => 'The file field is mandatory if no data is provided.',
            'file.file' => 'The file must be a valid file.',
            'file.max' => 'The file size must not exceed 20MB.',
            'file.mimes' => 'The file must be one of the allowed types: jpeg, png, jpg, pdf, docx.',
            'storage.in' => 'The storage field must be one of the following: local, s3, or database.',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed: ' . $validator->errors()->first());
            abort(400, $validator->errors()->first());
        }

        return $validator->validated();
    }

    public static function decodeData(string $data): string
    {
        $decoded = base64_decode($data, true);
        if ($decoded === false) {
            abort(400, 'Invalid base64 data.');
        }
        return $decoded;
    }
}

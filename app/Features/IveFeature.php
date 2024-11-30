<?php
namespace App\Features;

use App\Models\Ive;
use App\Utilities\IveUtilities;
use App\Factories\StorageFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IveFeature
{
    public function store(Request $request)
    {
        $validated = IveUtilities::validateStore($request);
        $uniqueIdentifier = data_get($validated, 'unique_identifier');
        $storageType = data_get($validated, 'storage') ?? env('STORAGE_BACKEND');
        $decodedData = null;
        $metadata = [
            'filename' => $request->input('filename') ?? null,
            'filetype' => null,
            'size' => null,
        ];
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $decodedData = file_get_contents($file->getRealPath());
            $metadata['filename'] = $file->getClientOriginalName();
            $metadata['filetype'] = $file->getClientMimeType();
            $metadata['size'] = $file->getSize();
        } elseif ($data = data_get($validated, 'data')) {
            $decodedData = IveUtilities::decodeData($data);
            $finfo = finfo_open();
            $mimeType = finfo_buffer($finfo, $decodedData, FILEINFO_MIME_TYPE);
            finfo_close($finfo);
            $metadata['filetype'] = $mimeType;
            $metadata['size'] = strlen($decodedData);
            if (!$metadata['filename']) {
                $metadata['filename'] = $mimeType === 'application/pdf' ? 'file.pdf' : 'text.txt';
            }
        } else {
            abort(400, 'No valid data or file provided.');
        }
        $encodedData = base64_encode($decodedData);
        $storageHandler = StorageFactory::make($storageType);
        $storageHandler->store($uniqueIdentifier, $encodedData);
        Ive::saveMetadata($uniqueIdentifier, $storageType, $metadata);

        return response()->json(['message' => 'IVE stored successfully'], 201);
    }
    public function show($uniqueIdentifier, Request $request)
    {
        $ive = Ive::findByUniqueIdentifier($uniqueIdentifier);

        if (!$ive) {
            return response()->json(['error' => 'IVE not found'], 404);
        }

        $storageHandler = StorageFactory::make($ive->storage);
        $encodedData = $storageHandler->retrieve($ive->unique_identifier);
        $decodedData = base64_decode($encodedData, true);
        if ($decodedData === false) {
            return response()->json(['error' => 'Failed to decode data'], 500);
        }
        $isText = $ive->filetype === 'text/plain';
        $response = [
            'id' => $ive->unique_identifier,
            'size' => $ive->size,
            'created_at' => $ive->created_at,
            'data_type' => $isText ? 'text' : 'file',
        ];

        if ($isText) {
            $response['data'] = $decodedData;
        } else {
            $response['filename'] = $ive->filename;
            $response['filetype'] = $ive->filetype;
            $response['data'] = base64_encode($decodedData);

        }

        return response()->json($response);
    }
}

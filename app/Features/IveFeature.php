<?php
namespace App\Features;

use App\Models\Ive;
use App\Utilities\IveUtilities;
use App\Factories\StorageFactory;
use Illuminate\Http\Request;

class IveFeature
{
    public function store(Request $request)
    {
        $validated = IveUtilities::validateStore($request);
        $uniqueIdentifier = data_fetch($validated, 'unique_identifier');
        $data = data_fetch($validated, 'data');
        $storageType = (data_fetch($validated, 'data'))  ?? config('app.STORAGE_BACKEND');
        $decodedData = IveUtilities::decodeData($data);
        $storageHandler = StorageFactory::make($storageType);
        $storageHandler->store($uniqueIdentifier, $decodedData);

        Ive::saveMetadata($uniqueIdentifier, $storageType);

        return response()->json(['message' => 'IVE stored successfully'], 201);
    }

    public function show($uniqueIdentifier)
    {
        $ive = Ive::findByUniqueIdentifier($uniqueIdentifier);

        if (!$ive) {
            return response()->json(['error' => 'IVE not found'], 404);
        }

        $storageHandler = StorageFactory::make($ive->storage);
        $data = $storageHandler->retrieve($ive->unique_identifier);

        return response()->json([
            'id' => $ive->unique_identifier,
            'type' => $ive->type,
            'data' => base64_encode($data),
            'size' => $ive->size,
            'created_at' => $ive->created_at,
        ]);
    }
}

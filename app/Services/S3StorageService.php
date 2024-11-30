<?php

namespace App\Services;

use App\Interfaces\StorageInterface;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Illuminate\Support\Facades\Log;

class S3StorageService implements StorageInterface
{
    private $client;
    private $bucket;

    public function __construct()
    {
        $this->client = new S3Client([
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'version' => 'latest',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        $this->bucket = env('AWS_BUCKET');
    }

    public function store(string $uniqueIdentifier, string $data): void
    {
        try {
            $result = $this->client->putObject([
                'Bucket' => $this->bucket,
                'Key' => $uniqueIdentifier,
                'Body' => $data,
                'ContentType' => 'application/octet-stream',
            ]);

        } catch (AwsException $e) {
            throw new \Exception("failed to store file in S3");
        }
    }

    public function retrieve(string $uniqueIdentifier): string
    {
        try {
            $result = $this->client->getObject([
                'Bucket' => $this->bucket,
                'Key' => $uniqueIdentifier,
            ]);

            return $result['Body']->getContents();
        } catch (AwsException $e) {
            throw new \Exception("failed to retrieve file from S3");
        }
    }
}

<?php
namespace App\Enums;

enum StorageType: string
{
    case LOCAL = 'local';
    case S3 = 's3';
    case DATABASE = 'database';
}

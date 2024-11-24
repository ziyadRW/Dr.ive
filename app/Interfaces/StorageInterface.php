<?php
namespace App\Interfaces;

interface StorageInterface
{

    public function store(string $uniqueIdentifier, string $data): void;


    public function retrieve(string $uniqueIdentifier): string;
}

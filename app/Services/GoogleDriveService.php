<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Illuminate\Support\Facades\Storage;

class GoogleDriveService
{
    protected $client;
    protected $drive;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
        $this->client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
        $this->client->refreshToken(env('GOOGLE_DRIVE_REFRESH_TOKEN'));
        $this->client->setScopes([Drive::DRIVE_FILE]);

        $this->drive = new Drive($this->client);
    }

    public function uploadFile($filePath, $fileName)
    {
        $file = new Drive\DriveFile();
        $file->setName($fileName);
        $file->setParents([env('GOOGLE_DRIVE_FOLDER_ID')]);

        $content = file_get_contents($filePath);
        $uploadedFile = $this->drive->files->create($file, [
            'data' => $content,
            'mimeType' => 'application/pdf',
            'uploadType' => 'multipart',
            'fields' => 'id'
        ]);

        return $uploadedFile->id;
    }
}

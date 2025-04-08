<?php

namespace App\Classes;

use Illuminate\Support\Facades\Http;

class SupabaseStorage
{
  private $supabaseUrl;
  private $apiKey;
  private $bucketName;

  public function __construct()
  {
    $this->supabaseUrl = env('SUPABASE_URL');
    $this->apiKey = env('SUPABASE_API_KEY');
    $this->bucketName = 'huggy';
  }

  public function uploadImage($file, $folder = 'default')
  {
    $timestamp = time();
    $extension = $file->getClientOriginalExtension();
    $fileName = $timestamp . '.' . $extension;
    $filepath =  $folder . '/' . $fileName;

    $response = Http::withHeaders([
      'Authorization' => 'Bearer ' . $this->apiKey,
    ])
      ->attach('file', $file->get(), $fileName)
      ->post(
        "{$this->supabaseUrl}/storage/v1/object/{$this->bucketName}/{$filepath}"
      );
    if ($response->successful()) {
      return "{$this->supabaseUrl}/storage/v1/object/{$this->bucketName}/{$filepath}";
    } else {
      // throw new \Exception('Failed to upload image to Supabase: ' . $response->body());
    }
  }

  public function deleteImage($url)
  {
    if (str_starts_with($url, $this->supabaseUrl)) {
      $pattern = "{$this->supabaseUrl}/storage/v1/object/{$this->bucketName}/";
      $filepath = str_replace($pattern, '', $url);
    } else {
      $filepath = $url;
    }

    $response = Http::withHeaders([
      'Authorization' => 'Bearer ' . $this->apiKey,
    ])
      ->delete(
        "{$this->supabaseUrl}/storage/v1/object/{$this->bucketName}/{$filepath}"
      );

    if ($response->successful()) {
      return true;
    } else {
      return false;
      // throw new \Exception('Failed to delete image from Supabase: ' . $response->status() . ' - ' . $response->body());
    }
  }

  public function listImages()
  {
    $response = Http::withHeaders([
      'Authorization' => 'Bearer ' . $this->apiKey,
    ])
      ->get("{$this->supabaseUrl}/storage/v1/bucket/{$this->bucketName}/objects");

    if ($response->successful()) {
      return $response->json();
    } else {
      throw new \Exception('Failed to list images from Supabase: ' . $response->body());
    }
  }
  public function getSignedUrl($fileName)
  {
    $response = Http::withHeaders([
      'Authorization' => 'Bearer ' . $this->apiKey,
    ])
      ->post("{$this->supabaseUrl}/storage/v1/object/sign/{$this->bucketName}/{$fileName}", [
        "expiresIn" => 3600, // URL expira em 1 hora
      ]);

    if ($response->successful()) {
      return $response->json()['signedURL'];
    } else {
      throw new \Exception('Failed to retrieve signed URL from Supabase: ' . $response->body());
    }
  }
}

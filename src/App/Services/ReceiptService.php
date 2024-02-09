<?php

declare(strict_types=1);

namespace App\Services;

use App\Config\Paths;
use Framework\Database;
use Framework\Exceptions\ValidationException;

class ReceiptService
{
  public function __construct(private Database $db)
  {
  }

  public function validateFile(?array $file)
  {
    if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
      throw new ValidationException(['receipt' => ['Faied to upload files']]);
    }

    $maxFileSizeMB = 3 * 1024 * 1024;

    if ($file['size'] > $maxFileSizeMB) {
      throw new ValidationException(['receipt' => ["Uploaded file is to large"]]);
    }

    $originalFilName = $file['name'];
    if (!preg_match('/^[A-Za-z0-9\s._-]+$/', $originalFilName)) {
      throw new ValidationException(['receipt' => ["Invalid Filename"]]);
    }

    $clientMimeType = $file['type'];
    $allowedMimeType = ['image/jpeg', 'image/png', 'application/pdf'];
    if (!in_array($clientMimeType, $allowedMimeType)) {
      throw new ValidationException(['receipt' => ['Invalid file type']]);
    }
  }
  public function upload(array $file, int $id)
  {
    $fileExtention = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newFileName = bin2hex(random_bytes(16)) . "." . $fileExtention;

    $uploadPath = Paths::STORAGE_UPLOADS . '/' . $newFileName;

    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
      throw new ValidationException(['receipt' => ['Failed to upload file']]);
    }
    $this->db->query(
      "insert into receipts (transaction_id, original_filename, storage_filename, media_type) values (:transaction_id, :original_filename, :storage_filename, :media_type)",
      [
        'transaction_id' => $id,
        'original_filename' => $file['name'],
        'storage_filename' => $newFileName,
        'media_type' => $file['type']
      ]
    );
  }
  public function getReceipt(string $id)
  {
    $receipt = $this->db->query(
      "select * from receipts where id = :id",
      ['id' => $id]
    )->find();

    return $receipt;
  }
  public function read(array $receipt)
  {
    $filePath = Paths::STORAGE_UPLOADS . '/' . $receipt['storage_filename'];

    if (!file_exists($filePath)) {
      redirectTo('/');
    }
    header("Content-Disposition: inline;filename={$receipt['original_filename']}");
    header("Content-Type: {$receipt['media_type']}");
    readfile($filePath);
  }

  public function delete(array $receipt)
  {
    $filePath = Paths::STORAGE_UPLOADS . '/' . $receipt['storage_filename'];
    unlink($filePath);
    $this->db->query("delete from receipts where id = :id", ['id' => $receipt['id']]);
  }
}

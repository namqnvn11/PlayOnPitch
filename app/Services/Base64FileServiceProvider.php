<?php

namespace App\Services;

use App\Models\Image;

class Base64FileServiceProvider
{

    //lưu mới hình ảnh
    public function saveFileToDb(string $filePath, string $owner, $ownerId)
    {
        if (!file_exists($filePath)) {
            throw new \Exception('File not exist.');
        }

        // Đọc nội dung file
        $fileContent = file_get_contents($filePath);

        // Mã hóa Base64
        $base64Data = base64_encode($fileContent);

        // Lưu vào cơ sở dữ liệu
        $newImage= Image::create([
            'img' => 'data:image/jpeg;base64,'.$base64Data,
            $owner.'_id'=>$ownerId
        ]);
        return $newImage;
    }

//    public function updateAnImage(string $filePath, string $owner, $ownerId)
//    {
//        if (!file_exists($filePath)) {
//            throw new \Exception('File not exist.');
//        }
//        // Đọc nội dung file
//        $fileContent = file_get_contents($filePath);
//        // Mã hóa Base64
//        $base64Data = base64_encode($fileContent);
//        $image= Image::where($owner.'_id', $ownerId)->first();
//        $image->update([
//            'img' => $base64Data
//        ]);
//        return $image;
//    }

    //update image by image id
    public function updateById(string $filePath, $imageId)
    {
        // Đọc nội dung file
        $fileContent = file_get_contents($filePath);
        // Mã hóa Base64
        $base64Data = base64_encode($fileContent);
        $image= Image::find($imageId);
        $image->update([
            'img' => 'data:image/jpeg;base64,'.$base64Data
        ]);
        return $image;
    }

    //get img bằng id
    public function getFileFromDb(int $id): string|null
    {
        $file = Image::find($id);
        if (!$file) {
            return null;
        }
        return  $file->img;
    }

    /**
     * Tải file từ database và lưu vào ổ đĩa.
     *
     * @param int $id ID của file trong database.
     * @param string $savePath Đường dẫn lưu file.
     * @return string|null Đường dẫn file đã lưu.
     */
    public function saveFileToDisk(int $id):?array
    {
        // Lấy file từ database
        $fileData = $this->getFileFromDb($id);

        if (!$fileData) {
            return null;
        }

        // Tạo đường dẫn lưu file
        $fileName = uniqid() . '.jpg';
        $savePath = public_path('images/' . $fileName);

        // Đảm bảo thư mục tồn tại, nếu không sẽ tạo
        if (!file_exists(public_path('images'))) {
            mkdir(public_path('images'), 0755, true);
        }

        // Lưu file ra đĩa
        file_put_contents($savePath, $fileData);

        // Trả về URL công khai của file
        return [
            'path'=>$savePath,
            'url'=>asset('images/' . $fileName)
        ];
    }


    /**
     * Xóa file khỏi ổ đĩa và cơ sở dữ liệu nếu cần.
     *
     * @param string|null $filePath Đường dẫn file cần xóa.
     * @param int|null $fileId ID của file trong cơ sở dữ liệu (nếu có).
     * @return bool Trả về `true` nếu xóa thành công, `false` nếu thất bại.
     */
    public function deleteFileFromDisk(string $filePath = null): bool
    {
        try {
            if ($filePath && file_exists($filePath)) {
                unlink($filePath); // Xóa file vật lý
                return true;
            }
            throw new \Exception('File not exist on disk.');
        } catch (\Exception $e) {
            \Log::error('Error when delete file: ' . $e->getMessage());
            return false;
        }
    }

}


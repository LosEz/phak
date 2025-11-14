<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UpdatePriceController extends Controller
{
    public function show()
    {
        $latestFile = Document::latest()->first();

        // 2. กรณีไม่พบไฟล์เลย
        if (!$latestFile) {
            abort(404, 'ยังไม่มีไฟล์อัปโหลดในระบบ');
        }

        // 3. สร้าง Public URL จาก 'file_path' (ตามรูปของคุณ)
        //$publicUrl = Storage::url($latestFile->id);

        $publicUrl = "documents/" . $latestFile->id;

        // 4. ส่งไปที่ View
        return view('updateprice', [
            'file' => $latestFile,
            'publicUrl' => $publicUrl,
        ]);
    }
}
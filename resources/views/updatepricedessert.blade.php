<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>แสดงไฟล์ล่าสุด</title>
    <meta http-equiv="refresh" content="300"> <style>
        body { font-family: sans-serif; margin: 0; padding: 0; }
        .header { background: #f4f4f4; padding: 15px; border-bottom: 1px solid #ddd; }
        .preview { border: 1px solid #ccc; width: 100%; height: 90vh; }
        .info { font-size: 0.9em; color: #555; }
    </style>
</head>
<body>
    <div class="header">
        <h3>ไฟล์ล่าสุด: {{ $file->title }}</h3>
        <div class="info">
            <strong>Original Name:</strong> {{ $file->original_name }}<br>
            <strong>Updated At:</strong> {{ $file->created_at->format('d M Y, H:i:s') }}
        </div>
    </div>

    @if (Str::endsWith(strtolower($file->file_path), '.pdf'))
        <iframe src="{{ $publicUrl }}" class="preview" title="PDF Viewer"></iframe>
        
    @elseif (Str::of(strtolower($file->file_path))->endsWith(['.jpg', '.jpeg', '.png', '.gif', '.webp']))
                <img src="{{ $publicUrl }}" alt="{{ $file->original_name }}" style="max-width: 100%;">
        
    @else
        <div style="padding: 20px;">
            <p>ไม่สามารถแสดง Preview ไฟล์ประเภทนี้ได้</p>
            <a href="{{ $publicUrl }}" download>ดาวน์โหลดไฟล์ ({{ $file->original_name }})</a>
        </div>
    @endif

</body>
</html>
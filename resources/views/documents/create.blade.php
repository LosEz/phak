<!DOCTYPE html>
<html>
<head>
<title>Phak U Dee</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<style>
body,h1 {font-family: "Raleway", sans-serif}
body, html {height: 100%}
.bgimg {
  background-image: url('/images/bg.jpeg');
  min-height: 100%;
  background-position: center;
  background-size: cover;
}
</style>
</head>
<body>

<div class="container">
    <h1>Upload PDF Document</h1>
    
    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group mb-3">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <button onclick="window.print()" class="btn btn-outline-secondary">
                <i class="fas fa-print"></i> Print List
            </button>
        </div>

        <div class="mb-3">
            <button type="button" id="scanButton" class="btn btn-success">Scan Document</button>
            <div id="scannerContainer" style="width:100%; height:400px; display:none;"></div>
            <div id="scanResult" class="mt-2"></div>
        </div>
        
        <div class="form-group mb-3">
            <label for="file">PDF File</label>
            <input type="file" name="file" id="file" class="form-control" accept=".pdf" required>
            <small class="form-text text-muted">Max file size: 2MB</small>
        </div>
        
        <button type="submit" class="btn btn-primary">Upload</button>
        <a href="{{ route('documents.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script src="https://unpkg.com/dwt@18.4.0/dist/dynamsoft.webtwain.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const scanButton = document.getElementById('scanButton');
    const scannerContainer = document.getElementById('scannerContainer');
    const scanResult = document.getElementById('scanResult');
    const fileInput = document.getElementById('file');
    
    scanButton.addEventListener('click', async function() {
        try {
            // Initialize the scanner
            const DWObject = await Dynamsoft.DWT.Load();
            
            // Create scanner instance
            scannerContainer.style.display = 'block';
            const scanner = await DWObject.CreateDWTObject(scannerContainer);
            
            // Configure scanner
            scanner.SelectSource();
            scanner.IfDisableSourceAfterAcquire = true;
            scanner.IfUI = true;
            
            // Start scanning
            scanner.AcquireImage(
                function() {
                    // On success
                    scanResult.innerHTML = '<div class="alert alert-success">Document scanned successfully!</div>';
                    
                    // Convert scanned images to PDF
                    scanner.ConvertToBlob(
                        [scanner.CurrentImageIndexInBuffer],
                        Dynamsoft.DWT.EnumDWT_ImageType.IT_PDF,
                        function(result) {
                            // Create a file from the blob
                            const file = new File([result], `scanned_${Date.now()}.pdf`, {
                                type: 'application/pdf'
                            });
                            
                            // Update the file input
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(file);
                            fileInput.files = dataTransfer.files;
                        },
                        function(error) {
                            console.error('PDF conversion failed:', error);
                            scanResult.innerHTML = '<div class="alert alert-danger">PDF conversion failed</div>';
                        }
                    );
                },
                function(error) {
                    // On error
                    console.error('Scanning failed:', error);
                    scanResult.innerHTML = '<div class="alert alert-danger">Scanning failed</div>';
                }
            );
        } catch (error) {
            console.error('Scanner initialization failed:', error);
            scanResult.innerHTML = '<div class="alert alert-danger">Scanner not available. Please check if the scanner is connected and drivers are installed.</div>';
        }
    });
});
</script>

</body>



</html>

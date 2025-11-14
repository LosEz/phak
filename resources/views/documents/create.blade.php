<!DOCTYPE html>
<html>
<head>
<title>Phak U Dee</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
:root {
  --primary-color: #4a6fa5;
  --secondary-color: #6c757d;
  --accent-color: #5cb85c;
  --light-bg: #f8f9fa;
  --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

body {
  font-family: "Raleway", sans-serif;
  background-color: var(--light-bg);
  color: #333;
  line-height: 1.6;
}

.container {
  max-width: 800px;
  margin: 40px auto;
  padding: 30px;
  background: white;
  border-radius: 10px;
  box-shadow: var(--card-shadow);
}

h1 {
  color: var(--primary-color);
  text-align: center;
  margin-bottom: 30px;
  font-weight: 600;
}

.form-group {
  margin-bottom: 25px;
}

.form-control {
  height: 45px;
  border-radius: 5px;
  border: 1px solid #ced4da;
  transition: border-color 0.3s, box-shadow 0.3s;
}

.form-control:focus {
  border-color: var(--primary-color);
  box-shadow: 0 0 0 0.25rem rgba(74, 111, 165, 0.25);
}

.btn {
  padding: 10px 20px;
  border-radius: 5px;
  font-weight: 500;
  transition: all 0.3s;
}

.btn-primary {
  background-color: var(--primary-color);
  border-color: var(--primary-color);
}

.btn-primary:hover {
  background-color: #3a5a8f;
  border-color: #3a5a8f;
}

.btn-success {
  background-color: var(--accent-color);
  border-color: var(--accent-color);
}

.btn-success:hover {
  background-color: #4cae4c;
  border-color: #4cae4c;
}

.btn-secondary {
  background-color: var(--secondary-color);
  border-color: var(--secondary-color);
}

.btn-outline-secondary {
  border-color: var(--secondary-color);
  color: var(--secondary-color);
}

.btn-outline-secondary:hover {
  background-color: var(--secondary-color);
  color: white;
}

.alert {
  padding: 12px;
  border-radius: 5px;
  margin-top: 15px;
}

#scannerContainer {
  border: 2px dashed #ddd;
  border-radius: 8px;
  margin-top: 15px;
  background-color: #f9f9f9;
}

.file-input-label {
  display: block;
  margin-bottom: 8px;
  font-weight: 500;
  color: #495057;
}

.file-input-info {
  font-size: 0.875rem;
  color: #6c757d;
  margin-top: 5px;
}

.button-group {
  display: flex;
  gap: 10px;
  margin-top: 25px;
}

@media (max-width: 768px) {
  .container {
    padding: 20px;
    margin: 20px;
  }
  
  .button-group {
    flex-direction: column;
  }
  
  .btn {
    width: 100%;
    margin-bottom: 10px;
  }
}
</style>
</head>
<body>

<div class="container">
    <h1>Upload PDF Document</h1>
    
    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="title" class="file-input-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Enter document title" required>
        </div>

        <div class="form-group">
            <label for="typeBy" class="file-input-label">Type By</label>
             <select name="typeBy" id="typeBy" class="form-control">
                <option value="P">Phak</option>
                <option value="D">Desert</option>
              </select>
        </div>

        <div class="form-group">
            <label class="file-input-label">Actions</label>
            <div class="d-flex gap-2">
                <button type="button" onclick="window.print()" class="btn btn-outline-secondary">
                    <i class="fas fa-print me-2"></i>Print List
                </button>
                <button type="button" id="scanButton" class="btn btn-success">
                    <i class="fas fa-scanner me-2"></i>Scan Document
                </button>
            </div>
            <div id="scannerContainer"></div>
            <div id="scanResult" class="mt-3"></div>
        </div>
        
        <div class="form-group">
            <label for="file" class="file-input-label">PDF File</label>
            <input type="file" name="file" id="file" class="form-control" accept=".pdf" required>
            <small class="file-input-info">Max file size: 2MB. Accepted format: PDF only.</small>
        </div>
        
        <div class="button-group">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-upload me-2"></i>Upload
            </button>
            <a href="{{ route('documents.index') }}" class="btn btn-secondary">
                <i class="fas fa-times me-2"></i>Cancel
            </a>
        </div>
    </form>
</div>

<script src="https://unpkg.com/dwt@18.4.0/dist/dynamsoft.webtwain.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
            scannerContainer.innerHTML = '<div class="text-center py-4"><i class="fas fa-spinner fa-spin me-2"></i>Initializing scanner...</div>';
            
            const scanner = await DWObject.CreateDWTObject(scannerContainer);
            
            // Configure scanner
            scanner.SelectSource();
            scanner.IfDisableSourceAfterAcquire = true;
            scanner.IfUI = true;
            
            // Start scanning
            scanner.AcquireImage(
                function() {
                    // On success
                    scanResult.innerHTML = '<div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>Document scanned successfully!</div>';
                    
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
                            
                            // Show success message
                            scanResult.innerHTML += '<div class="alert alert-info mt-2"><i class="fas fa-info-circle me-2"></i>Scanned document has been prepared for upload.</div>';
                        },
                        function(error) {
                            console.error('PDF conversion failed:', error);
                            scanResult.innerHTML = '<div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i>PDF conversion failed</div>';
                        }
                    );
                },
                function(error) {
                    // On error
                    console.error('Scanning failed:', error);
                    scanResult.innerHTML = '<div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i>Scanning failed. Please try again.</div>';
                }
            );
        } catch (error) {
            console.error('Scanner initialization failed:', error);
            scanResult.innerHTML = '<div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i>Scanner not available. Please check if the scanner is connected and drivers are installed.</div>';
        }
    });
});
</script>

</body>
</html>
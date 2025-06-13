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
        
        <div class="form-group mb-3">
            <label for="file">PDF File</label>
            <input type="file" name="file" id="file" class="form-control" accept=".pdf" required>
            <small class="form-text text-muted">Max file size: 2MB</small>
        </div>
        
        <button type="submit" class="btn btn-primary">Upload</button>
        <a href="{{ route('documents.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</body>
</html>

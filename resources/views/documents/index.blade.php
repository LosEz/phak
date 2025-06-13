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

<style>
    :root {
        --primary-color: #4361ee;
        --primary-light: #ebf0ff;
        --secondary-color: #3a0ca3;
        --danger-color: #e63946;
        --success-color: #2ecc71;
        --light-gray: #f8f9fa;
        --medium-gray: #e9ecef;
        --dark-gray: #6c757d;
        --text-color: #2d3748;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.1);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
    }

    .document-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    .document-header {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--medium-gray);
    }

    .document-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--secondary-color);
        margin-bottom: 0.5rem;
    }

    .document-subtitle {
        color: var(--dark-gray);
        font-size: 1rem;
    }

    .document-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .btn-document {
        padding: 0.625rem 1.25rem;
        border-radius: 6px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: white;
    }

    .btn-primary:hover {
        background-color: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-outline-secondary {
        background-color: white;
        color: var(--primary-color);
        border: 1px solid var(--primary-color);
    }

    .btn-outline-secondary:hover {
        background-color: var(--primary-light);
    }

    .badge-count {
        background-color: var(--primary-light);
        color: var(--primary-color);
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
    }

    .document-table {
        width: 100%;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        border-collapse: separate;
        border-spacing: 0;
    }

    .document-table thead {
        background-color: var(--primary-light);
    }

    .document-table th {
        padding: 1rem 1.25rem;
        text-align: left;
        color: var(--secondary-color);
        font-weight: 600;
        border-bottom: 2px solid var(--medium-gray);
    }

    .document-table td {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--medium-gray);
        vertical-align: middle;
    }

    .document-table tr:last-child td {
        border-bottom: none;
    }

    .document-table tr:hover {
        background-color: var(--primary-light);
    }

    .btn-action {
        padding: 0.375rem 0.75rem;
        border-radius: 4px;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .btn-info {
        background-color: #e6f7ff;
        color: var(--primary-color);
        border: 1px solid #b3e0ff;
    }

    .btn-info:hover {
        background-color: #ccefff;
    }

    .btn-secondary {
        background-color: #f8f9fa;
        color: var(--dark-gray);
        border: 1px solid var(--medium-gray);
    }

    .btn-secondary:hover {
        background-color: #e9ecef;
    }

    .btn-danger {
        background-color: #fff5f5;
        color: var(--danger-color);
        border: 1px solid #ffd6d6;
    }

    .btn-danger:hover {
        background-color: #ffecec;
    }

    .action-group {
        display: flex;
        gap: 0.5rem;
    }

    .empty-state {
        padding: 3rem 1rem;
        text-align: center;
        color: var(--dark-gray);
    }

    .empty-state i {
        font-size: 3rem;
        color: var(--medium-gray);
        margin-bottom: 1rem;
    }

    .alert-success {
        background-color: #f0fff4;
        color: #2f855a;
        border: 1px solid #c6f6d5;
        padding: 1rem;
        border-radius: 6px;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 768px) {
        .document-actions {
            flex-direction: column;
            align-items: flex-start;
        }

        .document-table {
            display: block;
            overflow-x: auto;
        }

        .action-group {
            flex-wrap: wrap;
        }
    }

    @media print {
        .document-actions, .btn {
            display: none !important;
        }

        .document-table {
            box-shadow: none;
            border: 1px solid #ddd;
        }

        .document-table th {
            background-color: #f1f1f1 !important;
            -webkit-print-color-adjust: exact;
        }
    }
</style>

<div class="document-container">
    <div class="document-header">
        <h1 class="document-title">
            <i class="fas fa-file-pdf text-danger"></i> PDF Documents
        </h1>
        <p class="document-subtitle">Manage and view all your PDF documents in one place</p>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="document-actions">
        <a href="{{ route('documents.create') }}" class="btn-document btn-primary">
            <i class="fas fa-plus-circle"></i> Upload New PDF
        </a>
        <div style="display: flex; align-items: center; gap: 1rem;">
            <button onclick="window.print()" class="btn-document btn-outline-secondary">
                <i class="fas fa-print"></i> Print List
            </button>
            <span class="badge-count">
                <i class="fas fa-file-alt"></i> {{ $documents->count() }} documents
            </span>
        </div>
    </div>

    <table class="document-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>File Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($documents as $document)
            <tr>
                <td>
                    <strong>{{ $document->title }}</strong>
                </td>
                <td>
                    <span style="color: var(--dark-gray);">
                        <i class="far fa-file-pdf text-danger"></i> {{ $document->original_name }}
                    </span>
                </td>
                <td>
                    <div class="action-group">
                        <a href="{{ route('documents.show', $document->id) }}" 
                           target="_blank" 
                           class="btn-action btn-info">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('documents.show', $document->id) }}?print=true" 
                           target="_blank" 
                           class="btn-action btn-secondary">
                            <i class="fas fa-print"></i> Print
                        </a>
                        <form action="{{ route('documents.destroy', $document->id) }}" 
                              method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action btn-danger" 
                                    onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <h3>No documents found</h3>
                    <p>Upload your first PDF to get started</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Simple dismiss alert script -->
<script>
document.querySelectorAll('.close').forEach(button => {
    button.addEventListener('click', function() {
        this.parentElement.style.display = 'none';
    });
});
</script>

</body>
</html>

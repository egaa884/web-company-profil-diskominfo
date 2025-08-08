<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Upload Gambar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Test Upload Gambar</h4>
                    </div>
                    <div class="card-body">
                        <form id="uploadForm" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Pilih Gambar</label>
                                <input type="file" name="gambar" id="gambar" class="form-control" accept="image/jpeg,image/jpg,image/png" required>
                                <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                        
                        <div id="result" class="mt-3" style="display: none;">
                            <h5>Hasil Upload:</h5>
                            <pre id="resultData"></pre>
                            <div id="imagePreview" class="mt-2"></div>
                        </div>
                        
                        <div id="error" class="alert alert-danger mt-3" style="display: none;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const resultDiv = document.getElementById('result');
            const errorDiv = document.getElementById('error');
            const resultData = document.getElementById('resultData');
            const imagePreview = document.getElementById('imagePreview');
            
            // Reset display
            resultDiv.style.display = 'none';
            errorDiv.style.display = 'none';
            
            fetch('/test-upload', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    resultData.textContent = JSON.stringify(data, null, 2);
                    imagePreview.innerHTML = `<img src="${data.url}" class="img-fluid" style="max-width: 300px;">`;
                    resultDiv.style.display = 'block';
                } else {
                    errorDiv.textContent = data.error;
                    errorDiv.style.display = 'block';
                }
            })
            .catch(error => {
                errorDiv.textContent = 'Error: ' + error.message;
                errorDiv.style.display = 'block';
            });
        });
    </script>
</body>
</html> 
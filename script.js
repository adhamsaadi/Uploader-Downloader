document.querySelector('form').addEventListener('submit', function (e) {
  e.preventDefault();
  var files = document.getElementById('fileInput').files;
  var progressBar = document.querySelector('.progress-bar');
  var fileList = document.querySelector('.file-list');

  // Clear the file list before displaying the selected files
  fileList.innerHTML = '';

  // Iterate over selected files and display them in the file list
  for (var i = 0; i < files.length; i++) {
    var listItem = document.createElement('li');
    listItem.textContent = files[i].name;
    fileList.appendChild(listItem);
  }

  var formData = new FormData();
  for (var i = 0; i < files.length; i++) {
    formData.append('files[]', files[i]);
  }

  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'upload.php', true);

  xhr.upload.onprogress = function (e) {
    if (e.lengthComputable) {
      var percent = (e.loaded / e.total) * 100;
      progressBar.style.width = percent + '%';
      progressBar.setAttribute('aria-valuenow', percent);
    }
  };

  xhr.onload = function () {
    if (xhr.status === 200) {
      // File(s) uploaded successfully
      progressBar.style.width = '100%';
      progressBar.setAttribute('aria-valuenow', '100');
      alert('File(s) uploaded successfully!');
    } else {
      // Error occurred during upload
      var response = JSON.parse(xhr.responseText);
      alert('Error uploading file(s): ' + response.message);
    }
  };

  xhr.onerror = function () {
    alert('Error uploading file(s). Please try again.');
  };

  xhr.send(formData);
});

document.getElementById('fileInput').addEventListener('change', function (e) {
  var files = e.target.files;
  var fileList = document.querySelector('.file-list');

  // Clear the file list before displaying the selected files
  fileList.innerHTML = '';

  // Iterate over selected files and display them in the file list
  for (var i = 0; i < files.length; i++) {
    var listItem = document.createElement('li');
    listItem.textContent = files[i].name;
    fileList.appendChild(listItem);
  }
});

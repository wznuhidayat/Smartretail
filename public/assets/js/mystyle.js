function previewImg() {
    const imageItem = document.querySelector('#image');
    const imageItemLabel = document.querySelector('.custom-file-label');
    const imgPreview = document.querySelector('.img-preview');
  
    // imageItemLabel.textContent = imageItem.files[0].name;
  
    const fileImage = new FileReader();
    fileImage.readAsDataURL(imageItem.files[0]);
  
    fileImage.onload = function (e) {
      imgPreview.src = e.target.result;
    }
  }
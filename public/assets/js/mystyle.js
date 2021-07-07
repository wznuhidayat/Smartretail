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
$(document).ready(function () {
  $("#del").hide();
});
$(".rm").click(function () {
  var id = $(this).parents("tr").attr("id");
  var segment = $(this).parents("tbody").attr("id");
  swal({
    title: 'Are you sure?',
    text: 'Once deleted, you will not be able to recover this imaginary file!',
    icon: 'warning',
    buttons: true,
    dangerMode: true,
  })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: '/main/' + segment + '/delete/' + id,
          type: 'DELETE',
          error: function () {
            swal("Failed", "Data gagal di hapus", "error");
          },
          success: function (data) {
            $("#del").show();
            // $("#delete").prepend("#del");

            $("#" + id).remove();
            swal('Poof! Your imaginary file has been deleted!', {
              icon: 'success',
            });
            document.getElementById('deleted').style.display = 'block';

          }
        });
        // swal('Poof! Your imaginary file has been deleted!', {
        //   icon: 'success',
        // });
      } else {
        swal('Your imaginary file is safe!');
      }
    });
});

// $('.input-images-1').imageUploader();

$(function() {
  // Multiple images preview in browser
  var imagesPreview = function(input, placeToInsertImagePreview) {

      if (input.files) {
          var filesAmount = input.files.length;

          for (i = 0; i < filesAmount; i++) {
              var reader = new FileReader();

              reader.onload = function(event) {
                  $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
              }

              reader.readAsDataURL(input.files[i]);
          }
      }

  };

  $('#gallery-photo-add').on('change', function() {
      imagesPreview(this, 'div.gallery');
  });
});
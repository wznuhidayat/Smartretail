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

$(".rm-product").click(function () {
  var id = $(this).attr("value");
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

$(".rm-seller").click(function () {
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
          url: '/seller/' + segment + '/delete/' + id,
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

$(function () {
  // Multiple images preview in browser
  var imagesPreview = function (input, placeToInsertImagePreview) {

    if (input.files) {
      var filesAmount = input.files.length;

      for (i = 0; i < filesAmount; i++) {
        var reader = new FileReader();

        reader.onload = function (event) {
          $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview).width('100');
        }

        reader.readAsDataURL(input.files[i]);
      }
    }

  };

  $('#gallery-photo-add').on('change', function () {
    imagesPreview(this, 'div.gallery');
  });
  // var element = document.getElementById("productimg");
  // element.classList.add("h-100");

  // get Edit Product
  $('.btn-edit').on('click', function () {
    // get data from button edit
    const id = $(this).data('id');
    const name = $(this).data('name');
    const price = $(this).data('price');
    const category = $(this).data('category_id');
    // Set data to Form Edit
    $('.product_id').val(id);
    $('.product_name').val(name);
    $('.product_price').val(price);
    $('.product_category').val(category).trigger('change');
    // Call Modal Edit
    $('#editModal').modal('show');
  });
});

$(document).ready(function () {
  $(document).on('click', '#detail', function () {
    var id = $(this).data('id');
    var name = $(this).data('name');
    var price = $(this).data('price');
    var numb = price;
    var format = numb.toString().split('').reverse().join('');
    var convert = format.match(/\d{1,3}/g);
    var rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')
    if ($(this).data('img') == null) {
      $('#show_img').attr('src', 'http://localhost:8080/template/assets/img/news/img13.jpg');
    } else {
      $('#show_img').attr('src', 'http://localhost:8080/img/product/' + $(this).data('img') + '');
    }
    $('#id_product').val(id);
    $('#name_product').text(name);
    $('#price').text(rupiah);
  })
})

//datatable
// const $config_table = {}, // opsional kalaw dibutuhkan aja
  // $table = $("#select-month-range").DataTable($config_table);
  
  $('#find').on('click', load_data);
  function load_data() {
    
    var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
    var csrfHash = $('.txt_csrfname').val(); // CSRF hash
    // $table.clear().draw(); // clear table
    console.log(csrfName, csrfHash);
    $.ajax({
      url: '/NeuralNetwork/getDataMonthRange',
      method: 'POST', 
      dataType: 'json', // tipe return dari server
      data: {[csrfName]: csrfHash, data: $('#form-save-month-range').serializeArray()  },
      success: (result) => {
        var columns = [];
        var rows = [];
     
        for (var i in result) {
          var temp_rows = [];
          var temp_cols = [];
          for (var j in result[i]) {
              temp_cols.push(result[i][j]['name']);
              temp_rows.push(result[i][j]['value']);
          }
          // console.log(temp_cols);
          if (columns < 1) {
            columns.push(temp_cols);
          }
          rows.push(temp_rows);
        }
        console.log(rows);
        // ['10215179', 'DRAWER 40X50X23.5CM WHITE', 0, 0, '1', '1', '1', 0]
        // ['10215200', 'DRAWER 40X50X29.5CM WHITE', 0, '6', '4', '6', '11', 0]
        // ['10216714', 'MASK NEOPRENE + N95 FILTER BLACK', '27', '4', 0, 0, 0, 0]
        console.log(columns[0]);
        //['product_id', 'name', '2020-02', '2020-03', '2020-04', '2020-05', '2020-06', '2020-07']
          $('#select-month-range').DataTable( {
            dom: "Bfrtip",
            data: rows,
            columns: columns[0]
          });
      }
    });
  
  }
// $('#find').click(function() {
//   var dataMonthRange = new FormData($('.form-save-month-range')[0]);
//   console.log($('.form-save-month-range').serializeArray());
  // dataMonthRange.append('_method', 'PUT');
  // $('#select-month-range').DataTable({
  //   processing: true,
  //   serverSide: true,
  //   ajax: {
  //     url: 'NeuralNetwork/getDataMonthRange',
  //     cache : false,
  //     processData: false,
  //     contentType: false,
  //     // type: 'POST',
  //     // headers: {'X-Requested-With': 'XMLHttpRequest'},
  //     data: {
  //        data : dataMonthRange
  //     },
      
  //   },
    
  // });
// });

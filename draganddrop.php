<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div id="dropzone">
  <div>dropzone</div>
  <input type="file" accept="image/png, application/pdf" />
</div>

<script>
    $(function() {
  
  $('#dropzone').on('dragover', function() {
    $(this).addClass('hover');
  });
  
  $('#dropzone').on('dragleave', function() {
    $(this).removeClass('hover');
  });
  
  $('#dropzone input').on('change', function(e) {
    var file = this.files[0];

    $('#dropzone').removeClass('hover');
    
    if (this.accept && $.inArray(file.type, this.accept.split(/, ?/)) == -1) {
      return alert('File type not allowed.');
    }
    
    $('#dropzone').addClass('dropped');
    $('#dropzone img').remove();
    
    if ((/^image\/(gif|png|jpeg)$/i).test(file.type)) {
      var reader = new FileReader(file);

      reader.readAsDataURL(file);
      
      reader.onload = function(e) {
        var data = e.target.result,
            $img = $('<img />').attr('src', data).fadeIn();
        
        $('#dropzone div').html($img);
      };
    } else {
      var ext = file.name.split('.').pop();
      
      $('#dropzone div').html(ext);
    }
  });
});
</script>
</body>
</html>


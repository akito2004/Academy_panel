<!-- bundle -->
<script src="<?php echo base_url('assets/backend/js/app.min.js'); ?>"></script>
<!-- third party js -->
<script src="<?php echo base_url('assets/backend/js/vendor/Chart.bundle.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/jquery-jvectormap-1.2.2.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/jquery-jvectormap-world-mill-en.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/dataTables.bootstrap4.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/dataTables.responsive.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/responsive.bootstrap4.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/dataTables.buttons.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/buttons.bootstrap4.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/buttons.html5.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/buttons.flash.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/buttons.print.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/dataTables.keyTable.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/dataTables.select.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/summernote-bs4.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/fullcalendar.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/pages/demo.summernote.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/dropzone.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/pages/datatable-initializer.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/font-awesome-icon-picker/fontawesome-iconpicker.min.js'); ?>" charset="utf-8"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/bootstrap-tagsinput.min.js');?>" charset="utf-8"></script>
<script src="<?php echo base_url('assets/backend/js/bootstrap-tagsinput.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/js/vendor/dropzone.min.js');?>" charset="utf-8"></script>
<script src="<?php echo base_url('assets/backend/js/ui/component.fileupload.js');?>" charset="utf-8"></script>
<script src="<?php echo base_url('assets/backend/js/pages/demo.form-wizard.js'); ?>"></script>
<!-- dragula js-->
<script src="<?php echo base_url('assets/backend/js/vendor/dragula.min.js'); ?>"></script>
<!-- component js -->
<script src="<?php echo base_url('assets/backend/js/ui/component.dragula.js'); ?>"></script>

<script src="<?php echo site_url('assets/backend/js/custom.js');?>"></script>

<?php if (isset($page_name) && $page_name === 'blog_form'): ?>
<script>
$(function () {
  var editor = $('#summernote-basic');
  if (!editor.length || typeof editor.summernote !== 'function') {
    return;
  }

  if (editor.next('.note-editor').length) {
    editor.summernote('destroy');
  }

  editor.summernote({
    height: 360,
    dialogsInBody: true,
    buttons: {
      uploadImage: function (context) {
        var button = $('<button type="button" class="btn btn-light" title="Subir imagen desde el equipo"><i class="note-icon-picture"></i></button>');
        button.on('click', function () {
          var input = $('<input type="file" accept="image/jpeg,image/png,image/gif,image/webp" style="display:none">');
          input.on('change', function () {
            if (!this.files.length) {
              return;
            }
            var formData = new FormData();
            formData.append('file', this.files[0]);
            $.ajax({
              url: '<?php echo site_url('admin/blog_content_image'); ?>',
              method: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              success: function (response) {
                var result = typeof response === 'string' ? JSON.parse(response) : response;
                if (result.url) {
                  context.invoke('editor.insertImage', result.url);
                } else {
                  error_notify(result.error || 'No se pudo subir la imagen.');
                }
              },
              error: function (xhr) {
                var result = xhr.responseJSON || {};
                error_notify(result.error || 'No se pudo subir la imagen.');
              },
              complete: function () {
                input.remove();
              }
            });
          });
          input.appendTo('body').trigger('click');
        });
        return button;
      }
    },
    toolbar: [
      ['style', ['style']],
      ['font', ['bold', 'underline', 'italic', 'clear']],
      ['fontname', ['fontname']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['table', ['table']],
      ['insert', ['link', 'uploadImage', 'video']],
      ['view', ['fullscreen', 'codeview', 'help']]
    ],
    callbacks: {
      onImageUpload: function (files) {
        var formData = new FormData();
        formData.append('file', files[0]);
        $.ajax({
          url: '<?php echo site_url('admin/blog_content_image'); ?>',
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            var result = typeof response === 'string' ? JSON.parse(response) : response;
            if (result.url) {
              editor.summernote('insertImage', result.url);
            } else {
              error_notify(result.error || 'No se pudo subir la imagen.');
            }
          },
          error: function (xhr) {
            var result = xhr.responseJSON || {};
            error_notify(result.error || 'No se pudo subir la imagen.');
          }
        });
      }
    }
  });
});
</script>
<?php endif; ?>

<!-- Dashboard chart's data is coming from this file -->
<?php include "$logged_in_user_role/dashboard-chart.php"; ?>

<script type="text/javascript">
  $(document).ready(function() {
    $(function() {
       $('.icon-picker').iconpicker();
     });
  });
</script>

<!-- Toastr and alert notifications scripts -->
<script type="text/javascript">
function notify(message) {
  $.NotificationApp.send("<?php echo get_phrase('heads_up'); ?>!", message ,"top-right","rgba(0,0,0,0.2)","info");
}

function success_notify(message) {
  $.NotificationApp.send("<?php echo get_phrase('congratulations'); ?>!", message ,"top-right","rgba(0,0,0,0.2)","success");
}

function error_notify(message) {
  $.NotificationApp.send("<?php echo get_phrase('oh_snap'); ?>!", message ,"top-right","rgba(0,0,0,0.2)","error");
}

function error_required_field() {
  $.NotificationApp.send("<?php echo get_phrase('oh_snap'); ?>!", "<?php echo get_phrase('please_fill_all_the_required_fields'); ?>" ,"top-right","rgba(0,0,0,0.2)","error");
}
</script>

<?php if ($this->session->flashdata('info_message') != ""):?>
<script type="text/javascript">
  $.NotificationApp.send("<?php echo get_phrase('success'); ?>!", '<?php echo $this->session->flashdata("info_message");?>' ,"top-right","rgba(0,0,0,0.2)","info");
</script>
<?php endif;?>

<?php if ($this->session->flashdata('error_message') != ""):?>
<script type="text/javascript">
  $.NotificationApp.send("<?php echo get_phrase('oh_snap'); ?>!", '<?php echo $this->session->flashdata("error_message");?>' ,"top-right","rgba(0,0,0,0.2)","error");
</script>
<?php endif;?>

<?php if ($this->session->flashdata('flash_message') != ""):?>
<script type="text/javascript">
  $.NotificationApp.send("<?php echo get_phrase('congratulations'); ?>!", '<?php echo $this->session->flashdata("flash_message");?>' ,"top-right","rgba(0,0,0,0.2)","success");
</script>
<?php endif;?>

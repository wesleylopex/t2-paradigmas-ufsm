<script>
  const base_url = '<?= base_url() ?>'
</script>

<script src="<?= base_url('assets/admin/js/core/jquery.3.2.1.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/js/core/popper.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/js/core/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/js/plugin/moment/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/js/plugin/datepicker/bootstrap-datetimepicker.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/js/plugin/select2/select2.full.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/js/ready.js') ?>"></script>
<script src="<?= base_url('assets/admin/js/plugin/datatables/datatables.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/js/setting-demo2.js') ?>"></script>
<script src="<?= base_url('assets/admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/js/plugin/mask/jquery.mask.js') ?>"></script>
<script src="<?= base_url('assets/admin/js/plugin/jquery.validate/jquery.validate.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/plugins/summernote/dist/summernote-bs4.js') ?>"></script>
<script src="<?= base_url('assets/admin/plugins/froala/js/froala_editor.pkgd.min.js') ?>"></script>

<script src="<?= base_url('assets/admin/js/plugin/dropzone/dropzone.min.js') ?>"></script>

<script src="<?= base_url('assets/admin/js/forms/validate-form.js') ?>"></script>
<script src="<?= base_url('assets/admin/js/feather-icons/feather.min.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>

<script>
  window.addEventListener('load', function () {
    feather.replace()
    initTippy()
    onClipToClipboard()
    initDatataTable()
  })

  function initTippy () {
    const tippies = document.querySelectorAll('[data-tippy-content]')
    tippy(tippies)
  }

  function onClipToClipboard () {
    const copyElements = document.querySelectorAll('.copy-to-clipboard')

    copyElements.forEach(element => {
      element.addEventListener('click', function () {
        const { copyText } = element.dataset
        copyToClipboard(copyText)
        showAlert('primary', 'Conteúdo copiado', 'la la-check')
      })
    })
  }

  function copyToClipboard (string) {
    const textarea = document.createElement('textarea')
    textarea.value = string
    document.body.appendChild(textarea)
    textarea.select()
    document.execCommand('copy')
    document.body.removeChild(textarea)
  }

  $('.phone').mask('(00) 0.0000-0000')

  $('.date').datetimepicker({
    format: 'DD/MM/YYYY'
  })

  $('.select2').select2({
    theme: 'bootstrap',
    minimumResultsForSearch: 10
  })

  $('input[type=file]').on('change', function () {
    const fileName = $(this).val().replace('C:\\fakepath\\', '')
    const label = $(this).next('.custom-file-label')

    if (fileName) {
      label.html(fileName);
    } else {
      label.html('Escolher um arquivo');
    }
  })

  function showAlert (type = 'primary', message, icon = 'la la-trash', title = null) {
    const alert = { icon, title, message }
    const options = {
      type,
      placement: {
        from: 'bottom',
        align: 'right'
      },
      time: 1000
    }
    $.notify(alert, options)
  }

  function showNotify (message, success = true) {
    const alert = { icon: success === true ? 'la la-check' : 'la la-times', message }
    const options = {
      type: 'primary',
      placement: { from: 'bottom', align: 'right' },
      time: 1000
    }
    $.notify(alert, options)
  }

  function initDatataTable () {
    $('.datatable').dataTable({
      language: {
        url: '<?= base_url('assets/admin/js/datatables/portuguese-brazil.json') ?>'
      }
    })
  }
</script>
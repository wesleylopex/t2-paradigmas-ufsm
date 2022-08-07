<script src="<?= base_url('assets/website/scripts/plugins/feather-icons/feather.min.js') ?>"></script>
<script src="<?= base_url('assets/website/scripts/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/website/scripts/plugins/jquery-mask/jquery.mask.min.js') ?>"></script>
<script src="<?= base_url('assets/website/scripts/plugins/bootstrap-notify/bootstrap-notify.min.js') ?>"></script>

<!-- Production -->
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>

<script type="module">
  import { Utils } from '<?= base_url('assets/website/scripts/Utils/Utils.js') ?>'

  window.addEventListener('load', () => {
    window.showNotify = showNotify

    initTippy()
    initUtils()
  })

  function initTippy () {
    const tippies = document.querySelectorAll('.tippy')
    tippy(tippies)
  }

  function initUtils () {
    const utils = Utils()
    utils.start(feather)
  }

  function showNotify (message, success = true) {
    const icon = success === true ? 'la la-check' : 'la la-times'
    $.notify(
      { icon, message },
      { type: 'primary', placement: { from: 'bottom', align: 'right' }, time: 1000 }
    )
  }
</script>
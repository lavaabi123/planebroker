<!DOCTYPE html>
<html lang="<?php echo selected_lang()->short_form ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo get_general_settings()->application_name ?> - <?php echo $title ?></title>
    <link rel="shortcut icon" href="<?php echo get_favicon(get_general_settings()); ?>">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/admin/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/admin/css/adminlte.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/bootstrap.min.css" />

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- File Manager css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/admin/plugins/file-manager/file-manager-1.0.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/admin/plugins/daterangepicker/daterangepicker.css">
    <!-- Upload -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/admin/plugins/file-uploader/css/jquery.dm-uploader.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/admin/plugins/file-uploader/css/styles-1.0.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/admin/css/custom.css?v=1.1">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/admin/plugins/bootstrap-4-tag-input/tagsinput.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">  
	
    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/jquery/jquery.min.js"></script>

    <script src="<?php echo base_url(); ?>/assets/admin/plugins/moment/moment.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/parsley/parsley.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/croppie.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/slimselect.css">
    <script>
        csrfName = '<?php echo csrf_token() ?>';
        csrfCookie = '<?php echo config('cookie')->prefix . config('security')->cookieName ?>';
        baseUrl = "<?php echo base_url(); ?>";
        userId = "<?php echo session()->get('admin_sess_user_id'); ?>";
        select_image = "<?php echo trans("select_image"); ?>";
        sweetalert_ok = "<?php echo trans("ok"); ?>";
        sweetalert_cancel = "<?php echo trans("cancel"); ?>";
        var sys_lang_id = "<?php echo get_langguage_id(get_general_settings()->site_lang)->id; ?>";
    </script>    
    <script src="<?php echo base_url(); ?>/assets/admin/js/custom.js?v=1.2"></script>
</head>

<body class="hold-transition sidebar-mini <?php echo check_dark_mode_enabled() ? 'dark-mode' : '' ?> layout-fixed layout-footer-fixed layout-navbar-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <!-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?php echo base_url(); ?>/assets/admin/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div> -->
        <!-- <div id="wait" class="loading"></div> -->

        <?php echo $this->include('admin/includes/_header') ?>

        <?php echo $this->include('admin/includes/_sidebar') ?>

        <?php echo $this->renderSection('content') ?>

        <?php echo $this->include('admin/includes/_footer') ?>

    </div>
    <!-- ./wrapper -->


    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <?php echo view('admin/file-manager/_load_file_manager', ['load_images' => true, 'load_files' => true, 'load_videos' => false, 'load_audios' => false]); ?>

    <!-- File Manager -->
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/file-manager/file-manager-1.0.js"></script>
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/file-uploader/js/jquery.dm-uploader.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/file-uploader/js/ui.js"></script>
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/bootstrap-4-tag-input/tagsinput.js"></script>

    <script src="<?php echo base_url(); ?>/assets/admin/plugins/chart.js/Chart.min.js"></script>

    <!-- DataTables  & Plugins -->
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/jszip/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/daterangepicker/daterangepicker.js"></script>

    <!-- SweetAlert2 -->
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>/assets/admin/js/adminlte.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/frontend/js/croppie.js"></script>
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
	<script src="<?php echo base_url(); ?>/assets/frontend/js/slimselect.js?v=1.0" defer></script>
<script src="<?php echo base_url(); ?>/assets/tinymce/tinymce.min.js"></script>

    <script>
        <?php if (check_cron_time_minutes(1)) : ?>
            $.ajax({
                type: "POST",
                url: baseUrl + "/vr-run-internal-cron"
            });
        <?php endif; ?>

        function display_ct7() {
            var x = new Date()

            var ampm = x.getHours() >= 12 ? ' PM' : ' AM';
            hours = x.getHours() % 12;
            hours = hours ? hours : 12;
            hours = hours.toString().length == 1 ? 0 + hours.toString() : hours;

            var minutes = x.getMinutes().toString()
            minutes = minutes.length == 1 ? 0 + minutes : minutes;

            var seconds = x.getSeconds().toString()
            seconds = seconds.length == 1 ? 0 + seconds : seconds;

            var x1 = hours + ":" + minutes + ":" + seconds + " " + ampm;
            document.getElementById('ct7').innerHTML = x1;
            display_c7();
        }

        function display_c7() {
            var refresh = 1000; // Refresh rate in milli seconds
            mytime = setTimeout('display_ct7()', refresh)
        }
        display_c7()
    </script>

    <?php if ($segment === 'dashboard' || empty($segment)) : ?>
        <script src="<?php echo base_url(); ?>/assets/admin/js/pages/dashboard-admin.js?v=2"></script>
    <?php endif; ?>

    <script>

        $(document).ready(function() {
            
            $('#cs_datatable').DataTable({
                language: {
                    paginate: {
                        previous: "<i class='fas fa-angle-left'>",
                        next: "<i class='fas fa-angle-right'>"
                    }
                },

                "aLengthMenu": [
                    [15, 30, 60, 100],
                    [15, 30, 60, 100, "All"]
                ],
                drawCallback: function() {

                }
            });

            <?php if (session()->getFlashdata('success')) : ?>
                custom_alert('success', '<?php echo session()->getFlashdata('success'); ?>', false);
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : 
                if(is_array(session()->getFlashdata('error'))): ?>
                  <?php 
                    $errorMessages = array_unique(session()->getFlashdata('error'));
                    $tempErrMsg = [];
                    foreach ($errorMessages as $errors) : 
                        $tempErrMsg [] = $errors;
                    endforeach; 
                    $msgErrContent = implode('\r\n', $tempErrMsg);
                    ?>
                    custom_alert('error', '<?php echo $msgErrContent; ?>', false);
                 <?php else: ?>
                 custom_alert('error', '<?php echo session()->getFlashdata('error'); ?>', false);
                <?php endif; ?>
        <?php endif; ?>
        });
		
    </script>
<style>
.dataTables_filter,.dataTables_length{
	display:flex;
	flex-direction:column;
}
/* Remove built-in DataTables arrows */
table.dataTable thead > tr > th.sorting:before,
table.dataTable thead > tr > th.sorting:after,
table.dataTable thead > tr > th.sorting_asc:before,
table.dataTable thead > tr > th.sorting_asc:after,
table.dataTable thead > tr > th.sorting_desc:before,
table.dataTable thead > tr > th.sorting_desc:after {
    display: none !important;
}
/* Default gray arrows */
.sort-icon-up,
.sort-icon-down {
    margin-left: 4px;
    font-size: 0.7rem;
    color: #aaa;
    position: relative;
}

.sort-icon-up {
    top: -1px; /* align up arrow */
}

.sort-icon-down {
    top: 2px; /* align down arrow */
}

/* Active arrow white */
.sort-icon-up.active,
.sort-icon-down.active {
    color: #fff;
}

.sshome.ss-main .ss-content .ss-search {
    display: block !important; 
}
.ss-main .ss-content .ss-search input{
	height:auto !important;
	padding:8px 20px !important;
}
</style>
<script>
$(document).ready(function () {
	
    $('select').each(function () {
    if ($(this).is('[multiple]')) {
      return; // do nothing, keep native
    }

    const selectElement = this;

    // Create SlimSelect only for single selects
    const slim = new SlimSelect({
      select: selectElement,
      showSearch: true,
      searchPlaceholder: 'Search...',
      searchFocus: true,
      onChange: function (info) {
        updateSlimColor(selectElement, info.value);
      }
    });

      // Initial color based on current value
      updateSlimColor(selectElement, selectElement.value);
    });

    // Function to color selected SlimSelect text
    function updateSlimColor(originalSelect, value) {
      const mainDiv = $(originalSelect).next('.ss-main').find('.ss-single-selected');

      if (value === '') {
        mainDiv.css('color', '#9b9b9b'); // grey for placeholder
		mainDiv.find('.placeholder').css('opacity', '0.5');
		mainDiv.find('.placeholder').css('font-weight', '300');
      } else {
        mainDiv.css('color', '#1b2e5b'); // blue for selected value
		mainDiv.find('.placeholder').css('opacity', '1');
		mainDiv.find('.placeholder').css('font-weight', '600');
      }
    }
  });
$(function () {
  // Find the nearest scrollable ancestor for an element
  function getScrollable($el) {
    let $p = $el.parent();
    while ($p.length) {
      const el = $p[0];
      const cs = window.getComputedStyle(el);
      const oy = cs.overflowY;
      const scrollable = (oy === 'auto' || oy === 'scroll') && el.scrollHeight > el.clientHeight;
      if (scrollable) return $p;
      $p = $p.parent();
    }
    // Fallbacks commonly used by AdminLTE
    const $fallback = $('.main-sidebar .sidebar .os-content, .main-sidebar .sidebar').first();
    return $fallback.length ? $fallback : $('html, body');
  }

  // Scroll so $target is fully visible inside $container
  function scrollIntoViewWithin($container, $target) {
    if (!$container.length || !$target.length) return;

    const c = $container[0];
    // If native works, use it
    if ($target[0].scrollIntoView) {
      // Use nearest so it doesn't jump unnecessarily
      $target[0].scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'nearest' });
      return;
    }

    const cRect = c.getBoundingClientRect();
    const tRect = $target[0].getBoundingClientRect();
    const needDown = tRect.bottom - cRect.bottom;
    const needUp   = cRect.top - tRect.top;

    if (needDown > 0) {
      $container.animate({ scrollTop: $container.scrollTop() + needDown }, 250);
    } else if (needUp > 0) {
      $container.animate({ scrollTop: $container.scrollTop() - needUp }, 250);
    }
  }

  function whenOpenedScroll($submenu) {
    if (!$submenu.length) return;

    // If already visible, just scroll
    const doScroll = () => scrollIntoViewWithin(getScrollable($submenu), $submenu);

    if ($submenu.is(':visible') && $submenu.height() > 0) {
      doScroll();
      return;
    }

    // Observe the submenu until it opens
    const el = $submenu.get(0);
    const obs = new MutationObserver(() => {
      if ($submenu.is(':visible') && $submenu.height() > 0) {
        obs.disconnect();
        doScroll();
      }
    });
    obs.observe(el, { attributes: true, attributeFilter: ['style', 'class'] });

    // Safety fallback (covers slideDown animation)
    setTimeout(() => {
      if ($submenu.is(':visible')) doScroll();
    }, 400);
  }

  // Works whether AdminLTE events fire or not
  $('.nav-sidebar').on('click', 'li.nav-item > a.nav-link', function () {
    const $li = $(this).closest('li');
    const $submenu = $li.children('ul.nav-treeview');
    if ($submenu.length) whenOpenedScroll($submenu);
  });

  // If AdminLTE Treeview events are available, use them too
  $(document).on('expanded.lte.treeview', function (e) {
    const $submenu = $(e.target).children('ul.nav-treeview');
    if ($submenu.length) whenOpenedScroll($submenu);
  });
});
</script>

<script>
    let allCityStates = [];

    // Load JSON file
    fetch('<?php echo base_url(); ?>/us_states_and_cities.json')
      .then(response => response.json())
      .then(data => {
        for (let state in data) {
          data[state].forEach(city => {
            allCityStates.push(city + ", " + state);
          });
        }

        // Enable autocomplete
        $(".city-state").each(function () {
		  $(this).autocomplete({
			source: allCityStates,
			minLength: 2,
			autoFocus: true,
			appendTo: $(this).parent(), // keeps dropdown under each input
			messages: {
			  noResults: "",    // disable "No search results."
			  results: function () {}
			}
		  });
		});
      });
	  $(document).ready(function() {
		// Find all .city-state inputs and add relative positioning to their parent
		$('.city-state').each(function() {
			$(this).parent().css('position', 'relative');
		});
	});
  </script>

<script>
(function(){
  const COUNT_URL = "<?= esc(base_url('admin/notifications/unread-count')) ?>";
	const LIST_URL  = "<?= esc(base_url('admin/notifications')) ?>?limit=5";
	const MARK_ALL  = "<?= esc(base_url('admin/notifications/mark-all-read')) ?>";
	const MARK_URL  = (id) => "<?= esc(base_url('admin/notifications/mark-read')) ?>/"+id;
	const VIEW_ALL_URL= "<?= esc(site_url('admin/notifications/all')) ?>";
  const CSRF      = { name: "<?= csrf_token() ?>", value: "<?= csrf_hash() ?>" };

  const $count = document.getElementById('notifCount');
  const $list  = document.getElementById('notifList');
  const $markAll = document.getElementById('markAllReadBtn');

  async function fetchJSON(url, opts={}) {
    const res = await fetch(url, opts);
    return res.json();
  }

  function timeAgo(iso) {
    const d = new Date(iso); const diff = (Date.now() - d.getTime())/1000;
    if (diff < 60) return 'just now';
    if (diff < 3600) return Math.floor(diff/60) + 'm';
    if (diff < 86400) return Math.floor(diff/3600) + 'h';
    return Math.floor(diff/86400) + 'd';
  }

  function levelBadge(level){
    const map = {info:'secondary', success:'success', warning:'warning', error:'danger'};
    return `<span class="badge bg-${map[level]||'secondary'}">${level}</span>`;
  }

  async function renderList() {
  const data  = await fetchJSON(LIST_URL);
  const items = data.items || [];

  // escape to avoid XSS
  const h = (s) => String(s ?? '').replace(/[&<>"']/g, m => (
    {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m]
  ));

  if (!items.length) {
    $list.innerHTML = `<div class="p-3 text-muted">No notifications</div>`;
    return;
  }

  // IMPORTANT: use backticks for the whole template!
  $list.innerHTML = items.map(it => {
    const msgHtml  = (it.message && it.message.trim())
      ? `<div class="small text-muted mt-1">${h(it.message)}</div>`
      : ''; // no empty block

    const openBtn  = it.link
      ? `<a href="${h(it.link)}" class="btn btn-sm btn-warning fw-semibold px-3">Open</a>`
      : '';

    const markBtn  = !it.is_read
      ? `<button type="button" class="btn btn-sm btn-outline-secondary px-3" data-mark="${it.pivot_id}">Mark read</button>`
      : '';

    return `
      <div class="list-group-item d-flex gap-2 ${it.is_read ? '' : 'bg-light'}">
        <div class="flex-grow-1">
          <div class="d-flex justify-content-between align-items-center">
            <strong>${h(it.title)}</strong>
            <small class="text-muted">${timeAgo(it.created_at)}</small>
          </div>
          ${msgHtml}
          <div class="mt-2 d-flex gap-2 align-items-center">
            ${openBtn}
            ${markBtn}
          </div>
        </div>
      </div>`;
  }).join('');

  // wire up “mark read” buttons
  $list.querySelectorAll('[data-mark]').forEach(btn => {
    btn.addEventListener('click', async (e) => {
		e.preventDefault();          // <- add
		e.stopPropagation();
      const id = e.currentTarget.dataset.mark;
      await fetch(MARK_URL(id), {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body: `${CSRF.name}=${encodeURIComponent(CSRF.value)}`
      });
      refresh();
    });
  });
}

  async function renderCount() {
    const {count} = await fetchJSON(COUNT_URL);
    if (count > 0) {
      $count.textContent = count > 99 ? '99+' : count;
      $count.classList.remove('d-none');
    } else {
      $count.classList.add('d-none');
    }
  }

  async function refresh(){
    renderCount();
    renderList();
  }

  $markAll.addEventListener('click', async (e) => {
	  e.preventDefault();          // <- add
    e.stopPropagation();
    await fetch(MARK_ALL, {method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded'}, body: `${CSRF.name}=${encodeURIComponent(CSRF.value)}`});
    refresh();
  });

  // initial + poll every 20s (or swap for SSE later)
  refresh();
  window._notif = window._notif || {};
window._notif.pollId = setInterval(refresh, 20000);
})();
</script>
<script>
(function () {
  // Globals any script can set:
  window._notif = window._notif || {
    pollId: null,               // setInterval id
    xhrs: new Set(),            // jQuery jqXHRs
    controllers: new Set()      // fetch AbortControllers
  };

  window.stopNotifAjax = function () {
    // Abort fetches
    for (const c of window._notif.controllers) { try { c.abort(); } catch(e){} }
    window._notif.controllers.clear();

    // Abort jQuery ajax/Datatables requests
    for (const x of window._notif.xhrs) {
      try { if (x && x.readyState !== 4) x.abort(); } catch(e){}
    }
    window._notif.xhrs.clear();

    // Stop polling
    if (window._notif.pollId) {
      clearInterval(window._notif.pollId);
      window._notif.pollId = null;
    }
  };

  // Abort before any real form submit (don’t prevent default!)
  document.addEventListener('submit', function () { window.stopNotifAjax(); }, true);

  // Also catch submit-button clicks (Enter key may bypass click)
  document.addEventListener('click', function (e) {
    const btn = e.target.closest('button, input[type="submit"]');
    if (!btn) return;
    const type = (btn.getAttribute('type') || 'submit').toLowerCase();
    if (type === 'submit') window.stopNotifAjax();
  }, true);

  // Safety: when navigating away
  window.addEventListener('beforeunload', function () { window.stopNotifAjax(); });
})();
</script>


<script>
tinymce.init({
  selector: '.show_text_editor',
  // license_key: 'gpl', // keep if you're on the OSS build
  menubar: false,                 // set true if you want the top menus
  plugins: 'lists advlist image autolink autoresize codesample emoticons link media pagebreak preview searchreplace table visualblocks wordcount nonbreaking',
  toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image table | removeformat',
  toolbar_mode: 'wrap',           // so icons don’t disappear on small widths
  // optional: extra list styles
  advlist_bullet_styles: 'default circle disc square',
  advlist_number_styles: 'default lower-alpha lower-roman upper-alpha upper-roman',
  statusbar: false,
  content_css: ['<?php echo base_url(); ?>/assets/rte-content.css'],
  content_style: `
    body { line-height: 1.25; }           /* overall line height */
    p { margin: 0.25em 0; }               /* less space between paragraphs */
    ul,ol { margin: 0.25em 0 0.25em 1.25em; padding-left: 1.25em; }
    li { margin: 0.15em 0; }              /* tighter list items */
    h1,h2,h3,h4,h5,h6 { margin: .6em 0 .3em; }
  `
});
</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/rte-content.css">

</body>

</html>
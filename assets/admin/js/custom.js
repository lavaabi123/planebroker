/**
 * Theme: Reactmore Admin
 * Author: More
 */

/* Requires jQuery already loaded */
(function () {
  // Run after DOM is ready (safe even if script is in <head>)
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initNotif);
  } else {
    initNotif();
  }

  function initNotif () {
    // --- URLs & CSRF from server ---
     const COUNT_URL =baseUrl + "/admin/notifications/unread-count";
    const LIST_URL  = baseUrl + "/admin/notifications?limit=5";
    const MARK_ALL  = baseUrl + "/admin/notifications/mark-all-read";
    const MARK_URL  = (id) => baseUrl + "/admin/notifications/mark-read/"+id;
    const CSRF      = { name: "<?= csrf_token() ?>", value: "<?= csrf_hash() ?>" };

    // --- Elements (bail out silently if not present on this page) ---
    const $count   = $('#notifCount');
    const $list    = $('#notifList');
    const $markAll = $('#markAllReadBtn');
    if (!$count.length || !$list.length || !$markAll.length) return;

    // --- State for polling & aborts ---
    window._notif = window._notif || { pollId: null, jqx: new Set() };

    // --- Helpers ---
    const h = s => String(s ?? '').replace(/[&<>"']/g, m => (
      ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m])
    ));
    function timeAgo(iso) {
      const d = new Date(iso); const diff = (Date.now() - d.getTime())/1000;
      if (diff < 60) return 'just now';
      if (diff < 3600) return Math.floor(diff/60) + 'm';
      if (diff < 86400) return Math.floor(diff/3600) + 'h';
      return Math.floor(diff/86400) + 'd';
    }
    function ajaxJSON(url, opts = {}) {
      const jq = $.ajax({
        url: url,
        type: opts.method || 'GET',
        data: opts.data || {},
        dataType: 'json',
      });
      window._notif.jqx.add(jq);
      jq.always(() => window._notif.jqx.delete(jq));
      return jq;
    }

    // Detach notif controls from any outer <form> so they can’t hijack submit
    const NOOP_FORM_ID = '__notif_noop_form__';
    function ensureNoopForm() {
      if (!document.getElementById(NOOP_FORM_ID)) {
        const f = document.createElement('form');
        f.id = NOOP_FORM_ID; f.style.display = 'none';
        f.setAttribute('onsubmit', 'return false;');
        document.body.appendChild(f);
      }
    }
    function neutralizeNotifButtons() {
      ensureNoopForm();
      // Static "mark all"
      if ($markAll.length) {
        if (!$markAll.attr('type')) $markAll.attr('type', 'button');
        $markAll.attr({'form': NOOP_FORM_ID, 'formnovalidate': 'true'});
      }
      // Dynamic list buttons
      $list.find('button').each(function () {
        const $b = $(this);
        if (!$b.attr('type')) $b.attr('type', 'button');
        $b.attr({'form': NOOP_FORM_ID, 'formnovalidate': 'true'});
      });
    }

    // --- Renderers ---
    function renderList() {
      return ajaxJSON(LIST_URL).then((data) => {
        const items = (data && data.items) || [];
        if (!items.length) {
          $list.html('<div class="p-3 text-muted">No notifications</div>');
          neutralizeNotifButtons();
          return;
        }
        // Use anchors for actions (anchors never submit forms)
        const html = items.map(it => {
          const msgHtml = (it.message && it.message.trim())
            ? `<div class="small text-muted mt-1">${h(it.message)}</div>` : '';
          const openBtn = it.link
            ? `<a href="${h(it.link)}" class="btn btn-sm btn-warning fw-semibold px-3" role="button">Open</a>` : '';
          const markBtn = !it.is_read
            ? `<a href="#" role="button" class="btn btn-sm btn-outline-secondary px-3" data-mark="${it.pivot_id}">Mark read</a>` : '';

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
        $list.html(html);
        neutralizeNotifButtons(); // VERY IMPORTANT: do this after every render
      }).catch(err => {
        // Optional: keep silent or log
        // console.error('renderList failed', err);
      });
    }

    function renderCount() {
      return ajaxJSON(COUNT_URL).then((data) => {
        const count = (data && data.count) || 0;
        if (count > 0) {
          $count.text(count > 99 ? '99+' : count).removeClass('d-none');
        } else {
          $count.addClass('d-none');
        }
      }).catch(err => {
        // console.error('renderCount failed', err);
      });
    }

    function refresh() {
      return $.when(renderCount(), renderList());
    }

    // --- Events ---
    // Delegated: mark a single notification read
    $list.on('click', '[data-mark]', function (e) {
      e.preventDefault(); e.stopPropagation();
      const id = $(this).data('mark');
      $.ajax({
        url: MARK_URL(id),
        type: 'POST',
        data: { [CSRF.name]: CSRF.value }
      }).always(refresh);
    });

    // Mark all read
    $markAll.on('click', function (e) {
      e.preventDefault(); e.stopPropagation();
      $.ajax({
        url: MARK_ALL,
        type: 'POST',
        data: { [CSRF.name]: CSRF.value }
      }).always(refresh);
    });

    // --- Start polling ---
    refresh();
    window._notif.pollId = setInterval(refresh, 20000);

    // Pause polling & abort in-flight AJAX during real form submits (capture phase)
    document.addEventListener('submit', function () {
      if (window._notif.pollId) { clearInterval(window._notif.pollId); window._notif.pollId = null; }
      for (const jq of Array.from(window._notif.jqx)) {
        try { if (jq && jq.readyState !== 4) jq.abort(); } catch(e){}
      }
      window._notif.jqx.clear();
    }, true);

    // Clean up on unload
    window.addEventListener('beforeunload', function () {
      if (window._notif.pollId) { clearInterval(window._notif.pollId); window._notif.pollId = null; }
      for (const jq of Array.from(window._notif.jqx)) {
        try { if (jq && jq.readyState !== 4) jq.abort(); } catch(e){}
      }
      window._notif.jqx.clear();
    });
  }
})();
$(document).ready(function () {
    $('#wait').hide();
    $('#form').parsley();
    $("form").on('submit', function () {
        $("#crsf").attr("name", csrfName).val($.cookie(csrfCookie));
    });

    $(document).on('click', 'button[name="validate"]', function () {
        $(':required:invalid', '#form').each(function () {
            var id = $('.tab-pane').find(':required:invalid').closest('.tab-pane').attr('id');

            $('.nav a[href="#' + id + '"]').tab('show');
        });
    });


    $("#checkAll").on('click', function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $('.btnNext').click(function () {
        $('.nav-tabs .active').parent().next('li').find('a').trigger('click');
    });

    $('.btnPrevious').click(function () {
        $('.nav-tabs .active').parent().prev('li').find('a').trigger('click');
    });

    $('.menu_category_permission').on('click', function () {
        const menuCategoryId = $(this).data('menucategory');
        const roleId = $(this).data('role');
        var data = {
            'menuCategoryID': menuCategoryId,
            'roleID': roleId,
        };
        data[csrfName] = $.cookie(csrfCookie);

        $.ajax({
            url: baseUrl + "/admin/role-management/change-menu-category-permission",

            type: 'post',
            data: data,
            success: function () {
                // alert('User Access has been changed !');
                location.reload();
            }
        });
    });

    $('.menu_permission').on('click', function () {
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');

        var data = {
            'menuID': menuId,
            'roleID': roleId,
        };

        data[csrfName] = $.cookie(csrfCookie);

        $.ajax({
            url: baseUrl + "/admin/role-management/change-menu-permission",
            type: 'post',
            data: data,
            success: function (response) {
                console.log(response);
                // alert('User Access has been changed !');
                location.reload();
            }
        });
    });

    $('.submenu_permission').on('click', function () {
        const submenuID = $(this).data('submenu');
        const roleId = $(this).data('role');

        var data = {
            'submenuID': submenuID,
            'roleID': roleId,
        };
        data[csrfName] = $.cookie(csrfCookie);

        $.ajax({
            url: baseUrl + "/admin/role-management/change-submenu-permission",
            type: 'post',
            data: data,
            success: function () {
                // alert('User Access has been changed !');
                location.reload();
            }
        });
    });

    document.querySelectorAll('[data-toggle="password"]').forEach(function (el) {
        el.addEventListener("click", function (e) {
            e.preventDefault();

            var target = el.dataset.target;
            var icon = el.dataset.icon;
            document.querySelector(target).focus();
            document.querySelector(icon).focus();

            if (document.querySelector(target).getAttribute('type') == 'password') {
                document.querySelector(target).setAttribute('type', 'text');
                document.querySelector(icon).setAttribute('class', 'fa fa-eye-slash');
            } else {
                document.querySelector(target).setAttribute('type', 'password');
                document.querySelector(icon).setAttribute('class', 'fa fa-eye');
            }
        });
    });
});




function generateUniqueString(prefix) {
    var time = String(new Date().getTime()),
        i = 0,
        output = '';
    for (i = 0; i < time.length; i += 2) {
        output += Number(time.substr(i, 2)).toString(36);
    }
    return (prefix + '-' + output.toUpperCase());
}

function custom_alert(type, msg, reload = true) {
    var toastMixin = Swal.mixin({
        toast: true,
        icon: type,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,

        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
            toast.addEventListener('click', Swal.close);
        },
        didClose: () => {
            if (reload) {
                location.reload();
            }
        }


    });

    toastMixin.fire({
        title: msg
    });
};


//confirm user email
function confirm_user_email(id) {
    var data = {
        'id': id,
    };
    data[csrfName] = $.cookie(csrfCookie);
    $.ajax({
        type: "POST",
        url: `${baseUrl}/admin/providers/confirm_user_email`,
        data: data,
        success: function (response) {
            location.reload();
        }
    });
};

//delete item
function delete_item(url, id, message) {
    Swal.fire({
        text: message,
        icon: "warning",
        showCancelButton: 1,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: sweetalert_ok,
        cancelButtonText: sweetalert_cancel,
    }).then(function (willDelete) {
        if (willDelete.value) {
            var data = {
                'id': id,
            };
            data[csrfName] = $.cookie(csrfCookie);
            $.ajax({
                type: "POST",
                url: baseUrl + url,
                data: data,
                beforeSend: function () {
                    $("#wait").show();
                },
                complete: function () {
                    $("#wait").hide();

                },
                success: function (response) {
                    location.reload();
                }
            });
        }
    });
};

//ban user
function ban_user(id, message, option) {
    Swal.fire({
        text: message,
        icon: "warning",
        showCancelButton: 1,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: sweetalert_ok,
        cancelButtonText: sweetalert_cancel,

    }).then(function (willDelete) {
        if (willDelete.value) {
            var data = {
                'id': id,
                'option': option
            };
            const newLocal = $.cookie(csrfCookie);
            data[csrfName] = newLocal;
            $.ajax({
                type: "POST",
                url: `${baseUrl}/admin/providers/ban_user_post`,
                data: data,
                beforeSend: function () {
                    $("#wait").show();
                },
                complete: function () {
                    $("#wait").hide();

                },
                success: function (response) {
                    location.reload();
                }
            });
        }
    });
};

function get_states_by_county(val) {
    var data = {
        "county_id": val
    };
    data[csrfName] = $.cookie(csrfCookie);
    $.ajax({
        type: "POST",
        url: baseUrl + "/common/get_states_by_county",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                document.getElementById("selected_states").innerHTML = obj.content;
            }
        }
    });
}

function get_states(val, map) {
    $('#select_states').children('option').remove();
    $('#select_cities').children('option').remove();
    $('#get_states_container').hide();
    $('#get_cities_container').hide();
    var data = {
        "county_id": val,
        "sys_lang_id": sys_lang_id
    };
    data[csrfName] = $.cookie(csrfCookie);
    $.ajax({
        type: "POST",
        url: baseUrl + "/common/get_states",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                document.getElementById("select_states").innerHTML = obj.content;
                $('#get_states_container').show();
            } else {
                document.getElementById("select_states").innerHTML = "";
                $('#get_states_container').hide();
            }
            if (map) {
                update_product_map();
            }
        }
    });
}

function get_cities(val, map) {
    var data = {
        "state_id": val,
        "sys_lang_id": sys_lang_id
    };
    data[csrfName] = $.cookie(csrfCookie);
    $.ajax({
        type: "POST",
        url: baseUrl + "/common/get_cities",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                document.getElementById("select_cities").innerHTML = obj.content;
                $('#get_cities_container').show();
            } else {
                document.getElementById("select_cities").innerHTML = "";
                $('#get_cities_container').hide();
            }
            if (map) {
                update_product_map();
            }
        }
    });
}


function update_product_map() {
    var county_text = $("#select_counties").find('option:selected').text();
    var county_val = $("#select_counties").find('option:selected').val();
    var state_text = $("#select_states").find('option:selected').text();
    var state_val = $("#select_states").find('option:selected').val();
    var city_text = $("#select_cities").find('option:selected').text();
    var city_val = $("#select_cities").find('option:selected').val();
    var address = $("#address_input").val();
    var zip_code = $("#zip_code_input").val();
    var data = {
        "county_text": county_text,
        "county_val": county_val,
        "state_text": state_text,
        "state_val": state_val,
        "city_text": city_text,
        "city_val": city_val,
        "address": address,
        "zip_code": zip_code,
        "sys_lang_id": sys_lang_id
    };


    data[csrfName] = $.cookie(csrfCookie);
    $.ajax({
        type: "POST",
        url: baseUrl + "/common/show_address_on_map",
        data: data,
        success: function (response) {

            document.getElementById("map-result").innerHTML = response;
        }
    });
}

//activate inactivate counties
function activate_inactivate_counties(action) {
    var data = {
        "action": action
    };
    data[csrfName] = $.cookie(csrfCookie);
    $.ajax({
        type: "POST",
        url: baseUrl + "/admin/locations/county/activate-inactivate-counties",
        data: data,
        success: function (response) {
            location.reload();
        }
    });
};


function get_provider_messages(message_id) {
    var data = {
        "message_id": message_id
    };
    data[csrfName] = $.cookie(csrfCookie);
    $.ajax({
        type: "POST",
        url: baseUrl + "/common/get_provider_messages",
        data: data,
        success: function (data) {
            $('#provider-message-content').html(data);
            $('#modal-provider-message').modal('show');
        }
    });
}

function delete_provider_messages(message_id) {
    var data = {
        "message_id": message_id
    };
	Swal.fire({
        text: 'Do you want to delete this message?',
        icon: "info",
        showCancelButton: 1,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
    }).then(function (willDelete) {
        if (willDelete.value) {            
			//data[csrfName] = $.cookie(csrfCookie);
			$.ajax({
				type: "POST",
				url: baseUrl + "/common/delete_provider_messages",
				data: data,
				success: function (data) {
					$('#provider-message-content').html(data);
					$('#pm'+message_id).hide();
				}
			});
        }
    });
}

function get_contact_messages(message_id) {
    var data = {
        "message_id": message_id
    };
    data[csrfName] = $.cookie(csrfCookie);
    $.ajax({
        type: "POST",
        url: baseUrl + "/common/get_contact_messages",
        data: data,
        success: function (data) {
            $('#provider-message-content').html(data);
            $('#modal-provider-message').modal('show');
        }
    });
}

function get_captain_messages(message_id) {
    var data = {
        "message_id": message_id
    };
    data[csrfName] = $.cookie(csrfCookie);
    $.ajax({
        type: "POST",
        url: baseUrl + "/common/get_captain_messages",
        data: data,
        success: function (data) {
            $('#provider-message-content').html(data);
            $('#modal-provider-message').modal('show');
        }
    });
}

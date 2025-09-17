$(document).ready(function() {
    toggleAllDay();
    /* Tick picker */
    function attachTime(){
        $('.time').each(function(){
            var thisInput = $(this), min = false, max = false, interval = 5;
            if(thisInput.hasClass('past')){
                max = true
            }else if(thisInput.hasClass('future')){
                min = true
            }
            if(typeof thisInput.data('interval')){
                interval = thisInput.data('interval');
            }
            thisInput.pickatime({
                format: 'h:i a',
                formatSubmit: 'HH:i',
                interval: interval,
                hiddenName: true,
                readOnly: true,
                min: min,
                max: max
            });
        });
    }
    attachTime();
    /* Location Dropdown/Search */
    attachLocation();
    $(".toast").toast('show');
    var addRate = $('.addRate');
    var rateType = addRate.data('rate-type');
    addRate.on('click', function(e){
        e.preventDefault();
        $(this).before('<div class="d-flex rate gap-2 gap-sm-4"><div class="col"><input type="number" class="form-control" data-a-sign="$" data-v-max="99999999" data-v-min="0" data-m-dec="2" name="price[]" placeholder="59.99 per"></div><div class="col"><input type="text" class="onlyNum form-control" placerholder="60" value="60" name="duration_amount[]"></div><div class="col"><select name="duration[]" class="form-control"><option value="m" selected="selected">Minute '+rateType+'</option><option value="h">Hour '+rateType+'</option></select></div><a href="javascript:void(0)" class="button tiny alert removeRate p-2"><i class="fas fa-trash"></i></a></div>');
    });

	    /* Only Number in input */
	$('body').on('keydown', '.onlyNum', function (evt) {
	    var charCode = (evt.which) ? evt.which : event.keyCode;
	    if(charCode >= 65 && charCode <= 93 || charCode >= 106 && charCode <= 111 || charCode >= 186){
	     evt.preventDefault();
	    }
	});
	$('body').on('click', '.removeRate', function(e){
	    e.preventDefault();
	    $(this).parents('.rate').remove();
	});

	$('body').on('click', '.allDay', function(){
	    toggleAllDay();
	});    

    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z\s]+$/i.test(value);
    }, "Only alphabetical characters");
    jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 9 && 
        phone_number.match(/^(\+?1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
    }, "Please enter a valid 10 digit phone number");

// ---- Helpers: normalize loose inputs to full URLs ----
function normalizeUrlToNetwork(network, raw) {
  if (!raw) return '';
  let v = (raw + '').trim();

  // if it's already a URL, force https + tidy
  if (/^https?:\/\//i.test(v) || v.startsWith('www.')) {
    v = v.replace(/^http:\/\//i, 'https://');
    try {
      const u = new URL(v.startsWith('http') ? v : 'https://' + v);
      if (u.pathname !== '/' && v.endsWith('/')) v = v.slice(0, -1);
    } catch (_) {}
    return v;
  }

  // handle-only -> build a URL for the network
  const handle = v.replace(/^@/, '');
  switch (network) {
    case 'facebook':  return 'https://www.facebook.com/'   + handle;
    case 'linkedin':  return 'https://www.linkedin.com/in/'+ handle;
    case 'instagram': return 'https://www.instagram.com/'  + handle;
    case 'tiktok':    return 'https://www.tiktok.com/@'    + handle;
    case 'youtube':   return 'https://www.youtube.com/@'   + handle;
    default:          return /^https?:\/\//i.test(v) ? v : 'https://' + v;
  }
}

// ---- Regexes per network (anchor ^$) ----
const RX = {
	website  : /^(https?:\/\/)([a-z0-9\-]+\.)+[a-z]{2,}(:\d+)?(\/[^\s]*)?$/i,
  facebook : /^(https?:\/\/)(www\.)?facebook\.com\/[A-Za-z0-9.\-_]+(\/[A-Za-z0-9.\-_]+)*(\/)?(\?[^\s]*)?$/i,
  linkedin : /^(https?:\/\/)([a-z]{2,3}\.)?linkedin\.com\/(in|company)\/[A-Za-z0-9\-_%\.]+(\/)?(\?[^\s]*)?$/i,
  instagram: /^(https?:\/\/)(www\.)?instagram\.com\/[A-Za-z0-9._]+(\/)?(\?[^\s]*)?$/i,
  tiktok   : /^(https?:\/\/)(www\.)?tiktok\.com\/@?[A-Za-z0-9._]+(\/)?(\?[^\s]*)?$/i,
  youtube  : /^(https?:\/\/)(www\.)?(youtube\.com\/(channel\/[A-Za-z0-9_\-]+|user\/[A-Za-z0-9_\-]+|@?[A-Za-z0-9_\-\.]+|watch\?v=[A-Za-z0-9_\-]+|shorts\/[A-Za-z0-9_\-]+)|youtu\.be\/[A-Za-z0-9_\-]+)(\/)?(\?[^\s]*)?$/i
};

// ---- jQuery Validate custom methods (optional if empty) ----
$.validator.addMethod('facebookUrl',  function(v, el){ if(!v) return true; return RX.facebook.test(v); },  'Please enter a valid Facebook URL.');
$.validator.addMethod('linkedinUrl',  function(v, el){ if(!v) return true; return RX.linkedin.test(v); },  'Please enter a valid LinkedIn URL (e.g., https://www.linkedin.com/username).');
$.validator.addMethod('instagramUrl', function(v, el){ if(!v) return true; return RX.instagram.test(v); }, 'Please enter a valid Instagram URL.');
$.validator.addMethod('tiktokUrl',    function(v, el){ if(!v) return true; return RX.tiktok.test(v); },   'Please enter a valid TikTok URL (e.g., https://www.tiktok.com/@handle).');
$.validator.addMethod('youtubeUrl',   function(v, el){ if(!v) return true; return RX.youtube.test(v); },  'Please enter a valid YouTube URL.');
const websiteRegex = /^(https?:\/\/)?(www\.)?[a-zA-Z0-9-]+(\.[a-zA-Z]{2,63})([/?].*)?$/;

$.validator.addMethod(
  "websiteUrl",
  function (value, element) {
    if (!value) return true; // optional field

    return this.optional(element) || websiteRegex.test(value.trim());
  },
  "Please enter a valid website URL."
);
$.validator.addMethod("nameOrCompany", function(value, element) {
  const first  = $("#first_name").val().trim();
  const last   = $("#last_name").val().trim();
  const company = $("#business_name").val().trim();

  // Either both first & last OR company must be filled
  if ((first && last) || company) {
    return true;
  }
  return false;
}, "Please provide First & Last Name OR a Company Name.");
// ---- Auto-normalize on blur (turn handles into URLs) ----
$(document).on('blur', '#website,#facebook,#linkedin,#instagram,#tiktok_link,#youtube_link', function(){
  const id = this.id;
  const map = {
    website: 'website',
    facebook: 'facebook',
    linkedin: 'linkedin',
    instagram: 'instagram',
    tiktok_link: 'tiktok',
    youtube_link: 'youtube'
  };
  const network = map[id];
  const normalized = normalizeUrlToNetwork(network, $(this).val());
  //$(this).val(normalized);
});
// Auto-format (xxx) xxx-xxxx without blocking typing
$('#mobile_no').on('input', function () {
  const el = this;

  // keep only digits, hard-limit to 10
  const digits = el.value.replace(/\D/g, '').slice(0, 10);

  let formatted = '';
  if (digits.length === 0) {
    formatted = '';
  } else if (digits.length < 4) {
    formatted = `(${digits}`;
  } else if (digits.length < 7) {
    formatted = `(${digits.slice(0,3)}) ${digits.slice(3)}`;
  } else {
    formatted = `(${digits.slice(0,3)}) ${digits.slice(3,6)}-${digits.slice(6)}`;
  }

  // set the value
  el.value = formatted;
});

jQuery.validator.addMethod("tenDigits", function (value, element) {
  return this.optional(element) || value.replace(/\D/g, '').length === 10;
}, "Please enter a valid 10-digit phone number.");

$("#provider-form").validate({
  ignore: ":hidden:not(#location_id)",
  onfocusout: function(el){ this.element(el); }, // validate on blur
  rules: {
    first_name: {nameOrCompany: true,lettersonly: true },
    last_name:  { nameOrCompany: true,lettersonly: true },
    business_name:  {nameOrCompany: true},
    mobile_no:  { required: true, tenDigits: true, minlength: 10, maxlength: 10,normalizer: function (value) { return value.replace(/\D/g, ''); } },
    email:      { required: true, email: true },
	website: { websiteUrl: true },
    // --- Socials (optional but must match if present)
    facebook_link: { facebookUrl: true },
    linkedin_link: { linkedinUrl: true },
    insta_link:    { instagramUrl: true },
    tiktok_link:   { tiktokUrl: true },
    youtube_link:  { youtubeUrl: true }
  },
  groups: {
    nameGroup: "first_name last_name business_name"
  },
  errorPlacement: function(error, element) {
    if (element.attr("name") === "first_name" ||
        element.attr("name") === "last_name" ||
        element.attr("name") === "business_name") {
      // append error only once, after company_name (or anywhere you want)
      error.insertAfter("#first_name");
    } else {
      error.insertAfter(element);
    }
  },
  messages: {
	website: "Please enter a valid website URL.",
    facebook_link: { facebookUrl: "Example: https://www.facebook.com/yourpage" },
    linkedin_link: { linkedinUrl: "Example: https://www.linkedin.com/yourname" },
    insta_link:    { instagramUrl: "Example: https://www.instagram.com/username" },
    tiktok_link:   { tiktokUrl: "Example: https://www.tiktok.com/@handle" },
    youtube_link:  { youtubeUrl: "Channel/User/@handle/Video links allowed" },
	mobile_no: {
      minlength: "Enter exactly 10 digits.",
      maxlength: "Enter exactly 10 digits."
    }
  }
});
(function ($) {
  // enable visible blocks; disable hidden ones
  function syncHiddenBlocks() {
    $('.catbasedfield, .services-group').each(function () {
      var $block   = $(this);
      var visible  = $block.is(':visible'); // covers display:none & visibility:hidden

      // only touch real form controls (skip hidden inputs)
      var $fields = $block.find('input:not([type="hidden"]), select, textarea');

      $fields.prop('disabled', !visible);

      // clear any visual error state when hiding
      if (!visible) {
        $block.find('.error-border').removeClass('error-border');
      }
    });
  }

  // expose if you need to call it elsewhere
  window.syncHiddenBlocks = syncHiddenBlocks;

  // 1) run safely after DOM is ready and once layout settles
  $(function () {
    // first pass
    syncHiddenBlocks();
    // after the UI/plugins finish initialising
    requestAnimationFrame(syncHiddenBlocks);
    setTimeout(syncHiddenBlocks, 150);
  });

  // 2) re-run whenever subcategory changes (hidden <select>)…
  $(document).on('change', 'select[name="sub_category_id"]', function () {
    // defer so any plugin (SS select) finishes its DOM work first
    setTimeout(syncHiddenBlocks, 0);
  });

  // 3) …and when the SS select UI is interacted with (some themes only fire on the UI)
  $(document).on('click keyup', '.ss-main', function () {
    setTimeout(syncHiddenBlocks, 0);
  });

  // 4) if your app toggles these blocks by class/style later, observe and sync
  var observer = new MutationObserver(function (muts) {
    for (var i = 0; i < muts.length; i++) {
      var m = muts[i];
      if (m.type === 'attributes' && (m.attributeName === 'class' || m.attributeName === 'style')) {
        var $t = $(m.target);
        if ($t.is('.catbasedfield, .services-group')) {
          syncHiddenBlocks();
          break;
        }
      }
    }
  });
  $('.catbasedfield, .services-group').each(function () {
    observer.observe(this, { attributes: true, attributeFilter: ['class', 'style'] });
  });

})(jQuery);


const $form = $('#aircraft-add-form-1');
let skipValidation = false;         // you already have this
let allowLiveValidation = false;    // NEW: only true after first Publish attempt

/* =========================
   SAVE LISTING (unchanged)
========================= */
$('.save-listing').on('click', function (e) {
  e.preventDefault();
  skipValidation = true;

  // Set status to 0 (inactive)
  $form.find('input[name="status"]').val(0);

  // Submit the form bypassing validation
  $form.off('submit').submit();
});

/* =========================
   0) Helpers for SS & MCE
========================= */
// Return the visible SS container for a hidden <select>
function ssContainer($el) {
  return $el.next('.ss-main');
}
function mceHasText(id) {
  const ed = (window.tinymce && tinymce.get(id)) || null;
  if (!ed) return false;
  const text = ed.getContent({ format: 'text' }).replace(/\u200B/g, '').trim();
  return text.length > 0;
}
function debounce(fn, wait){ let t; return (...a)=>{ clearTimeout(t); t=setTimeout(()=>fn.apply(null,a), wait); }; }
// Choose the visible UI for an element (for scrolling/focus)
function getVisibleUI(el) {
  const $el = $(el);
  if ($el.is('select') && $el.next().hasClass('ss-main')) {
    return ssContainer($el);
  }
  if ($el.is('textarea') && $el.attr('id') && window.tinymce && tinymce.get($el.attr('id'))) {
    return $(tinymce.get($el.attr('id')).getContainer());
  }
  if ($el.is(':checkbox,:radio') && el.name.startsWith('dynamic_fields[')) {
    return $el.closest('.services-group');
  }
  return $el;
}

// Smooth scroll and focus the field's visible UI
function scrollToErrorUI($ui) {
  if (!$ui || !$ui.length) return;
  const OFFSET = 120; // adjust for sticky header
  $('html, body').stop(true).animate(
    { scrollTop: Math.max(0, $ui.offset().top - OFFSET) },
    350,
    function () {
      // Focus something sensible
      let focused = false;

      // TinyMCE container → focus editor
      if ($ui.hasClass('tox') || $ui.hasClass('tox-tinymce')) {
        const $ta = $ui.prev('textarea[id]');
        const id = $ta.attr('id');
        if (id && window.tinymce && tinymce.get(id)) {
          tinymce.get(id).focus();
          focused = true;
        }
      }

      if (!focused) {
        const $focusable = $ui.find('input,select,textarea,[tabindex],[contenteditable="true"]')
                              .filter(':visible')
                              .first();
        if ($focusable.length) { $focusable.trigger('focus'); focused = true; }
      }

      if (!focused && $ui.is('input,select,textarea,[contenteditable="true"]')) {
        $ui.trigger('focus');
      }
    }
  );
}
/* =========================
   1) Custom validator rules
========================= */
$.validator.addMethod('ssRequired', function (value, element) {
  return $.trim(value || '') !== '';
});
$.validator.addMethod('mceRequired', function (value, element) {
  if (element.id && window.tinymce && tinymce.get(element.id)) {
    return mceHasText(element.id);
  }
  return $.trim(value || '') !== '';
});

/* =========================
   2) jQuery Validate init
========================= */
$form.validate({
  // IMPORTANT: we must validate the hidden originals (SS + TinyMCE)
  ignore: [],

  errorElement: 'label',
  errorClass: 'error-border',

   errorPlacement: function () { return false; },

  highlight: function (element) {
    const $el = $(element);

    // SS select → highlight visible UI
    if ($el.is('select') && $el.next().hasClass('ss-main')) {
      ssContainer($el).addClass('error-border');
      return;
    }

    // TinyMCE textarea → highlight editor UI
    if ($el.is('textarea') && $el.attr('id') && window.tinymce && tinymce.get($el.attr('id'))) {
      $el.siblings('.tox,.tox-tinymce,[role="application"]').first().addClass('error-border');
      return;
    }

    // Your original group logic
    if (element.name.startsWith('dynamic_fields[')) {
      $el.closest('.services-group').addClass('error-border');
      return;
    }

    // Default
    $el.addClass('error');
  },

  unhighlight: function (element) {
  const $el = $(element);

  // always remove from the actual element too
  $el.removeClass('error-border');

  // SS select → remove from the visible UI
  if ($el.is('select') && $el.next().hasClass('ss-main')) {
    $el.next('.ss-main').removeClass('error-border');
    return;
  }

  // TinyMCE → remove from its UI (use nextAll to be robust)
  if ($el.is('textarea') && $el.attr('id') && window.tinymce && tinymce.get($el.attr('id'))) {
    $el.nextAll('.tox,.tox-tinymce,[role="application"]').first()
       .removeClass('error-border');
    return;
  }

  if (element.name.startsWith('dynamic_fields[')) {
    $el.closest('.services-group').removeClass('error-border');
    return;
  }
},

// called when a field becomes valid; double-remove just in case
success: function (label, element) {
  const $el = $(element);
  $el.removeClass('error-border');

  if ($el.is('select') && $el.next().hasClass('ss-main')) {
    $el.next('.ss-main').removeClass('error-border');
  } else if ($el.is('textarea') && $el.attr('id') && window.tinymce && tinymce.get($el.attr('id'))) {
    $el.nextAll('.tox,.tox-tinymce,[role="application"]').first()
       .removeClass('error-border');
  } else if (element.name.startsWith('dynamic_fields[')) {
    $el.closest('.services-group').removeClass('error-border');
  }

  // don’t keep any labels around since you show no text
  if (label && label.remove) label.remove();
}
,
 invalidHandler: function (e, validator) {
    if (!validator.errorList.length) return;
    const el = validator.errorList[0].element;
    scrollToErrorUI(getVisibleUI(el));
  },
  rules: {
    password: { minlength: 12 },
    mobile_no: { }
  },
  messages: {}
});
// --- Location fields wiring ---
const $locMirror = $form.find('#cityState');                      // do NOT validate this

// 3) When publish fails and shows border, clear mirror’s border when value exists
$locMirror.on('input change', function () {
  if (this.value.trim() !== '') $(this).removeClass('error error-border');
});

// Inputs & textareas (native)
$form.find('input[required], textarea[required]').on('input keyup change', function () {
  if (allowLiveValidation) $(this).valid();
});

// SS selects – hidden <select> and visible .ss-main
$form.on('change', 'select', function () {
  if (allowLiveValidation) $(this).valid();
});
$form.on('click keyup keydown', '.ss-main', function () {
  if (!allowLiveValidation) return;
  const $hidden = $(this).prev('select');
  if ($hidden.length) $hidden.valid();
});

// TinyMCE – listen only to user activity (no SetContent/init)
/* =========================
   TinyMCE required + live clear FIX
========================= */
const mceBound = new Set();

function attachMceHandlers(ed, $ta) {
  if (!ed || mceBound.has(ed.id)) return;
  mceBound.add(ed.id);

  const $ui = $(ed.getContainer()); // visible editor chrome

  // Clear border immediately while user edits
  const clearBorder = () => {
    if (!allowLiveValidation) return;
    $ui.removeClass('error-border');
    $ta.removeClass('error-border').attr('aria-invalid', 'false');
    $ui.closest('.services-group, .form-group, .form-section').removeClass('error-border');
  };

  // Revalidate after brief pause
  let t;
  const revalidate = () => {
    if (!allowLiveValidation) return;
    clearTimeout(t);
    t = setTimeout(() => { $ta.valid(); }, 160);
  };

  // Remove any previous bindings and attach robust listeners
  ed.off('keydown input paste keyup undo redo ExecCommand NodeChange change focus');
  ed.on('keydown input paste', () => { clearBorder(); revalidate(); });
  ed.on('keyup undo redo ExecCommand NodeChange change', () => { clearBorder(); revalidate(); });
  ed.on('focus', clearBorder);
}

// Find TinyMCE textareas that are required and switch to custom rule
$form.find('textarea[required]').each(function () {
  const $ta = $(this);

  // 1) Disable the native required rule (this is the core fix)
  $ta.prop('required', false).removeClass('required');
  try { $ta.rules('remove', 'required'); } catch (e) {}

  // 2) Add our TinyMCE-aware rule
  $ta.rules('add', { mceRequired: true });

  // 3) If editor already exists, wire events now
  const id = this.id;
  if (id && window.tinymce && tinymce.get(id)) {
    attachMceHandlers(tinymce.get(id), $ta);
  }
});

// 4) Also wire for editors created after page load
if (window.tinymce && tinymce.on) {
  tinymce.on('AddEditor', (e) => {
    const ed = e.editor;
    const $ta = $('#' + ed.id);
    if ($ta.length) {
      // ensure native required is removed for late editors
      $ta.prop('required', false).removeClass('required');
      try { $ta.rules('remove', 'required'); } catch (e2) {}
      $ta.rules('add', { mceRequired: true });

      attachMceHandlers(ed, $ta);
    }
  });
}



/* ==========================================
   4) PUBLISH submit (unchanged logic)
   – just sync TinyMCE before .valid()
========================================== */
$form.on('submit', function (e) {
  if (skipValidation) return; // Skip validation if SAVE LISTING triggered
// From now on, let field-level events clear borders live
  allowLiveValidation = true;
  // Make sure TinyMCE pushes content back to the hidden <textarea>
  if (window.tinymce && tinymce.triggerSave) tinymce.triggerSave();

  if (!$form.valid()) {
    e.preventDefault(); // Prevent submission if invalid
	const validator = $form.validate();
    if (validator.errorList.length) {
      const el = validator.errorList[0].element;
      scrollToErrorUI(getVisibleUI(el));
    }
    return false;
  }

  // Ensure status is set to 1 (active) on publish
  $form.find('input[name="status"]').val(1);
});

/* =================================================
   5) Keep your dynamic checkbox group bootstrapping
================================================= */
const added = new Set();
$('input[type="checkbox"][name^="dynamic_fields["]').each(function () {
  const name = this.name;
  if (added.has(name)) return;
  if ($(this).prop('required')) {
    $form.validate().settings.rules[name] = { required: true };
    $form.validate().settings.messages[name] = {};
  }
  added.add(name);
});


$("#provider-form-edit").validate({
  ignore: ":hidden:not(#location_id)",
  onfocusout: function(el){ this.element(el); }, // validate on blur
  rules: {
    first_name: {nameOrCompany: true,lettersonly: true },
    last_name:  { nameOrCompany: true,lettersonly: true },
    business_name:  {nameOrCompany: true},
    mobile_no:  { required: true, tenDigits: true, minlength: 10, maxlength: 10,normalizer: function (value) { return value.replace(/\D/g, ''); } },
    email:      { required: true, email: true },
	password:   { minlength: 12 },
    password_confirm: {
	   required: {
			depends: function(element) {
			  return $("#password").val().length > 0;
			}
		  },
		  minlength: 12,
		  equalTo: "#password"
	},
	website: { websiteUrl: true },
    // --- Socials (optional but must match if present)
    facebook_link: { facebookUrl: true },
    linkedin_link: { linkedinUrl: true },
    insta_link:    { instagramUrl: true },
    tiktok_link:   { tiktokUrl: true },
    youtube_link:  { youtubeUrl: true }
  },
  groups: {
    nameGroup: "first_name last_name business_name"
  },
  errorPlacement: function(error, element) {
    if (element.attr("name") === "first_name" ||
        element.attr("name") === "last_name" ||
        element.attr("name") === "business_name") {
      // append error only once, after company_name (or anywhere you want)
      error.insertAfter("#first_name");
    } else {
      error.insertAfter(element);
    }
  },
  messages: {
	website: "Please enter a valid website URL.",
    facebook_link: { facebookUrl: "Example: https://www.facebook.com/yourpage" },
    linkedin_link: { linkedinUrl: "Example: https://www.linkedin.com/yourname" },
    insta_link:    { instagramUrl: "Example: https://www.instagram.com/username" },
    tiktok_link:   { tiktokUrl: "Example: https://www.tiktok.com/@handle" },
    youtube_link:  { youtubeUrl: "Channel/User/@handle/Video links allowed" },
	mobile_no: {
      minlength: "Enter exactly 10 digits.",
      maxlength: "Enter exactly 10 digits."
    }
  }
});


});

function change_categories_skills(_this,user_id){
    $(".load_categories_skills").html('');
	$(".load_category_offering").html('');
    var category_id = $(_this).val()
    $.ajax({
        type: "POST",
        url: baseUrl +'/providerauth/get-categories-skills',
        data:{csrf_token:'1e78598ff0fc7c5d22b2b579edcdc3db',category_id:category_id,user_id:user_id, edit_user_id:user_id},   
        dataType: 'HTML',           
        success: function (data) {  
            console.log(data);          
            $(".load_categories_skills").html(data);   

            if($('#hid_categories_skills').length){   
            	let hid_categories_skills = $('#hid_categories_skills').val();
            	// Parse the JSON string into an array
				let categoriesSkillsArray = JSON.parse(hid_categories_skills);
				if (Array.isArray(categoriesSkillsArray)) {
					// Iterate over the checkboxes
					$('input[name="categories_skills[]"]').each(function() {
					  let checkboxValue = $(this).val();
					  
					  // Check if the value exists in the array
					  if (categoriesSkillsArray.includes(checkboxValue)) {
					    // Set the checkbox as checked
					    $(this).prop('checked', true);
					  }
					});
			    }
        	}
        }
    });
	$.ajax({
        type: "POST",
        url: baseUrl +'/providerauth/get-category-offering',
        data:{csrf_token:'1e78598ff0fc7c5d22b2b579edcdc3db',category_id:category_id,user_id:user_id, edit_user_id:user_id,from:'admin'},   
        dataType: 'HTML',           
        success: function (data) {  
            console.log(data);          
            $(".load_category_offering").html(data);   

            if($('#hid_category_offering').length){   
            	let hid_category_offering = $('#hid_category_offering').val();
            	// Parse the JSON string into an array
				let categoriesSkillsArray = JSON.parse(hid_category_offering);
				if (Array.isArray(categoriesSkillsArray)) {
					// Iterate over the checkboxes
					$('input[name="offering[]"]').each(function() {
					  let checkboxValue = $(this).val();
					  
					  // Check if the value exists in the array
					  if (categoriesSkillsArray.includes(checkboxValue)) {
					    // Set the checkbox as checked
					    $(this).prop('checked', true);
					  }
					});
			    }
        	}
        }
    }); 	
}

function attachLocation(){
    $('select.location').selectize({
        valueField: 'id',
        labelField: 'location',
        searchField: 'location',
        create: false,
        render: {
            option: function(item, escape) {
                return '<div>'+escape(item.location)+'</div>';
            }
        },
        load: function(query, callback) {
        	$('.selectize-control').removeClass('loading');
            if (!query.length) return callback();
            
            $.ajax({
                url: baseUrl +'/providerauth/get-locations?q=' + encodeURIComponent(query),
                type: 'GET',
                error: function() {
                    callback();
                },
                success: function(res) {
                    res = $.parseJSON(res);
                    callback(res.locations);
                }
            });
        }
    });
}
function toggleAllDay(){
    $('.allDay').each(function(){
        var thisCheck = $(this);
        var row = thisCheck.parents('.hoo').find('.dayRow');
        if(thisCheck.is(":checked")){
            row.hide();
        }else{
            row.show();
        }
    });
}    
$(document).ready(function(){
 
    //Show carousel-control
    
    $("#myCarousel").mouseover(function(){
        $("#myCarousel .carousel-control").show();
    });

    $("#myCarousel").mouseleave(function(){
        $("#myCarousel .carousel-control").hide();
    });
    
    //Active thumbnail
    
    $("#thumbCarousel .thumb").on("click", function(){
        $(this).addClass("active");
        $(this).siblings().removeClass("active");
    
    });
    
    //When the carousel slides, auto update
    
    $('#myCarousel').on('slid.bs.carousel', function(){
       var index = $('.carousel-inner .item.active').index();
       //console.log(index);
       var thumbnailActive = $('#thumbCarousel .thumb[data-slide-to="'+index+'"]');
       thumbnailActive.addClass('active');
       $(thumbnailActive).siblings().removeClass("active");
       //console.log($(thumbnailActive).siblings()); 
    });     
        
 });


  $(document).ready(function(){
    var isBrowserCompatible = 
      $('html').hasClass('ua-ie-10') ||
      $('html').hasClass('ua-webkit') ||
      $('html').hasClass('ua-firefox') ||
      $('html').hasClass('ua-opera') ||
      $('html').hasClass('ua-chrome');

    if(isBrowserCompatible){
      window.card = new Skeuocard($('#skeuocard'), {
        debug: false
      });
    }
  });

  function change_user_plan(selectObject){
  	let plan =  selectObject.value;
  	if(plan=='1'){
  		$(".premium-plan-block").hide();
  		$("#show_premiun_date").hide();       
  	}else if(plan>='2'){
  		$(".premium-plan-block").show();   
  		$("#show_premiun_date").show();       
  	}else{
  		$(".premium-plan-block").hide();
  		$("#show_premiun_date").hide();          
  	}
  }

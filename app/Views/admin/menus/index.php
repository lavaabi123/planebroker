<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>


<div class="content-wrapper bg-grey">
    <!-- Content Header (Page header) -->
    <div class="content-header ">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 d-flex">
                    <h1 class="m-0"><?php echo $title ?></h1>					
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <?php if ($title === 'Dashboard') : ?>
                            <li class="breadcrumb-item active"><a href="<?php echo admin_url() ?>">/</a></li>
                        <?php else :  ?>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>"><?php echo trans('dashboard') ?></a></li>                          
                            <li class="breadcrumb-item active"><?php echo $title ?></li>
                        <?php endif  ?>

                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
		

<?php
/* =================== minimal server data =================== */
$db = db_connect();

/* Ensure a single PRIMARY menu exists */
$menu = $db->table('menus')->where('slug','primary')->get()->getRowArray();
if (!$menu) {
  $db->table('menus')->insert(['name'=>'Primary Menu','slug'=>'primary','location'=>'primary','is_active'=>1]);
  $menu = $db->table('menus')->where('slug','primary')->get()->getRowArray();
}
$MENU_ID = (int)$menu['id'];

/* Current menu items (flat) */
$items = $db->table('menu_items')
  ->where('menu_id', $MENU_ID)
  ->orderBy('parent_id','ASC')->orderBy('sort_order','ASC')
  ->get()->getResultArray();

/* build nested for initial render */
$byParent = [];
foreach ($items as $it) $byParent[$it['parent_id'] ?? 0][] = $it;

$render = function($pid) use (&$render,$byParent) {
  if (empty($byParent[$pid])) return;
  foreach ($byParent[$pid] as $row): ?>
    <li class="dd-item" data-id="<?= $row['id'] ?>">
      <div class="dd-handle">
        <span class="title"><?= esc($row['title']) ?></span>
        <div class="actions">
          <button class="dd-outdent" type="button" title="Move out one level">←</button>
          <button class="dd-indent"  type="button" title="Nest under previous">→</button>
          <a class="ml-3 text-danger del" type="button" href="#" data-id="<?= $row['id'] ?>"><i class="fas fa-trash"></i></a>
        </div>
      </div>
      <ul class="dd-list"><?php $render($row['id']); ?></ul>
    </li>
<?php endforeach; };

/* Source data (left palette) */
$staticPages = [
  ['title'=>'Home',     'url'=>''],
  ['title'=>'About Us', 'url'=>'about-us'],
  ['title'=>'Contact Us',  'url'=>'contact'],
  ['title'=>'Education',  'url'=>'#'],
  ['title'=>'Articles',  'url'=>'blog'],
  ['title'=>'Videos',  'url'=>'videos'],
  ['title'=>'FAQs',  'url'=>'faq'],
  ['title'=>'News & Trends',  'url'=>'news'],
];

$cats = $db->table('categories')->select('id,name,permalink')->orderBy('id')->get()->getResultArray();
$subs = $db->table('categories_sub')->select('id,name,category_id')->orderBy('id')->get()->getResultArray();
$catSubs = [];
foreach ($subs as $s) $catSubs[$s['category_id']][] = $s;
?>


<div class="builder" style="display:grid;grid-template-columns:360px 1fr;gap:24px">
  <!-- LEFT: FLAT PALETTE (every row is its own draggable item) -->
  <aside>
    <div class="card p-1">
      <div class="card-body">
        <div class="text-muted small mb-1">Static Pages</div>
        <ul id="paletteList" class="source-list">
          <?php foreach ($staticPages as $p): ?>
            <li class="palette-item handles depth-0"
                data-type="page"
                data-title="<?= esc($p['title']) ?>"
                data-url="<?= esc($p['url']) ?>">
              <span class="handle">⠿</span><span class="label"><?= esc($p['title']) ?></span>
            </li>
          <?php endforeach; ?>

          <div class="text-muted small mt-3 mb-1">Categories</div>
          <?php foreach ($cats as $c): ?>
            <!-- category row -->
            <li class="palette-item handles depth-0"
                data-type="category"
                data-entity_id="<?= $c['id'] ?>"
                data-title="<?= esc($c['name']) ?>"
                data-url="<?= esc('listings/'.$c['permalink']) ?>">
              <span class="handle">⠿</span><span class="label fw-bold"><?= esc($c['name']) ?></span>
            </li>
            <!-- subcategory rows -->
            <?php foreach ($catSubs[$c['id']] ?? [] as $sc): ?>
              <li class="palette-item handles depth-1"
                  data-type="subcategory"
                  data-entity_id="<?= $sc['id'] ?>"
                  data-title="<?= esc($sc['name']) ?>"
                  data-url="<?= esc('listings/'.$c['permalink'].'?category='.$sc['id']) ?>">
                <span class="handle">⠿</span><span class="label"><?= esc($sc['name']) ?></span>
              </li>
            <?php endforeach; ?>
          <?php endforeach; ?>
        </ul>

        <p class="text-muted small mt-3">
          Drag any item to the right. Drag up/down to reorder. Drop inside a dashed area to make it a sub menu,
          or use the arrows (→ nest under previous, ← move out).
        </p>
      </div>
    </div>
  </aside>

  <!-- RIGHT: MENU CANVAS -->
  <section>
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h5 class="m-0">Menu Structure</h5>
      <button id="saveOrder" class="btn btn-success btn-sm">Save Order</button>
    </div>

    <ul id="menuNest" class="dd-list">
      <?php $render(0); ?>
    </ul>
  </section>
</div>

</div>
</section>
</div>
<!-- SortableJS -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const MENU_ID = <?= (int)$MENU_ID ?>;

  /* ===== CSRF helper (CI4) ===== */
  let CSRF = { name: '<?= csrf_token() ?>', hash: '<?= csrf_hash() ?>' };
  async function post(url, data) {
    const body = new URLSearchParams({ ...data, [CSRF.name]: CSRF.hash });
    const res  = await fetch(url, { method: 'POST', body });
    let json = null; try { json = await res.json(); if (json?.csrf) CSRF.hash = json.csrf; } catch {}
    return { ok: res.ok, json };
  }

  /* ===== LEFT: palette (clone-only) ===== */
  new Sortable(document.getElementById('paletteList'), {
    group: { name:'menu', pull:'clone', put:false },
    draggable: 'li.palette-item',
    sort: false,
    animation: 150,
    forceFallback: true,
    fallbackOnBody: true,
  onStart(){ document.body.classList.add('dragging-no-select'); },
  onEnd(){ document.body.classList.remove('dragging-no-select'); }
  });

  /* ===== RIGHT: drop zone + nesting ===== */
  const nest = document.getElementById('menuNest');

  function ddHTML(id, title) {
    return `
      <div class="dd-handle">
        <span class="title">${title}</span>
        <div class="actions">
          <button class="dd-outdent" type="button" title="Move out one level">←</button>
          <button class="dd-indent"  type="button" title="Nest under previous">→</button>
		  <a href="#" class="ml-3 text-danger del" type="button"  data-id="${id}"><i class="fas fa-trash"></i></a>
        </div>
      </div>
      <ul class="dd-list"></ul>
    `;
  }

  function wireIndentOutdent(scope) {
    scope.querySelectorAll('.dd-indent').forEach(btn => {
      btn.onclick = () => {
        const li = btn.closest('li.dd-item');
        const prev = li.previousElementSibling;
        if (!prev) return;
        prev.querySelector(':scope > ul.dd-list').appendChild(li);
      };
    });
    scope.querySelectorAll('.dd-outdent').forEach(btn => {
      btn.onclick = () => {
        const li = btn.closest('li.dd-item');
        const parentLi = li.closest('ul.dd-list')?.closest('li.dd-item');
        if (!parentLi) return;
        parentLi.parentElement.insertBefore(li, parentLi.nextElementSibling);
      };
    });
  }

  function bindDel(btn){
    btn.addEventListener('click', async ()=>{
      if (!confirm('Remove this item?')) return;
      const r = await post('<?= base_url('admin/menus/item/delete') ?>', { id: btn.dataset.id });
      if (!r.ok) return Swal.fire("Delete Failed.", "", "error");
      btn.closest('li.dd-item').remove();
    });
  }

 function makeDroppable(ul){
  new Sortable(ul, {
    group: { name:'menu', pull:false, put:true },
    animation:150,
    forceFallback:true,
    fallbackOnBody:true,

    // DRAG ENTIRE LI (no handle)
    draggable: '.dd-item, .palette-item',

    // BUT let buttons/links be clickable (don’t start a drag from them)
    filter: '.del, .dd-indent, .dd-outdent,  button',
    preventOnFilter: false,
    onStart(){ document.body.classList.add('dragging-no-select'); },
    onEnd(){ document.body.classList.remove('dragging-no-select'); },

    async onAdd(evt){
      const el = evt.item;
      if (!el.classList.contains('palette-item')) return; // internal move

      const title = el.dataset.title || 'Untitled';
      const parentLi = ul.closest('li.dd-item');
      const payload = {
        menu_id: <?= (int)$MENU_ID ?>,
        parent_id: parentLi ? parentLi.dataset.id : '',
        sort_order: Array.from(ul.children).indexOf(el) + 1,
        type: el.dataset.type || 'custom',
        title,
        url: el.dataset.url || '',
        entity_id: el.dataset.entity_id || ''
      };

      const r = await post('<?= site_url('admin/menus/item/create') ?>', payload);
      if (!r.ok || !r.json?.id) { el.remove(); 
		Swal.fire("Could not add item.", "", "success");  return; }

      const li = document.createElement('li');
      li.className = 'dd-item';
      li.dataset.id = r.json.id;
      li.innerHTML = ddHTML(r.json.id, title);
      el.replaceWith(li);

      bindDel(li.querySelector('.del'));
      wireIndentOutdent(li);
      makeDroppable(li.querySelector('.dd-list'));
    }
  });
}

  makeDroppable(nest);
  document.querySelectorAll('#menuNest .dd-list').forEach(makeDroppable);
  wireIndentOutdent(document);

  /* ===== Save Order ===== */
  function serialize(ul){
    const arr=[]; ul.querySelectorAll(':scope > li.dd-item').forEach(li=>{
      const node = { id: li.dataset.id, children: [] };
      const kid  = li.querySelector(':scope > ul.dd-list');
      if (kid) node.children = serialize(kid);
      arr.push(node);
    }); return arr;
  }

  document.getElementById('saveOrder').addEventListener('click', async ()=>{
    const tree = serialize(nest);
    const res  = await fetch('<?= base_url('admin/menus/reorder') ?>', {
      method:'POST',
      headers:{'Content-Type':'application/json'},
      body: JSON.stringify({ tree, [CSRF.name]: CSRF.hash })
    });
    if (!res.ok) return 
	Swal.fire("Save Failed", "", "error");;
    try { const j = await res.json(); if (j?.csrf) CSRF.hash = j.csrf; } catch {}
	Swal.fire("Order Saved!", "", "success");
  });

  /* Optional: highlight potential parent while hovering */
  nest.addEventListener('dragover', e=>{
    const li = e.target.closest('li.dd-item');
    document.querySelectorAll('.dd-item.drop-target').forEach(n=>n.classList.remove('drop-target'));
    if (li) li.classList.add('drop-target');
  });
  nest.addEventListener('dragleave', ()=> {
    document.querySelectorAll('.dd-item.drop-target').forEach(n=>n.classList.remove('drop-target'));
  });
  nest.addEventListener('click', async (e) => {
  const del = e.target.closest('.del');
  if (!del) return;
  e.preventDefault();
  e.stopPropagation();

const confirmed = await jConfirm({
    title: 'Remove this item?',     // your requested title
    content: 'Are you sure you want to remove?',
    okText: 'Remove',
    cancelText: 'Cancel',
    type: 'red'
  });
  if (!confirmed) return;

  const r = await post('<?= base_url('admin/menus/item/delete') ?>', { id: del.dataset.id });
  if (!r.ok) {
    Swal.fire("Delete Failed.", "", "error");
    return;
  }
  del.closest('li.dd-item').remove();
});
});
function jConfirm({ title='Confirm', content='Are you sure?', okText='OK', cancelText='Cancel', type='red' } = {}) {
  return new Promise(resolve => {
    $.confirm({
      title, content, type,
      buttons: {
        ok: { text: okText, btnClass: `btn-${type}`, action: () => resolve(true) },
        cancel: { text: cancelText, action: () => resolve(false) }
      },
      onClose: () => resolve(false)
    });
  });
}
</script>

<style>
/* LEFT palette */
.source-list { list-style:none; padding-left:0; margin:0; }
.palette-item {
  position:relative; padding:10px 12px 10px 34px;
  border:1px solid #e5e5e5; border-radius:10px; margin-bottom:8px;
  background:#fff; cursor:grab;
}
.palette-item.depth-1 { margin-left:35px; }
.palette-item.depth-1::before {
  content:''; position:absolute; left:34px; top:8px; bottom:8px; border-left:2px dashed #eee;
}
.handle { position:absolute; left:10px; top:9px; user-select:none; opacity:.75; }
.handle:active { opacity:1; cursor:grabbing; }

/* RIGHT canvas */
.dd-list { list-style:none; padding-left:0; margin:0; }
#menuNest{
  min-height:160px; background:#f3f6fb; border:1px dashed #cdd6e1;
  border-radius:12px; padding:12px;
}
.dd-item { border:1px solid #e3e3e3; margin:8px 0; border-radius:10px; background:#fff; }
.dd-handle{ cursor:grab; padding:12px 14px; background:#fafafa; border-radius:10px; display:flex; justify-content:space-between; align-items:center; }
.dd-item > .dd-list{
  min-height:28px; margin:8px 0 6px 28px; padding:8px; border-left:2px dashed #e5e7eb; border-radius:8px;
}
.dd-item.drop-target > .dd-list{ background:#fff8e6; border-left-color:#f59e0b; }
.dd-handle .actions{ display:flex; gap:6px; align-items:center; }
.dd-handle .dd-indent, .dd-handle .dd-outdent{
  border:1px solid #e5e5e5; background:#fff; border-radius:6px; padding:2px 6px; cursor:pointer;
}

/* remove button look (matches your screenshot) */
.btn-link.text-danger{ background:#f7a52b; color:#b31010 !important; border-radius:22px; padding:6px 14px; text-decoration:none; }
.btn-link.text-danger:hover{ filter:brightness(.95); }
/* left */
.palette-item { cursor: grab; }
/* right */
.dd-item > .dd-handle { cursor: grab; }        /* keep look */
.dd-item { cursor: grab; }                      /* whole item shows grab */
.dragging-no-select,
.dragging-no-select * {
  -webkit-user-select: none !important;
  -moz-user-select: none !important;
  -ms-user-select: none !important;
  user-select: none !important;
  -webkit-tap-highlight-color: transparent; /* mobile */
}
</style>

<?= $this->endSection() ?>

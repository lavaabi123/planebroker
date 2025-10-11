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
        <div class="actions permission_show">
          <a class="ml-3 text-danger del" type="button" href="javascript:void(0);" data-id="<?= $row['id'] ?>"><i class="fas fa-trash"></i></a>
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
              <span class="label"><?= esc($p['title']) ?></span>
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
              <span class="label fw-bold"><?= esc($c['name']) ?></span>
            </li>
            <!-- subcategory rows -->
            <?php foreach ($catSubs[$c['id']] ?? [] as $sc): ?>
              <li class="palette-item handles depth-1"
                  data-type="subcategory"
                  data-entity_id="<?= $sc['id'] ?>"
                  data-title="<?= esc($sc['name']) ?>"
                  data-url="<?= esc('listings/'.$c['permalink'].'?from=menu&category='.$sc['id']) ?>">
                <span class="label"><?= esc($sc['name']) ?></span>
              </li>
            <?php endforeach; ?>
          <?php endforeach; ?>
        </ul>

        <p class="text-muted small mt-3">
          
        </p>
      </div>
    </div>
  </aside>

  <!-- RIGHT: MENU CANVAS -->
  <div class="card p-1">
  <section class="card-body" id="menuScroll">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h5 class="m-0">Menu Structure</h5>
      <button id="saveOrder" class="permission_show btn btn-success btn-sm saveOrder">Save Menu</button>
    </div>

    <ul id="menuNest" class="dd-list">
      <?php $render(0); ?>
    </ul>
	
    <div class="d-flex justify-content-end align-items-center mb-2 mt-3">
      <button id="saveOrder1" class="permission_show btn btn-success btn-sm saveOrder">Save Menu</button>
    </div>
  </section>
  </div>
</div>

</div>
</section>
</div>
<!-- SortableJS -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>

<script>
/* ---------- helpers shared across handlers ---------- */
const RIGHT      = document.getElementById('menuScroll');
const NEST       = document.getElementById('menuNest');
let   CSRF       = { name: '<?= csrf_token() ?>', hash: '<?= csrf_hash() ?>' };
const nest = document.getElementById('menuNest');

nest.addEventListener('click', async (e) => {
  const del = e.target.closest('.del');
  if (!del) return;                  // not a delete click
  e.preventDefault();
  e.stopPropagation();

  const li = del.closest('li.dd-item');
  if (!li) return;

	 const { isConfirmed } = await Swal.fire({
      title: 'Remove this item?',
      text: 'This action cannot be undone.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Remove',
      cancelButtonText: 'Cancel',
      reverseButtons: true,
      focusCancel: true
    });
    if (!isConfirmed) return;
  // If you're staging creates (new-* ids), just remove locally:
  const id = li.dataset.id || '';
  if (id.startsWith('new-')) {
    li.remove();
    return;
  }
  // Otherwise call your delete API (persisted row)
  const r = await postForm('<?= base_url('admin/menus/item/delete') ?>', { id });
  if (!r.ok) { Swal.fire("Delete Failed.", "", "error"); return; }
  li.remove();
});
/* POST helper (CI4 csrf) */
async function postForm(url, data){
  const body = new URLSearchParams({ ...data, [CSRF.name]: CSRF.hash });
  const res  = await fetch(url, { method:'POST', body });
  let json = null; try { json = await res.json(); if (json?.csrf) CSRF.hash = json.csrf; } catch {}
  return { ok: res.ok, json };
}

/* Build a stable tree (keeps string ids like "new-…") */
function serialize(ul){
  const arr = [];
  ul.querySelectorAll(':scope > li.dd-item').forEach(li => {
    const kid = li.querySelector(':scope > ul.dd-list');
    arr.push({ id: li.dataset.id, children: kid ? serialize(kid) : [] });
  });
  return arr;
}

/* Collect all temporary ids ("new-*") and the metadata saved on each LI */
function collectNewNodes(tree, ul = NEST){
  const list = [];
  const meta = new Map();
  (function walk(nodes){
    nodes.forEach(n => {
      if (typeof n.id === 'string' && n.id.startsWith('new-')) {
        const li = Array.from(ul.querySelectorAll('li.dd-item')).find(x => x.dataset.id === n.id);
        if (li){
          meta.set(n.id, {
            title: li.dataset.title || 'Untitled',
            type: li.dataset.type   || 'custom',
            url: li.dataset.url     || '',
            entity_id: li.dataset.entity_id || ''
          });
          list.push(n.id);
        }
      }
      if (n.children?.length) walk(n.children);
    });
  }(tree));
  return { list, meta };
}

/* Replace ids in-place using a Map(old->new) */
function remapTreeIds(tree, idMap){
  (function walk(nodes){
    nodes.forEach(n => {
      if (idMap.has(n.id)) n.id = idMap.get(n.id);
      if (n.children?.length) walk(n.children);
    });
  }(tree));
}

/* Limit depth helpers (you already had these) */
function depthOfUl(ul){
  let d = 0, node = ul;
  while (node && node.id !== 'menuNest') {
    const li = node.closest('li.dd-item');
    if (!li) break;
    d++; node = li.parentElement;
  }
  return d; /* 0=root, 1=submenu container */
}
function depthOfLi(li){ return depthOfUl(li.parentElement || li.closest('ul.dd-list')); }
function flattenGrandchildren(li){
  if (depthOfLi(li) !== 1) return;
  const child = li.querySelector(':scope > ul.dd-list');
  if (!child || !child.children.length) return;
  const container = li.parentElement;
  Array.from(child.children).forEach(kid => container.insertBefore(kid, li.nextElementSibling));
}

/* Template for an actual canvas item */
function ddHTML(id, title){
  return `
    <div class="dd-handle">
      <span class="title">${title}</span>
      <a href="javascript:void(0);" class="ml-3 text-danger del" data-id="${id}">
        <i class="fas fa-trash"></i>
      </a>
    </div>
    <ul class="dd-list"></ul>
  `;
}
function bindDel(btn){
  btn?.addEventListener('click', (e) => {
    e.preventDefault();
    // local remove only; DB delete should happen on your own "Save" flow if you want it persisted.
    const li = btn.closest('li.dd-item');
    li?.remove();
  });
}

/* ------------------ LEFT (clone only) ------------------ */
new Sortable(document.getElementById('paletteList'), {
  group: { name: 'menu', pull: 'clone', put: false },
  draggable: 'li.palette-item',
  sort: false,
  animation: 150,
  scroll: false,
  bubbleScroll: false,
  forceFallback: true,
  fallbackOnBody: true,
  fallbackTolerance: 4,
  onStart(){ document.body.classList.add('dragging-no-select'); },
  onEnd(){   document.body.classList.remove('dragging-no-select'); }
});

/* ------------------ RIGHT (drop zone) ------------------ */
function makeDroppable(ul){
  const myDepth  = depthOfUl(ul);                           // 0=root, 1=submenu container
  const scroller = RIGHT || ul.closest('.card-body') || document.scrollingElement;

  new Sortable(ul, {
    group: { name:'menu', pull:true, put: myDepth <= 1 },   // allow only 2 levels
    animation:150,
    direction:'vertical',
    scroll: scroller,
    bubbleScroll: true,
    scrollSensitivity: 60,
    scrollSpeed: 20,
    draggable: '.dd-item',           // only real items are draggable inside RIGHT
    filter: '.del,button,a',
    preventOnFilter:false,
    ghostClass: 'is-ghost',
    chosenClass: 'is-chosen',

    onAdd(evt){
      const el = evt.item;

      // If a PALETTE item was dropped, convert it immediately (no server yet)
      if (el.classList.contains('palette-item')) {
        const title     = el.dataset.title || 'Untitled';
        const type      = el.dataset.type  || 'custom';
        const url       = el.dataset.url   || '';
        const entity_id = el.dataset.entity_id || '';

        // temp id for new items — will be created on Save
        const tmpId = 'new-' + Math.random().toString(36).slice(2, 9);

        const li = document.createElement('li');
        li.className = 'dd-item';
        li.dataset.id = tmpId;
        // save meta for Save step
        li.dataset.title     = title;
        li.dataset.type      = type;
        li.dataset.url       = url;
        li.dataset.entity_id = entity_id;

        li.innerHTML = ddHTML(tmpId, title);
        el.replaceWith(li);

        bindDel(li.querySelector('.del'));
        makeDroppable(li.querySelector('.dd-list'));
        return;
      }

      // Moving an existing .dd-item: enforce max depth and flatten grandchildren
      const li = el;
      if (depthOfLi(li) > 1) {
        const parentLI = li.parentElement.closest('li.dd-item');
        if (parentLI && parentLI.parentElement) {
          parentLI.parentElement.insertBefore(li, parentLI.nextElementSibling);
        }
      }
      flattenGrandchildren(li);
      Array.from(li.parentElement.children).forEach(sib=>{
        if (sib.classList?.contains('dd-item')) flattenGrandchildren(sib);
      });
    }
  });
}

makeDroppable(NEST);
NEST.querySelectorAll(':scope .dd-list').forEach(makeDroppable);

/* ------------------ SAVE: create new, then reorder ------------------ */
document.querySelectorAll('.saveOrder').forEach(button => {
  button.addEventListener('click', async () => {
  const tree = serialize(NEST);                               // grab current structure
  const { list:newIds, meta } = collectNewNodes(tree, NEST);  // which nodes are new?

  // 1) create all "new-*" nodes first
  const idMap = new Map(); // newId -> realId
  for (const newId of newIds) {
    const m = meta.get(newId) || {};
    const { ok, json } = await postForm('<?= base_url('admin/menus/item/create') ?>', {
      menu_id: <?= (int)$MENU_ID ?>,
      parent_id: '',      // parent/order will be set by reorder step
      sort_order: 0,
      type: m.type || 'custom',
      title: m.title || 'Untitled',
      url: m.url || '',
      entity_id: m.entity_id || ''
    });
    if (!ok || !json?.id) {
      Swal.fire('Save Failed', 'Could not create a menu item.', 'error');
      return;
    }
    idMap.set(newId, String(json.id));

    // also update the DOM id so future serializes are correct without reload
    const li = Array.from(NEST.querySelectorAll('li.dd-item')).find(x => x.dataset.id === newId);
    if (li) li.dataset.id = String(json.id);
  }

  // 2) remap ids inside the tree we’re about to send
  if (idMap.size) remapTreeIds(tree, idMap);

  // 3) single reorder call with menu_id + tree
  const res = await fetch('<?= base_url('admin/menus/reorder') ?>', {
    method: 'POST',
    headers: { 'Content-Type':'application/json' },
    body: JSON.stringify({ menu_id: <?= (int)$MENU_ID ?>, tree, [CSRF.name]: CSRF.hash })
  });

  if (!res.ok) { Swal.fire('Save Failed', '', 'error'); return; }
  try { const j = await res.json(); if (j?.csrf) CSRF.hash = j.csrf; } catch {}
  Swal.fire('Menu Saved!', '', 'success');
});
});
</script>

<style>
/* LEFT palette */
.source-list { list-style:none; padding-left:0; margin:0; }
.palette-item {
  position:relative; padding:12px 14px;
  border:1px solid #e5e5e5; border-radius:10px; margin-bottom:8px;
  background:#fff; cursor:grab;
}
.palette-item.depth-1 { margin-left:35px; }

/* RIGHT canvas (WP-like cards) */
.dd-list{ list-style:none; padding:0; margin:0; }
.dd-item{ margin:8px 0; border:1px solid #e3e3e3; border-radius:10px; background:#fff; }
.dd-handle{ display:flex; justify-content:space-between; align-items:center;
  padding:12px 14px; background:#fafafa; border-radius:10px; cursor:grab; }

/* child container (always present, stable) */
.dd-item > .dd-list{ margin:0 0 0 22px; padding:0; border:0; }

/* ghost & chosen */
.is-chosen{ opacity:.95; }
.is-ghost{
  outline:2px dashed #90caf9;
  outline-offset:-2px;
  background:transparent;
  opacity:.6;
  box-sizing:border-box;
  list-style:none !important;       /* kill any bullets in the clone */
}

/* disable text selection while dragging */
.dragging-no-select, .dragging-no-select * { user-select: none !important; }

/* scrollbars rounded & inside radius */
.builder .card { --radius:16px; border-radius:var(--radius); overflow:hidden; }
.builder .card-body {
  max-height: calc(100vh - 200px);
  overflow-y: auto; overflow-x: hidden;
  scrollbar-gutter: stable both-edges;
}
.builder .card-body::-webkit-scrollbar { width: 10px; }
.builder .card-body::-webkit-scrollbar-track { background:transparent; margin:8px; border-radius:999px; }
.builder .card-body::-webkit-scrollbar-thumb { background:#bfc7d1; border-radius:999px; border:3px solid transparent; background-clip:content-box; }
.builder .card-body{ scrollbar-width:thin; scrollbar-color:#bfc7d1 transparent; }

/* prevent left pane interaction while locked during right-drag */
.drag-lock { 
  overflow: hidden !important;
  overscroll-behavior: contain;
  pointer-events: none;
}
.dd-list,
.dd-item,
.dd-item li,
.palette-item,
.is-ghost,
.is-ghost li,
.menu-ghost,
.sortable-chosen,
.sortable-fallback {
  list-style: none !important;
}
.sortable-fallback {
  list-style: none !important;
  margin: 0 !important;
  padding: 0 !important;
}

/* no bullets anywhere, including clones */
.dd-list, .dd-list li, #menuNest, #menuNest li, .palette-item { list-style:none !important; }
/* Hide scrollbar arrows (top/bottom buttons) */
.builder .card-body::-webkit-scrollbar-button {
  display: none !important;
  width: 0;
  height: 0;
}

#menuNest {
  min-height: 140px;   
  background: #f7fbff;
  border: 1px dashed #c7d7ea;
  border-radius: 12px;
  padding: 10px;                   /* room for the pointer */
}

/* once it has items, make it look neutral */
#menuNest.has-items {
  background: transparent;
  border: 0;
  padding: 0;
}
</style>


<?= $this->endSection() ?>

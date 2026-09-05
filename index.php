<?php
declare(strict_types=1);

$page = $_GET['page'] ?? 'dashboard';
$allowed = ['dashboard','agenda','patients','services','invoices','payments','ledger','statistics','users','settings'];
if (!in_array($page, $allowed, true)) $page = 'dashboard';

$titles = [
  'dashboard' => ['Dashboard', 'Una panoramica dello studio, oggi'],
  'agenda' => ['Agenda', 'Appuntamenti e disponibilità'],
  'patients' => ['Pazienti', 'Anagrafiche e cartelle cliniche'],
  'services' => ['Prestazioni', 'Catalogo delle prestazioni erogate'],
  'invoices' => ['Fatture', 'Documenti e prestazioni da fatturare'],
  'payments' => ['Pagamenti', 'Incassi, acconti e sospesi'],
  'ledger' => ['Prima nota', 'Movimenti e saldi dei conti'],
  'statistics' => ['Statistiche', 'Andamento e indicatori dello studio'],
  'users' => ['Utenti', 'Accessi, ruoli e permessi'],
  'settings' => ['Impostazioni', 'Orari, agenda e conti di saldo'],
];

$nav = [
 ['dashboard','grid','Dashboard'], ['agenda','calendar','Agenda'], ['patients','users','Pazienti'],
 ['services','activity','Prestazioni'], ['invoices','file','Fatture'], ['payments','card','Pagamenti'],
 ['ledger','book','Prima nota'], ['statistics','chart','Statistiche']
];

function icon(string $name, int $size = 20): string {
  $paths = [
    'grid'=>'<rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/>',
    'calendar'=>'<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 10h18"/>',
    'users'=>'<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>',
    'activity'=>'<path d="M22 12h-4l-3 9L9 3l-3 9H2"/>',
    'file'=>'<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zM14 2v6h6M8 13h8M8 17h6"/>',
    'card'=>'<rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/>',
    'book'=>'<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20V3H6.5A2.5 2.5 0 0 0 4 5.5zM4 5.5v14"/>',
    'chart'=>'<path d="M3 3v18h18M7 16l4-5 4 3 5-7"/>',
    'settings'=>'<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06-2.83 2.83-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21h-4v-.09a1.65 1.65 0 0 0-1.08-1.5 1.65 1.65 0 0 0-1.82.33l-.06.06-2.83-2.83.06-.06A1.65 1.65 0 0 0 4.6 15a1.65 1.65 0 0 0-1.51-1H3v-4h.09A1.65 1.65 0 0 0 4.6 9 1.65 1.65 0 0 0 4.27 7.2l-.06-.06 2.83-2.83.06.06A1.65 1.65 0 0 0 9 4.6 1.65 1.65 0 0 0 10 3.09V3h4v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06 2.83 2.83-.06.06A1.65 1.65 0 0 0 19.4 9c.12.61.65 1.05 1.27 1.06H21v4h-.09A1.65 1.65 0 0 0 19.4 15z"/>',
    'bell'=>'<path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M13.73 21a2 2 0 0 1-3.46 0"/>',
    'plus'=>'<path d="M12 5v14M5 12h14"/>', 'arrow'=>'<path d="M5 12h14M13 6l6 6-6 6"/>',
    'clock'=>'<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
    'search'=>'<circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>',
  ];
  return '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'.($paths[$name] ?? '').'</svg>';
}

function status(string $value): string { return '<span class="status '.strtolower(str_replace(' ', '-', $value)).'"><i></i>'.$value.'</span>'; }
?>
<!doctype html>
<html lang="it">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= htmlspecialchars($titles[$page][0]) ?> · Blueprint</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/app.css">
</head>
<body>
<aside class="sidebar" id="sidebar">
  <a class="brand" href="?page=dashboard" aria-label="Blueprint home">
    <span class="brand-mark"><span></span><b></b><i></i></span><strong>Blue<span>print</span></strong>
  </a>
  <nav><p>GESTIONE STUDIO</p>
    <?php foreach($nav as [$key,$ico,$label]): ?><a class="<?= $page===$key?'active':'' ?>" href="?page=<?=$key?>"><?=icon($ico)?> <span><?=$label?></span><?php if($key==='payments'):?><em>3</em><?php endif?></a><?php endforeach?>
    <p>AMMINISTRAZIONE</p>
    <a class="<?= $page==='users'?'active':'' ?>" href="?page=users"><?=icon('users')?> <span>Utenti</span></a>
    <a class="<?= $page==='settings'?'active':'' ?>" href="?page=settings"><?=icon('settings')?> <span>Impostazioni</span></a>
  </nav>
  <div class="help"><b>Hai bisogno di aiuto?</b><span>Consulta la guida di Blueprint</span><button>Apri la guida</button></div>
  <div class="profile"><span>MR</span><div><b>Marco Rossi</b><small>Amministratore</small></div><button>•••</button></div>
</aside>
<main>
  <header><button class="menu" id="menuBtn">☰</button><div><h1><?=$titles[$page][0]?></h1><p><?=$titles[$page][1]?></p></div><div class="header-actions"><button class="icon-btn"><?=icon('bell')?><i></i></button><span class="today">Sabato, 5 settembre 2026</span></div></header>
  <div class="content">
  <?php if($page==='dashboard'): ?>
    <section class="welcome"><div><span class="eyebrow">BUONGIORNO, MARCO</span><h2>Tutto sotto controllo.</h2><p>Hai <b>8 appuntamenti</b> in agenda oggi. Il prossimo è tra 25 minuti.</p></div><button class="primary" data-modal="appointment"><?=icon('plus')?> Nuovo appuntamento</button></section>
    <section class="metrics">
      <article><div class="metric-icon blue"><?=icon('calendar')?></div><div><span>APPUNTAMENTI OGGI</span><strong>8</strong><small><b>3</b> ancora da confermare</small></div></article>
      <article><div class="metric-icon green"><?=icon('activity')?></div><div><span>INCASSI DEL MESE</span><strong>€ 8.420</strong><small class="up">↗ 12,4% <i>rispetto ad agosto</i></small></div></article>
      <article><div class="metric-icon amber"><?=icon('file')?></div><div><span>DA INCASSARE</span><strong>€ 1.280</strong><small><b>6</b> fatture in sospeso</small></div></article>
      <article><div class="metric-icon purple"><?=icon('users')?></div><div><span>PAZIENTI ATTIVI</span><strong>142</strong><small><b>+9</b> questo mese</small></div></article>
    </section>
    <section class="dashboard-grid">
      <article class="panel appointments"><div class="panel-head"><div><h3>Agenda di oggi</h3><p>Sabato, 5 settembre</p></div><a href="?page=agenda">Vedi agenda <?=icon('arrow',16)?></a></div>
        <div class="timeline">
          <?php $events=[['09:00','09:45','Elena Bianchi','Tecarterapia','Confermato','EB'],['10:00','10:45','Luca Romano','Rieducazione posturale','Arrivato','LR'],['11:00','11:30','Giulia Conti','Massoterapia','Prenotato','GC'],['12:15','13:00','Andrea Greco','Fisioterapia manuale','Prenotato','AG']]; foreach($events as $i=>$e): ?>
          <div class="event <?= $i===1?'now':'' ?>"><div class="time"><b><?=$e[0]?></b><span><?=$e[1]?></span></div><div class="line"><i></i></div><div class="avatar c<?=$i?>"><?=$e[5]?></div><div class="event-info"><b><?=$e[2]?></b><span><?=$e[3]?></span></div><?=status($e[4])?><button>•••</button></div>
          <?php endforeach; ?>
        </div>
      </article>
      <div class="side-stack">
        <article class="panel"><div class="panel-head"><div><h3>Attività da completare</h3><p>Richiedono la tua attenzione</p></div></div>
          <a class="task" href="?page=payments"><span class="task-icon amber"><?=icon('file')?></span><div><b>6 fatture da incassare</b><small>Totale in sospeso € 1.280</small></div><span>›</span></a>
          <a class="task" href="?page=agenda"><span class="task-icon blue"><?=icon('calendar')?></span><div><b>3 appuntamenti da confermare</b><small>Previsti per oggi</small></div><span>›</span></a>
          <a class="task" href="?page=patients"><span class="task-icon red"><?=icon('users')?></span><div><b>2 cartelle da aggiornare</b><small>Note cliniche incomplete</small></div><span>›</span></a>
        </article>
        <article class="panel balance"><div class="panel-head"><div><h3>Saldi dei conti</h3><p>Aggiornati ad oggi</p></div><a href="?page=ledger">Dettagli</a></div>
          <div><span><i class="dot pos"></i>POS</span><b>€ 4.285,00</b></div><div><span><i class="dot bank"></i>Bonifico</span><b>€ 3.650,00</b></div><div><span><i class="dot cash"></i>Contanti</span><b>€ 1.790,00</b></div>
          <footer><span>Saldo totale</span><strong>€ 9.725,00</strong></footer>
        </article>
      </div>
    </section>
  <?php elseif($page==='patients'): ?>
    <?php include __DIR__.'/views/patients.php'; ?>
  <?php elseif($page==='agenda'): ?>
    <?php include __DIR__.'/views/agenda.php'; ?>
  <?php else: ?>
    <?php include __DIR__.'/views/module.php'; ?>
  <?php endif; ?>
  </div>
</main>
<div class="modal-wrap" id="appointment"><div class="modal"><button class="close">×</button><span class="eyebrow">AGENDA</span><h2>Nuovo appuntamento</h2><p>Inserisci i dettagli della prenotazione.</p><form><label>Paziente<select><option>Seleziona un paziente</option><option>Elena Bianchi</option><option>Luca Romano</option></select></label><div class="form-row"><label>Data<input type="date" value="2026-09-05"></label><label>Orario<select><option>14:00</option><option>14:30</option><option>15:00</option></select></label></div><label>Prestazione<select><option>Fisioterapia manuale · € 55</option><option>Tecarterapia · € 65</option></select></label><div class="modal-actions"><button type="button" class="secondary close-action">Annulla</button><button type="submit" class="primary">Salva appuntamento</button></div></form></div></div>
<?php if ($page === 'users'): ?>
<div class="modal-wrap" id="user" role="dialog" aria-modal="true" aria-labelledby="new-user-title">
  <div class="modal">
    <button class="close" type="button" aria-label="Chiudi">×</button>
    <span class="eyebrow">UTENTI</span><h2 id="new-user-title">Nuovo utente</h2><p>Crea un accesso e assegna i permessi corretti.</p>
    <form id="newUserForm">
      <div class="form-row"><label>Nome<input name="first_name" required autocomplete="given-name" placeholder="es. Laura"></label><label>Cognome<input name="last_name" required autocomplete="family-name" placeholder="es. Bianchi"></label></div>
      <label>Indirizzo email<input name="email" type="email" required autocomplete="email" placeholder="nome@studio.it"></label>
      <label>Numero di telefono<input name="phone" type="tel" required autocomplete="tel" placeholder="es. 333 123 4567"></label>
      <label>Ruolo<select name="role" required><option value="">Seleziona un ruolo</option><option>Amministratore</option><option>Segreteria</option><option>Fisioterapista</option></select><small class="field-hint">I permessi saranno applicati automaticamente in base al ruolo.</small></label>
      <div class="modal-actions"><button type="button" class="secondary close-action">Annulla</button><button type="submit" class="primary">Crea utente</button></div>
    </form>
  </div>
</div>
<?php endif; ?>
<div class="toast" id="toast" role="status" aria-live="polite">Utente creato correttamente</div>
<script src="assets/app.js"></script>
</body></html>

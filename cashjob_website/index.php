<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Vind jouw bijbaan';
$stmt = $pdo->query("SELECT j.*, u.company_name, u.name AS employer_name FROM jobs j JOIN users u ON u.id=j.employer_id WHERE j.status='published' ORDER BY j.created_at DESC LIMIT 6");
$jobs = $stmt->fetchAll();
include __DIR__ . '/includes/header.php';
?>
<section class="hero">
  <div class="container hero-grid">
    <div>
      <span class="eyebrow">Voor studenten met plannen</span>
      <h1>Een bijbaan die bij <span>jouw leven</span> past.</h1>
      <p class="lead">Vind werk dat past bij je leeftijd, studie en agenda. Vergelijk het uurloon en houd overzicht over je geld op één plek.</p>
      <div class="hero-actions"><a class="button" href="vacatures.php">Bekijk vacatures <span aria-hidden="true">→</span></a><a class="button button-outline" href="financien.php">Houd grip op je geld</a></div>
      <div class="hero-note"><div class="avatar-stack"><span class="avatar">🎓</span><span class="avatar">💼</span><span class="avatar">💶</span></div><span>Zoek gericht. Vergelijk slim. Kies zelf.</span></div>
    </div>
    <div class="hero-card">
      <div class="hero-card-top"><div><span class="eyebrow">Uitgelichte bijbanen</span><h3 style="margin-top:8px">Kansen deze week</h3></div><span class="pill">Demo</span></div>
      <div class="hero-job"><div class="job-logo orange">☕</div><div><h3>Barista</h3><div class="job-company">Horeca · Nijmegen</div></div><div class="job-pay">€ 15,00<span class="job-company">/ uur</span></div></div>
      <div class="hero-job"><div class="job-logo blue">🛒</div><div><h3>Winkelmedewerker</h3><div class="job-company">Retail · Arnhem</div></div><div class="job-pay">€ 14,50<span class="job-company">/ uur</span></div></div>
      <div class="hero-job"><div class="job-logo pink">🧸</div><div><h3>Assistent kinderopvang</h3><div class="job-company">Zorg · Nijmegen</div></div><div class="job-pay">€ 15,25<span class="job-company">/ uur</span></div></div>
      <div class="hero-card-foot">Voorbeeldbedragen voor de schooldemo. Bekijk de vacature voor voorwaarden.</div>
    </div>
  </div>
</section>
<section class="search-panel">
  <div class="container">
    <form class="search-box" action="vacatures.php" method="get">
      <div class="field"><label for="q">Wat voor werk zoek je?</label><input id="q" name="q" placeholder="Bijv. supermarkt, horeca"></div>
      <div class="field"><label for="location">Locatie</label><input id="location" name="location" placeholder="Bijv. Utrecht"></div>
      <div class="field"><label for="category">Soort werk</label><select id="category" name="category"><option value="">Alle categorieën</option><option>Horeca</option><option>Winkel</option><option>Zorg</option><option>Onderwijs</option><option>Kantoor</option><option>Overig</option></select></div>
      <button class="button" type="submit">Zoek banen</button>
    </form>
  </div>
</section>
<section class="section">
  <div class="container">
    <div class="section-head"><div><span class="eyebrow">Geselecteerd voor jou</span><h2>Populaire vacatures</h2><p>Bekijk de mogelijkheden en vergelijk het uurloon.</p></div><a class="text-link" href="vacatures.php">Alle vacatures bekijken →</a></div>
    <?php if ($jobs): ?><div class="jobs-grid">
      <?php foreach ($jobs as $job): ?>
      <article class="job-card">
        <div class="job-card-head"><div class="job-logo"><?= e($job['icon'] ?: '💼') ?></div><?php if (is_logged_in() && current_user()['role']==='student'): ?><a class="save-link" title="Opslaan" href="opslaan.php?id=<?= (int)$job['id'] ?>">♡</a><?php endif; ?></div>
        <h3><?= e($job['title']) ?></h3><div class="job-meta"><?= e($job['company_name'] ?: $job['employer_name']) ?></div><div class="job-meta">📍 <?= e($job['location']) ?></div>
        <div class="tag-row"><span class="tag"><?= e($job['category']) ?></span><span class="tag"><?= (int)$job['min_age'] ?>+ jaar</span><span class="tag"><?= e($job['hours_per_week']) ?> uur p/w</span></div>
        <div class="job-card-bottom"><div class="salary"><?= euro($job['hourly_wage']) ?><small>bruto per uur</small></div><a class="text-link" href="vacature.php?id=<?= (int)$job['id'] ?>">Details →</a></div>
      </article>
      <?php endforeach; ?>
    </div><?php else: ?><div class="empty-state">Er staan nog geen vacatures in de database. Importeer de SQL-demo of plaats een vacature als werkgever.</div><?php endif; ?>
  </div>
</section>
<section class="stats-strip"><div class="container stats-grid"><div class="stat"><strong>01</strong><span>Zoek op locatie en soort werk</span></div><div class="stat"><strong>02</strong><span>Vergelijk loon en werktijden</span></div><div class="stat"><strong>03</strong><span>Houd overzicht over je geld</span></div></div></section>
<section class="section"><div class="container"><div class="section-head"><div><span class="eyebrow">Meer overzicht</span><h2>Meer dan vacatures zoeken</h2><p>CashJob brengt je zoektocht naar werk en je geldzaken samen.</p></div></div><div class="feature-grid"><article class="feature"><div class="feature-icon">🔎</div><h3>Gericht zoeken</h3><p>Filter op locatie, categorie, leeftijd en uurloon om vacatures te vinden die bij je passen.</p></article><article class="feature"><div class="feature-icon">♡</div><h3>Bewaar je favorieten</h3><p>Sla interessante vacatures op en vergelijk ze later op je eigen moment.</p></article><article class="feature"><div class="feature-icon">💶</div><h3>Grip op je geld</h3><p>Registreer inkomsten en uitgaven, bekijk categorieën en houd je maandbudget bij.</p></article></div></div></section>
<section class="section-tight"><div class="container"><div class="cta"><div><h2>Klaar voor een volgende stap?</h2><p>Maak een account aan en houd je vacatures op één plek bij.</p></div><a class="button button-light" href="register.php">Maak gratis account →</a></div></div></section>
<?php include __DIR__ . '/includes/footer.php'; ?>

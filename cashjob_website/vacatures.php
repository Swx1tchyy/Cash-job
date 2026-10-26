<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Vacatures';
$q = trim($_GET['q'] ?? '');
$location = trim($_GET['location'] ?? '');
$category = trim($_GET['category'] ?? '');
$minWage = trim($_GET['min_wage'] ?? '');
$age = trim($_GET['age'] ?? '');
$sql = "SELECT j.*, u.company_name, u.name AS employer_name FROM jobs j JOIN users u ON u.id=j.employer_id WHERE j.status='published'";
$params = [];
if ($q !== '') { $sql .= " AND (j.title LIKE ? OR j.description LIKE ? OR u.company_name LIKE ? OR j.category LIKE ?)"; $term='%'.$q.'%'; array_push($params,$term,$term,$term,$term); }
if ($location !== '') { $sql .= " AND j.location LIKE ?"; $params[]='%'.$location.'%'; }
if ($category !== '') { $sql .= " AND j.category = ?"; $params[]=$category; }
if ($minWage !== '' && is_numeric($minWage)) { $sql .= " AND j.hourly_wage >= ?"; $params[]=(float)$minWage; }
if ($age !== '' && is_numeric($age)) { $sql .= " AND j.min_age <= ? AND (j.max_age IS NULL OR j.max_age >= ?)"; $params[]=(int)$age; $params[]=(int)$age; }
$sql .= " ORDER BY j.hourly_wage DESC, j.created_at DESC";
$stmt=$pdo->prepare($sql); $stmt->execute($params); $jobs=$stmt->fetchAll();
include __DIR__ . '/includes/header.php';
?>
<section class="page-intro"><div class="container"><span class="eyebrow">Jouw volgende bijbaan</span><h1>Vind werk dat bij je past.</h1><p>Zoek op functie, locatie en categorie. Vergelijk het uurloon en controleer de leeftijdsvoorwaarden.</p></div></section>
<section class="content-section"><div class="container">
<form class="filters-panel" method="get"><div class="filters-grid">
<div class="field"><label for="q">Zoekterm</label><input id="q" name="q" value="<?= e($q) ?>" placeholder="Functie, bedrijf of trefwoord"></div>
<div class="field"><label for="location">Locatie</label><input id="location" name="location" value="<?= e($location) ?>" placeholder="Plaats of regio"></div>
<div class="field"><label for="category">Categorie</label><select id="category" name="category"><option value="">Alles</option><?php foreach(['Horeca','Winkel','Zorg','Onderwijs','Kantoor','Overig'] as $option): ?><option value="<?= e($option) ?>" <?= $category===$option?'selected':'' ?>><?= e($option) ?></option><?php endforeach; ?></select></div>
<div class="field"><label for="age">Jouw leeftijd</label><input id="age" name="age" type="number" min="13" max="100" value="<?= e($age) ?>" placeholder="Bijv. 18"></div>
<div class="field"><label for="min_wage">Min. uurloon (€)</label><input id="min_wage" name="min_wage" type="number" min="0" step=".01" value="<?= e($minWage) ?>" placeholder="Bijv. 14"></div>
</div><div class="action-row" style="margin-top:15px"><button class="button" type="submit">Filters toepassen</button><a class="button button-outline" href="vacatures.php">Wis filters</a></div></form>
<p class="result-count"><?= count($jobs) ?> vacature<?= count($jobs)===1?'':'s' ?> gevonden</p>
<?php if ($jobs): ?><div class="jobs-grid"><?php foreach($jobs as $job): ?>
<article class="job-card"><div class="job-card-head"><div class="job-logo"><?= e($job['icon'] ?: '💼') ?></div><?php if(is_logged_in() && current_user()['role']==='student'): ?><a class="save-link" href="opslaan.php?id=<?= (int)$job['id'] ?>" aria-label="Vacature opslaan">♡</a><?php endif; ?></div>
<h3><?= e($job['title']) ?></h3><div class="job-meta"><?= e($job['company_name'] ?: $job['employer_name']) ?></div><div class="job-meta">📍 <?= e($job['location']) ?></div>
<div class="tag-row"><span class="tag"><?= e($job['category']) ?></span><span class="tag"><?= (int)$job['min_age'] ?>+ jaar</span><span class="tag"><?= e($job['hours_per_week']) ?> uur p/w</span><?php if($job['schedule']): ?><span class="tag"><?= e($job['schedule']) ?></span><?php endif; ?></div>
<div class="job-card-bottom"><div class="salary"><?= euro($job['hourly_wage']) ?><small>bruto per uur</small></div><a class="text-link" href="vacature.php?id=<?= (int)$job['id'] ?>">Bekijk vacature →</a></div></article>
<?php endforeach; ?></div><?php else: ?><div class="empty-state"><h3>Geen vacatures gevonden</h3><p>Pas je zoekterm of filters aan en probeer het opnieuw.</p><a class="button button-outline" href="vacatures.php">Toon alle vacatures</a></div><?php endif; ?>
</div></section>
<?php include __DIR__ . '/includes/footer.php'; ?>

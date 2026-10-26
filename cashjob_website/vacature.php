<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) { redirect('vacatures.php'); }
$stmt=$pdo->prepare("SELECT j.*,u.company_name,u.name AS employer_name,u.email AS employer_email FROM jobs j JOIN users u ON u.id=j.employer_id WHERE j.id=? AND j.status='published'");
$stmt->execute([$id]); $job=$stmt->fetch();
if(!$job){http_response_code(404);$pageTitle='Vacature niet gevonden';include __DIR__.'/includes/header.php';echo '<section class="content-section container"><div class="empty-state"><h2>Vacature niet gevonden</h2><a class="button" href="vacatures.php">Terug naar vacatures</a></div></section>';include __DIR__.'/includes/footer.php';exit;}
$pageTitle=$job['title'];
$success='';$error='';
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['apply'])){
    require_login();
    if(($_SESSION['user_role']??'')!=='student'){$error='Alleen een studentenaccount kan solliciteren.';}
    else{
        $cover=trim($_POST['cover_letter']??'');
        $check=$pdo->prepare("SELECT id FROM applications WHERE job_id=? AND user_id=?");$check->execute([$id,$_SESSION['user_id']]);
        if($check->fetch()){$error='Je hebt al op deze vacature gesolliciteerd.';}
        else{$insert=$pdo->prepare("INSERT INTO applications(job_id,user_id,cover_letter) VALUES(?,?,?)");$insert->execute([$id,$_SESSION['user_id'],$cover]);$success='Je sollicitatie is opgeslagen. De werkgever ziet deze in het dashboard.';}
    }
}
include __DIR__ . '/includes/header.php';
?>
<section class="page-intro"><div class="container"><a class="text-link" href="vacatures.php">← Terug naar vacatures</a><div class="detail-top" style="margin-top:25px"><div class="job-logo"><?= e($job['icon'] ?: '💼') ?></div><div><span class="eyebrow"><?= e($job['category']) ?></span><h1 class="detail-title"><?= e($job['title']) ?></h1><p><?= e($job['company_name'] ?: $job['employer_name']) ?> · 📍 <?= e($job['location']) ?></p></div></div></div></section>
<section class="content-section"><div class="container two-column"><div>
<div class="panel"><h2>Over deze bijbaan</h2><div class="prose"><?= nl2br(e($job['description'])) ?></div><h3 style="margin-top:25px">Wat je gaat doen</h3><div class="prose"><?= nl2br(e($job['responsibilities'] ?: 'De precieze werkzaamheden bespreekt de werkgever tijdens het sollicitatieproces.')) ?></div><h3 style="margin-top:25px">Wat we zoeken</h3><div class="prose"><?= nl2br(e($job['requirements'] ?: 'Controleer de leeftijdsvoorwaarden en bespreek je beschikbaarheid met de werkgever.')) ?></div></div>
<div class="panel"><h2>Solliciteren</h2><?php if($success): ?><div class="form-success"><?= e($success) ?></div><?php elseif($error): ?><div class="form-error"><?= e($error) ?></div><?php endif; ?>
<?php if(!is_logged_in()): ?><p>Log in met een studentenaccount om te solliciteren.</p><a class="button" href="login.php?redirect=<?= urlencode('vacature.php?id='.$id) ?>">Inloggen om te solliciteren</a>
<?php elseif(($_SESSION['user_role']??'')==='student' && !$success): ?><form class="form-stack" method="post"><div class="field"><label for="cover_letter">Korte motivatie (optioneel)</label><textarea id="cover_letter" name="cover_letter" rows="5" placeholder="Vertel kort waarom deze bijbaan bij je past."></textarea></div><button class="button" type="submit" name="apply" value="1">Sollicitatie versturen</button></form><?php elseif(($_SESSION['user_role']??'')==='werkgever'): ?><p>Je bent ingelogd als werkgever. Gebruik je dashboard om vacatures te beheren.</p><?php endif; ?></div>
</div><aside><div class="panel"><span class="eyebrow">Vacaturegegevens</span><div class="detail-facts"><div class="fact"><span>Uurloon</span><strong><?= euro($job['hourly_wage']) ?> bruto</strong></div><div class="fact"><span>Uren per week</span><strong><?= e($job['hours_per_week']) ?> uur</strong></div><div class="fact"><span>Leeftijd</span><strong><?= (int)$job['min_age'] ?>+ jaar<?= $job['max_age']?' tot '.(int)$job['max_age']:'' ?></strong></div><div class="fact"><span>Werktijden</span><strong><?= e($job['schedule'] ?: 'In overleg') ?></strong></div></div><p class="job-meta">Geplaatst op <?= date('d-m-Y',strtotime($job['created_at'])) ?></p><?php if(is_logged_in() && current_user()['role']==='student'): ?><a class="button button-outline" style="width:100%;margin-top:12px" href="opslaan.php?id=<?= (int)$job['id'] ?>">♡ Vacature opslaan</a><?php endif; ?></div><div class="panel"><h3>Over de werkgever</h3><p><?= e($job['company_name'] ?: $job['employer_name']) ?></p><p class="job-meta">Contactgegevens worden na contact met de werkgever gedeeld.</p></div></aside></div></section>
<?php include __DIR__ . '/includes/footer.php'; ?>

<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
$pageTitle='Account aanmaken';$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name=trim($_POST['name']??'');$email=strtolower(trim($_POST['email']??''));$password=$_POST['password']??'';$role=$_POST['role']??'student';$company=trim($_POST['company_name']??'');
    if(mb_strlen($name)<2){$error='Vul een naam van minimaal 2 tekens in.';}
    elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){$error='Vul een geldig e-mailadres in.';}
    elseif(strlen($password)<8){$error='Kies een wachtwoord van minimaal 8 tekens.';}
    elseif(!in_array($role,['student','werkgever'],true)){$error='Kies een geldige accountsoort.';}
    elseif($role==='werkgever' && $company===''){$error='Vul de bedrijfsnaam in.';}
    else{
        $check=$pdo->prepare('SELECT id FROM users WHERE email=?');$check->execute([$email]);
        if($check->fetch()){$error='Er bestaat al een account met dit e-mailadres.';}
        else{$hash=password_hash($password,PASSWORD_DEFAULT);$stmt=$pdo->prepare('INSERT INTO users(name,email,password_hash,role,company_name) VALUES(?,?,?,?,?)');$stmt->execute([$name,$email,$hash,$role,$role==='werkgever'?$company:null]);$_SESSION['user_id']=(int)$pdo->lastInsertId();$_SESSION['user_name']=$name;$_SESSION['user_email']=$email;$_SESSION['user_role']=$role;redirect('dashboard.php');}
    }
}
include __DIR__.'/includes/header.php';
?>
<section class="auth-wrap"><div class="container"><div class="auth-card"><span class="eyebrow">Begin vandaag</span><h1>Maak je account</h1><p>Bewaar vacatures, solliciteer of bereik studenten als werkgever.</p><?php if($error): ?><div class="form-error"><?= e($error) ?></div><?php endif; ?>
<form class="form-stack" method="post" id="registerForm"><div class="field"><label for="name">Naam</label><input id="name" name="name" autocomplete="name" required minlength="2" value="<?= e($_POST['name']??'') ?>"></div><div class="field"><label for="email">E-mailadres</label><input id="email" name="email" type="email" autocomplete="email" required value="<?= e($_POST['email']??'') ?>"></div><div class="field"><label for="role">Ik ben een...</label><select id="role" name="role"><option value="student" <?= ($_POST['role']??'student')==='student'?'selected':'' ?>>Student, ik zoek werk</option><option value="werkgever" <?= ($_POST['role']??'')==='werkgever'?'selected':'' ?>>Werkgever, ik plaats vacatures</option></select></div><div class="field" id="companyField" hidden><label for="company_name">Bedrijfsnaam</label><input id="company_name" name="company_name" value="<?= e($_POST['company_name']??'') ?>"></div><div class="field"><label for="password">Wachtwoord</label><input id="password" name="password" type="password" minlength="8" autocomplete="new-password" required><span class="form-help">Minimaal 8 tekens.</span></div><button class="button" type="submit">Account aanmaken</button></form><p class="auth-switch">Heb je al een account? <a class="text-link" href="login.php">Inloggen</a></p></div></div></section>
<script>const roleSelect=document.getElementById('role'),companyField=document.getElementById('companyField'),companyInput=document.getElementById('company_name');function updateCompany(){const show=roleSelect.value==='werkgever';companyField.hidden=!show;companyInput.required=show;}roleSelect.addEventListener('change',updateCompany);updateCompany();</script>
<?php include __DIR__.'/includes/footer.php'; ?>

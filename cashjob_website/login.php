<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
$pageTitle='Inloggen';$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $email=strtolower(trim($_POST['email']??''));$password=$_POST['password']??'';
    $stmt=$pdo->prepare('SELECT id,name,email,password_hash,role FROM users WHERE email=? LIMIT 1');$stmt->execute([$email]);$user=$stmt->fetch();
    if($user && password_verify($password,$user['password_hash'])){
        session_regenerate_id(true);$_SESSION['user_id']=(int)$user['id'];$_SESSION['user_name']=$user['name'];$_SESSION['user_email']=$user['email'];$_SESSION['user_role']=$user['role'];
        $redirect=$_POST['redirect']??'';if($redirect!=='' && str_starts_with($redirect,'/')===false && !str_contains($redirect,'://') && !str_starts_with($redirect,'\\\\')){redirect($redirect);}
        redirect('dashboard.php');
    }else{$error='E-mailadres of wachtwoord klopt niet.';}
}
include __DIR__.'/includes/header.php';
?>
<section class="auth-wrap"><div class="container"><div class="auth-card"><span class="eyebrow">Welkom terug</span><h1>Log in bij CashJob</h1><p>Ga verder met je vacatures en persoonlijke overzicht.</p><?php if(isset($_GET['registered'])): ?><div class="form-success">Je account is aangemaakt. Je kunt nu inloggen.</div><?php endif; ?><?php if($error): ?><div class="form-error"><?= e($error) ?></div><?php endif; ?><form class="form-stack" method="post"><input type="hidden" name="redirect" value="<?= e($_GET['redirect']??'') ?>"><div class="field"><label for="email">E-mailadres</label><input id="email" name="email" type="email" autocomplete="email" required value="<?= e($_POST['email']??'') ?>"></div><div class="field"><label for="password">Wachtwoord</label><input id="password" name="password" type="password" autocomplete="current-password" required></div><button class="button" type="submit">Inloggen</button></form><p class="auth-switch">Nog geen account? <a class="text-link" href="register.php">Registreer gratis</a></p></div></div></section>
<?php include __DIR__.'/includes/footer.php'; ?>

<?php
require_once __DIR__.'/config/database.php';require_once __DIR__.'/includes/functions.php';require_login();
if(($_SESSION['user_role']??'')!=='student'){redirect('dashboard.php');}
$id=filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);if(!$id){redirect('vacatures.php');}
$stmt=$pdo->prepare("SELECT id FROM jobs WHERE id=? AND status='published'");$stmt->execute([$id]);if(!$stmt->fetch()){redirect('vacatures.php');}
$stmt=$pdo->prepare("SELECT id FROM saved_jobs WHERE user_id=? AND job_id=?");$stmt->execute([$_SESSION['user_id'],$id]);
if($stmt->fetch()){$stmt=$pdo->prepare("DELETE FROM saved_jobs WHERE user_id=? AND job_id=?");$stmt->execute([$_SESSION['user_id'],$id]);}
else{$stmt=$pdo->prepare("INSERT IGNORE INTO saved_jobs(user_id,job_id) VALUES(?,?)");$stmt->execute([$_SESSION['user_id'],$id]);}
$back=$_SERVER['HTTP_REFERER']??'opgeslagen.php';if(str_contains($back,'://') && !str_starts_with($back,'http://localhost') && !str_starts_with($back,'http://127.0.0.1')){$back='opgeslagen.php';}redirect($back);

<?php
require_once __DIR__ . '/functions.php';
$pageTitle = $pageTitle ?? 'CashJob';
$user = current_user();
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Vind een bijbaan die past bij jouw studie, leeftijd en agenda.">
    <title><?= e($pageTitle) ?> | CashJob</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="site-header">
    <div class="container nav-wrap">
        <a class="brand" href="index.php"><span class="brand-mark">C</span><span>cash<span class="brand-accent">job</span></span></a>
        <button class="menu-toggle" type="button" aria-label="Menu openen" aria-expanded="false">☰</button>
        <nav class="main-nav" aria-label="Hoofdnavigatie">
            <a href="vacatures.php">Vacatures</a>
            <?php if ($user && $user['role'] === 'student'): ?>
                <a href="opgeslagen.php">Opgeslagen</a>
                <a href="financien.php">Mijn geld</a>
            <?php endif; ?>
            <?php if ($user && $user['role'] === 'werkgever'): ?>
                <a href="werkgever.php">Werkgeversdashboard</a>
            <?php endif; ?>
            <?php if ($user): ?>
                <a href="dashboard.php">Mijn dashboard</a>
                <a class="nav-user" href="profiel.php"><?= e($user['name']) ?></a>
                <a class="button button-small button-outline" href="logout.php">Uitloggen</a>
            <?php else: ?>
                <a href="login.php">Inloggen</a>
                <a class="button button-small" href="register.php">Gratis account</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main>

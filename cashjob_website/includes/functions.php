<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function e(?string $value): string {
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function is_logged_in(): bool {
    return isset($_SESSION['user_id']);
}

function current_user(): ?array {
    if (!is_logged_in()) {
        return null;
    }
    return [
        'id' => (int) $_SESSION['user_id'],
        'name' => (string) ($_SESSION['user_name'] ?? 'Gebruiker'),
        'role' => (string) ($_SESSION['user_role'] ?? 'student'),
        'email' => (string) ($_SESSION['user_email'] ?? ''),
    ];
}

function require_login(): void {
    if (!is_logged_in()) {
        header('Location: login.php?redirect=' . urlencode($_SERVER['REQUEST_URI'] ?? 'dashboard.php'));
        exit;
    }
}

function require_role(string $role): void {
    require_login();
    if (($_SESSION['user_role'] ?? '') !== $role) {
        http_response_code(403);
        exit('Je hebt geen toegang tot deze pagina.');
    }
}

function redirect(string $url): never {
    header('Location: ' . $url);
    exit;
}

function euro(float|string|null $amount): string {
    return '€ ' . number_format((float) $amount, 2, ',', '.');
}

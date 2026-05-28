<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' — Turbocharged' : 'Turbocharged Car Care' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', system-ui, sans-serif; }</style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex flex-col">

<nav class="bg-slate-900 border-b border-slate-800 sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 flex items-center justify-between h-16">
        <a href="index.php" class="flex items-center gap-2 text-orange-400 font-bold text-lg tracking-wider">
            ⚡ TURBOCHARGED
        </a>

        <button id="menu-btn" class="md:hidden text-slate-400 hover:text-white p-2" aria-label="Toggle menu">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <div class="hidden md:flex items-center gap-6 text-sm font-medium">
            <?php if (empty($_SESSION['email'])): ?>
                <a href="index.php" class="text-slate-300 hover:text-orange-400 transition-colors">Home</a>
                <a href="spares.php" class="text-slate-300 hover:text-orange-400 transition-colors">Spare Parts</a>
                <a href="contact_us.php" class="text-slate-300 hover:text-orange-400 transition-colors">Contact</a>
                <a href="account.php" class="border border-orange-500 text-orange-400 px-4 py-1.5 rounded-lg hover:bg-orange-500 hover:text-white transition-all">Login</a>
                <a href="login.php" class="bg-orange-500 text-white px-4 py-1.5 rounded-lg hover:bg-orange-600 transition-colors">Admin</a>
            <?php else: ?>
                <a href="index.php" class="text-slate-300 hover:text-orange-400 transition-colors">Home</a>
                <a href="status.php" class="text-slate-300 hover:text-orange-400 transition-colors">My Status</a>
                <a href="message_admin.php" class="text-slate-300 hover:text-orange-400 transition-colors">Contact Us</a>
                <a href="admin/logout.php" class="border border-red-500 text-red-400 px-4 py-1.5 rounded-lg hover:bg-red-500 hover:text-white transition-all">Logout</a>
            <?php endif; ?>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden border-t border-slate-800 px-4 py-3 space-y-1 text-sm font-medium">
        <?php if (empty($_SESSION['email'])): ?>
            <a href="index.php" class="block text-slate-300 hover:text-orange-400 py-2 transition-colors">Home</a>
            <a href="spares.php" class="block text-slate-300 hover:text-orange-400 py-2 transition-colors">Spare Parts</a>
            <a href="contact_us.php" class="block text-slate-300 hover:text-orange-400 py-2 transition-colors">Contact</a>
            <a href="account.php" class="block text-orange-400 py-2">Customer Login</a>
            <a href="login.php" class="block text-orange-400 py-2">Admin Login</a>
        <?php else: ?>
            <a href="index.php" class="block text-slate-300 hover:text-orange-400 py-2 transition-colors">Home</a>
            <a href="status.php" class="block text-slate-300 hover:text-orange-400 py-2 transition-colors">My Status</a>
            <a href="message_admin.php" class="block text-slate-300 hover:text-orange-400 py-2 transition-colors">Contact Us</a>
            <a href="admin/logout.php" class="block text-red-400 py-2">Logout</a>
        <?php endif; ?>
    </div>
</nav>

<script>
document.getElementById('menu-btn').addEventListener('click', function () {
    document.getElementById('mobile-menu').classList.toggle('hidden');
});
</script>

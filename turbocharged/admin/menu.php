<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['uname'])) {
    header('Location: ../login.php');
    exit;
}
?>
<nav class="bg-slate-900 border-b border-slate-800 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 flex items-center justify-between h-16">
        <div class="flex items-center gap-8">
            <a href="index.php" class="text-orange-400 font-bold text-lg tracking-wider">⚡ TURBOCHARGED</a>
            <span class="text-slate-600 text-sm hidden md:block">Admin Panel</span>
        </div>

        <div class="flex items-center gap-1 text-sm">
            <a href="index.php"
               class="px-3 py-2 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition-all">
                📋 Messages
            </a>
            <a href="add_vehicles.php"
               class="px-3 py-2 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition-all">
                🚗 Vehicles
            </a>
            <a href="client_requests.php"
               class="px-3 py-2 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition-all">
                📝 Requests
            </a>
        </div>

        <div class="flex items-center gap-4 text-sm">
            <span class="text-slate-400 hidden sm:block">
                👤 <span class="text-white font-medium"><?= htmlspecialchars($_SESSION['uname']) ?></span>
            </span>
            <a href="logout.php"
               class="border border-red-500/60 text-red-400 px-3 py-1.5 rounded-lg hover:bg-red-500 hover:text-white transition-all text-xs font-medium">
                Logout
            </a>
        </div>
    </div>
</nav>

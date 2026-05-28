<?php
include '../includes/config.php';
$stmt = $conn->prepare("SELECT * FROM message ORDER BY time DESC");
$stmt->execute();
$messages = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages — Turbocharged Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Inter', system-ui, sans-serif; }</style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex flex-col">

<?php include 'menu.php'; ?>

<main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 py-8 w-full">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="index.php" class="hover:text-orange-400 transition-colors">Dashboard</a>
        <span>›</span>
        <span class="text-slate-300">Client Messages</span>
    </div>

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-white">Client Messages</h1>
        <span class="bg-slate-800 border border-slate-700 text-slate-300 text-sm px-3 py-1 rounded-full">
            <?= count($messages) ?> total
        </span>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <?php if (empty($messages)): ?>
            <div class="text-center py-16 text-slate-400">
                <div class="text-4xl mb-3">📭</div>
                <p>No messages yet.</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-800 text-left">
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Message</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Time</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        <?php foreach ($messages as $row): ?>
                        <tr class="hover:bg-slate-800/40 transition-colors">
                            <td class="px-6 py-4">
                                <p class="text-white font-medium leading-relaxed max-w-lg">
                                    <?= htmlspecialchars($row['message']) ?>
                                </p>
                            </td>
                            <td class="px-6 py-4 text-slate-400 whitespace-nowrap">
                                <?= $row['time'] !== '0000-00-00 00:00:00' ? htmlspecialchars($row['time']) : '—' ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php if ($row['status'] === 'Unread'): ?>
                                    <span class="bg-yellow-900/40 border border-yellow-500/50 text-yellow-400 text-xs px-2.5 py-1 rounded-full font-medium">Unread</span>
                                <?php else: ?>
                                    <span class="bg-green-900/40 border border-green-500/50 text-green-400 text-xs px-2.5 py-1 rounded-full font-medium">Read</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button onclick="confirmDelete(<?= (int)$row['msg_id'] ?>)"
                                        class="text-red-400 hover:text-red-300 text-xs font-medium border border-red-500/40 hover:border-red-400 px-3 py-1 rounded-lg transition-all">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</main>

<footer class="bg-slate-900 border-t border-slate-800 py-4 text-center text-slate-500 text-xs">
    &copy; <?= date('Y') ?> Turbocharged Car Care Center
</footer>

<script>
function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this message?')) {
        window.location.href = 'delete_msg.php?id=' + id;
    }
}
</script>
</body>
</html>

<?php
include '../includes/config.php';
$stmt = $conn->prepare(
    "SELECT client.client_id, client.fname, client.phone, client.status, client.mpesa,
            cars.car_name, cars.hire_cost
     FROM client
     LEFT JOIN cars ON client.car_id = cars.car_id
     ORDER BY client.client_id DESC"
);
$stmt->execute();
$requests = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Requests — Turbocharged Admin</title>
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
        <span class="text-slate-300">Service Requests</span>
    </div>

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-white">Service Requests</h1>
        <div class="flex items-center gap-3">
            <span class="bg-slate-800 border border-slate-700 text-slate-300 text-sm px-3 py-1 rounded-full">
                <?= count($requests) ?> total
            </span>
            <button onclick="window.print()"
                    class="border border-slate-700 text-slate-300 text-sm px-4 py-1.5 rounded-lg hover:border-slate-500 transition-all">
                🖨 Print
            </button>
        </div>
    </div>

    <!-- Stats summary -->
    <?php
    $pending  = count(array_filter($requests, fn($r) => $r['status'] === 'Pending'));
    $approved = count(array_filter($requests, fn($r) => $r['status'] === 'Approved'));
    ?>
    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="bg-slate-900 border border-slate-800 rounded-xl p-4 text-center">
            <p class="text-2xl font-bold text-white"><?= count($requests) ?></p>
            <p class="text-xs text-slate-400 mt-1 uppercase tracking-wider">Total</p>
        </div>
        <div class="bg-yellow-900/20 border border-yellow-500/30 rounded-xl p-4 text-center">
            <p class="text-2xl font-bold text-yellow-400"><?= $pending ?></p>
            <p class="text-xs text-slate-400 mt-1 uppercase tracking-wider">Pending</p>
        </div>
        <div class="bg-green-900/20 border border-green-500/30 rounded-xl p-4 text-center">
            <p class="text-2xl font-bold text-green-400"><?= $approved ?></p>
            <p class="text-xs text-slate-400 mt-1 uppercase tracking-wider">Approved</p>
        </div>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <?php if (empty($requests)): ?>
            <div class="text-center py-16 text-slate-400">
                <div class="text-4xl mb-3">📋</div>
                <p>No service requests yet.</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-800 text-left">
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Client</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Phone</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Vehicle</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Txn ID</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        <?php foreach ($requests as $row): ?>
                        <tr class="hover:bg-slate-800/40 transition-colors">
                            <td class="px-6 py-4">
                                <p class="text-white font-medium"><?= htmlspecialchars($row['fname']) ?></p>
                            </td>
                            <td class="px-6 py-4 text-slate-300"><?= htmlspecialchars($row['phone']) ?></td>
                            <td class="px-6 py-4 text-slate-300"><?= htmlspecialchars($row['car_name'] ?? '—') ?></td>
                            <td class="px-6 py-4 text-orange-400 font-medium">
                                <?= !empty($row['hire_cost']) ? '₹' . number_format($row['hire_cost']) : '—' ?>
                            </td>
                            <td class="px-6 py-4 text-slate-400 font-mono text-xs">
                                <?= !empty($row['mpesa']) ? htmlspecialchars($row['mpesa']) : '—' ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php if ($row['status'] === 'Approved'): ?>
                                    <span class="bg-green-900/40 border border-green-500/50 text-green-400 text-xs px-2.5 py-1 rounded-full font-medium">Approved</span>
                                <?php elseif ($row['status'] === 'Pending'): ?>
                                    <span class="bg-yellow-900/40 border border-yellow-500/50 text-yellow-400 text-xs px-2.5 py-1 rounded-full font-medium">Pending</span>
                                <?php else: ?>
                                    <span class="bg-slate-800 border border-slate-700 text-slate-300 text-xs px-2.5 py-1 rounded-full font-medium"><?= htmlspecialchars($row['status']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <?php if ($row['status'] !== 'Approved'): ?>
                                    <button onclick="confirmApprove(<?= (int)$row['client_id'] ?>)"
                                            class="bg-green-600 hover:bg-green-500 text-white text-xs font-medium px-3 py-1.5 rounded-lg transition-colors">
                                        Approve
                                    </button>
                                <?php else: ?>
                                    <span class="text-slate-600 text-xs">—</span>
                                <?php endif; ?>
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
function confirmApprove(id) {
    if (confirm('Approve this service request?')) {
        window.location.href = 'approve.php?id=' + id;
    }
}
</script>
</body>
</html>

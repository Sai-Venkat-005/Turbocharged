<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (empty($_SESSION['email'])) {
    header('Location: account.php');
    exit;
}

include 'includes/config.php';
$email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT client.*, cars.car_name, cars.hire_cost FROM client LEFT JOIN cars ON client.car_id = cars.car_id WHERE client.email = ?");
$stmt->bind_param('s', $email);
$stmt->execute();
$rws = $stmt->get_result()->fetch_assoc();

$pageTitle = 'My Booking Status';
include 'header.php';

$statusColors = [
    'Approved' => 'text-green-400 bg-green-900/30 border-green-500/50',
    'Pending'  => 'text-yellow-400 bg-yellow-900/30 border-yellow-500/50',
    'Rejected' => 'text-red-400 bg-red-900/30 border-red-500/50',
];
$statusIcons = [
    'Approved' => '✅',
    'Pending'  => '⏳',
    'Rejected' => '❌',
];
$status = $rws['status'] ?? 'Pending';
$colorClass = $statusColors[$status] ?? 'text-slate-300 bg-slate-800 border-slate-700';
$icon = $statusIcons[$status] ?? '🔄';
?>

<main class="flex-1 max-w-2xl mx-auto px-4 sm:px-6 py-12 w-full">
    <h1 class="text-2xl font-bold text-white mb-8">My Service Booking</h1>

    <?php if (!$rws): ?>
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-8 text-center">
            <div class="text-4xl mb-4">📋</div>
            <p class="text-slate-400">No booking found for your account.</p>
            <a href="index.php" class="inline-block mt-4 text-orange-400 hover:text-orange-300 text-sm transition-colors">Browse service packages →</a>
        </div>
    <?php else: ?>
        <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
            <!-- Status banner -->
            <div class="border-b border-slate-800 p-6 flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-400 mb-1">Booking Status</p>
                    <div class="flex items-center gap-2">
                        <span class="text-2xl"><?= $icon ?></span>
                        <span class="text-2xl font-bold <?= str_contains($colorClass, 'green') ? 'text-green-400' : (str_contains($colorClass, 'yellow') ? 'text-yellow-400' : 'text-red-400') ?>">
                            <?= htmlspecialchars($status) ?>
                        </span>
                    </div>
                </div>
                <div class="border <?= $colorClass ?> rounded-full px-4 py-1.5 text-sm font-medium">
                    <?= htmlspecialchars($status) ?>
                </div>
            </div>

            <!-- Booking details -->
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-slate-800/50 rounded-lg p-4">
                    <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Name</p>
                    <p class="text-white font-medium"><?= htmlspecialchars($rws['fname']) ?></p>
                </div>
                <div class="bg-slate-800/50 rounded-lg p-4">
                    <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Email</p>
                    <p class="text-white font-medium"><?= htmlspecialchars($rws['email']) ?></p>
                </div>
                <?php if (!empty($rws['car_name'])): ?>
                <div class="bg-slate-800/50 rounded-lg p-4">
                    <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Vehicle</p>
                    <p class="text-white font-medium"><?= htmlspecialchars($rws['car_name']) ?></p>
                </div>
                <div class="bg-slate-800/50 rounded-lg p-4">
                    <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Service Amount</p>
                    <p class="text-orange-400 font-bold text-lg">₹<?= number_format($rws['hire_cost']) ?></p>
                </div>
                <?php endif; ?>
                <div class="bg-slate-800/50 rounded-lg p-4">
                    <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Vehicle Reg. No.</p>
                    <p class="text-white font-medium"><?= htmlspecialchars($rws['reg_no'] ?? '—') ?></p>
                </div>
                <div class="bg-slate-800/50 rounded-lg p-4">
                    <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Transaction ID</p>
                    <p class="text-white font-medium"><?= !empty($rws['mpesa']) ? htmlspecialchars($rws['mpesa']) : '—' ?></p>
                </div>
            </div>

            <?php if ($status === 'Pending'): ?>
            <div class="border-t border-slate-800 p-6 bg-yellow-900/10">
                <p class="text-yellow-400 text-sm">⏳ Your request is under review. You'll be notified once it's approved.</p>
            </div>
            <?php elseif ($status === 'Approved'): ?>
            <div class="border-t border-slate-800 p-6 bg-green-900/10">
                <p class="text-green-400 text-sm">✅ Your service booking has been approved! Please visit the service center.</p>
            </div>
            <?php endif; ?>
        </div>

        <div class="mt-4 text-center">
            <a href="message_admin.php" class="text-sm text-orange-400 hover:text-orange-300 transition-colors">Have a question? Contact us →</a>
        </div>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>

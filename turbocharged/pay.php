<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$error = '';

if (isset($_POST['pay'])) {
    include 'includes/config.php';
    $txn_id = trim($_POST['txn_id']);
    $reg_no = trim($_POST['reg_no']);

    $stmt = $conn->prepare("UPDATE client SET mpesa = ? WHERE reg_no = ?");
    $stmt->bind_param('ss', $txn_id, $reg_no);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        header('Location: wait.php');
        exit;
    } else {
        $error = 'Could not record payment. Please verify your registration number and try again.';
    }
}

$pageTitle = 'Payment';
include 'header.php';
?>

<main class="flex-1 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <!-- Steps indicator -->
        <div class="flex items-center justify-center gap-3 mb-8 text-sm">
            <div class="flex items-center gap-1.5 text-green-400"><span class="w-6 h-6 rounded-full bg-green-500/20 border border-green-500 flex items-center justify-center text-xs font-bold">✓</span> Booking</div>
            <div class="flex-1 h-px bg-orange-500 max-w-12"></div>
            <div class="flex items-center gap-1.5 text-orange-400 font-semibold"><span class="w-6 h-6 rounded-full bg-orange-500/20 border border-orange-500 flex items-center justify-center text-xs font-bold">2</span> Payment</div>
            <div class="flex-1 h-px bg-slate-700 max-w-12"></div>
            <div class="flex items-center gap-1.5 text-slate-500"><span class="w-6 h-6 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-xs font-bold">3</span> Confirm</div>
        </div>

        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-8 shadow-xl">
            <div class="text-center mb-8">
                <div class="text-4xl mb-3">💳</div>
                <h1 class="text-2xl font-bold text-white">Make Payment</h1>
                <p class="text-slate-400 text-sm mt-1">Transfer the amount and enter your transaction ID below</p>
            </div>

            <div class="bg-slate-800/60 border border-slate-700 rounded-lg p-4 mb-6 text-sm text-slate-300">
                <p class="font-medium text-white mb-2">Payment Instructions</p>
                <p class="text-slate-400">Transfer the service amount to our UPI / bank account, then submit your Transaction ID and vehicle registration number below.</p>
            </div>

            <?php if ($error): ?>
            <div class="bg-red-900/30 border border-red-500/50 rounded-lg p-3 text-red-400 text-sm mb-6">
                <?= htmlspecialchars($error) ?>
            </div>
            <?php endif; ?>

            <form method="post" class="space-y-5">
                <div>
                    <label for="txn_id" class="block text-sm font-medium text-slate-300 mb-1.5">Transaction ID</label>
                    <input type="text" id="txn_id" name="txn_id" required
                           placeholder="e.g. GTD45H7H6"
                           class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                </div>
                <div>
                    <label for="reg_no" class="block text-sm font-medium text-slate-300 mb-1.5">Vehicle Registration Number</label>
                    <input type="text" id="reg_no" name="reg_no" required
                           placeholder="e.g. TS09AB1234"
                           class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                </div>
                <button type="submit" name="pay"
                        class="w-full bg-orange-500 text-white py-2.5 rounded-lg font-semibold hover:bg-orange-600 transition-colors focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 focus:ring-offset-slate-900 mt-2">
                    Submit Payment Details →
                </button>
            </form>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

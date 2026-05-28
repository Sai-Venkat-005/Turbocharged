<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$error = '';

if (isset($_POST['log'])) {
    include 'includes/config.php';
    $uname = trim($_POST['email']);
    $pass  = trim($_POST['pass']);

    $stmt = $conn->prepare("SELECT * FROM client WHERE email = ? AND reg_no = ?");
    $stmt->bind_param('ss', $uname, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        $_SESSION['pass']  = $row['reg_no'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid email or registration number. Please try again.';
    }
}

$pageTitle = 'Customer Login';
include 'header.php';
?>

<main class="flex-1 flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-md">
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-8 shadow-xl">
            <div class="text-center mb-8">
                <div class="text-4xl mb-3">🔑</div>
                <h1 class="text-2xl font-bold text-white">Customer Login</h1>
                <p class="text-slate-400 text-sm mt-1">Sign in to track your service request</p>
            </div>

            <?php if ($error): ?>
            <div class="bg-red-900/30 border border-red-500/50 rounded-lg p-3 text-red-400 text-sm mb-6">
                <?= htmlspecialchars($error) ?>
            </div>
            <?php endif; ?>

            <form method="post" class="space-y-5">
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-300 mb-1.5">Email Address</label>
                    <input type="email" id="email" name="email" required
                           placeholder="you@example.com"
                           class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                </div>
                <div>
                    <label for="pass" class="block text-sm font-medium text-slate-300 mb-1.5">Password <span class="text-slate-500 font-normal">(Vehicle Reg. Number)</span></label>
                    <input type="password" id="pass" name="pass" required
                           placeholder="Enter your registration number"
                           class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                </div>
                <button type="submit" name="log"
                        class="w-full bg-orange-500 text-white py-2.5 rounded-lg font-semibold hover:bg-orange-600 transition-colors focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 focus:ring-offset-slate-900 mt-2">
                    Login
                </button>
            </form>

            <p class="text-center text-slate-400 text-sm mt-6">
                New customer?
                <a href="signup.php" class="text-orange-400 hover:text-orange-300 font-medium transition-colors">Register here</a>
            </p>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

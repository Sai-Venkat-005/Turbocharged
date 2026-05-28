<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$error = '';
$success = '';

if (isset($_POST['save'])) {
    include 'includes/config.php';
    $fname    = trim($_POST['fname']);
    $reg_no   = trim($_POST['reg_no']);
    $gender   = $_POST['gender'];
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $location = trim($_POST['location']);

    $stmt = $conn->prepare(
        "INSERT INTO client (fname, reg_no, gender, email, phone, location, status) VALUES (?, ?, ?, ?, ?, ?, 'Available')"
    );
    $stmt->bind_param('ssssss', $fname, $reg_no, $gender, $email, $phone, $location);

    if ($stmt->execute()) {
        header('Location: account.php?registered=1');
        exit;
    } else {
        $error = 'Registration failed. Please try again.';
    }
}

$pageTitle = 'Register';
include 'header.php';
?>

<main class="flex-1 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-lg">
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-8 shadow-xl">
            <div class="text-center mb-8">
                <div class="text-4xl mb-3">🚗</div>
                <h1 class="text-2xl font-bold text-white">Create Account</h1>
                <p class="text-slate-400 text-sm mt-1">Register to book a service for your vehicle</p>
            </div>

            <?php if ($error): ?>
            <div class="bg-red-900/30 border border-red-500/50 rounded-lg p-3 text-red-400 text-sm mb-6">
                <?= htmlspecialchars($error) ?>
            </div>
            <?php endif; ?>

            <form method="post" class="space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="fname" class="block text-sm font-medium text-slate-300 mb-1.5">Full Name</label>
                        <input type="text" id="fname" name="fname" required
                               placeholder="John Doe"
                               class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-slate-300 mb-1.5">Phone Number</label>
                        <input type="tel" id="phone" name="phone" required
                               placeholder="9XXXXXXXXX"
                               class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-300 mb-1.5">Email Address</label>
                    <input type="email" id="email" name="email" required
                           placeholder="you@example.com"
                           class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                </div>

                <div>
                    <label for="reg_no" class="block text-sm font-medium text-slate-300 mb-1.5">Vehicle Registration Number <span class="text-slate-500 font-normal">(used as password)</span></label>
                    <input type="text" id="reg_no" name="reg_no" required
                           placeholder="e.g. TS09AB1234"
                           class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="gender" class="block text-sm font-medium text-slate-300 mb-1.5">Gender</label>
                        <select id="gender" name="gender"
                                class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label for="location" class="block text-sm font-medium text-slate-300 mb-1.5">Location</label>
                        <input type="text" id="location" name="location" required
                               placeholder="City / Area"
                               class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                    </div>
                </div>

                <button type="submit" name="save"
                        class="w-full bg-orange-500 text-white py-2.5 rounded-lg font-semibold hover:bg-orange-600 transition-colors focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 focus:ring-offset-slate-900 mt-2">
                    Create Account
                </button>
            </form>

            <p class="text-center text-slate-400 text-sm mt-6">
                Already have an account?
                <a href="account.php" class="text-orange-400 hover:text-orange-300 font-medium transition-colors">Login here</a>
            </p>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

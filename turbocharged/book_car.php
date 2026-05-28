<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include 'includes/config.php';

$id = intval($_GET['id'] ?? 0);
$error = '';

// Fetch car details
$stmt = $conn->prepare("SELECT * FROM cars WHERE car_id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$rws = $stmt->get_result()->fetch_assoc();

if (!$rws) {
    header('Location: index.php');
    exit;
}

// Handle booking form (guest users fill in details)
if (isset($_POST['save'])) {
    $fname    = trim($_POST['fname']);
    $reg_no   = trim($_POST['reg_no']);
    $gender   = $_POST['gender'];
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $location = trim($_POST['location']);

    $ins = $conn->prepare(
        "INSERT INTO client (fname, reg_no, gender, email, phone, location, car_id, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')"
    );
    $ins->bind_param('ssssssi', $fname, $reg_no, $gender, $email, $phone, $location, $id);

    if ($ins->execute()) {
        $_SESSION['email'] = $email;
        $_SESSION['pass']  = $reg_no;
        header('Location: pay.php');
        exit;
    } else {
        $error = 'Booking failed. Please try again.';
    }
}

$pageTitle = 'Book Service — ' . htmlspecialchars($rws['car_name']);
include 'header.php';
?>

<main class="flex-1 max-w-5xl mx-auto px-4 sm:px-6 py-10 w-full">
    <!-- Breadcrumb -->
    <nav class="text-sm text-slate-400 mb-8">
        <a href="index.php" class="hover:text-orange-400 transition-colors">Home</a>
        <span class="mx-2">/</span>
        <span class="text-slate-300">Book Service</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Vehicle card -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
            <div class="h-56 bg-slate-800 overflow-hidden">
                <img src="cars/<?= htmlspecialchars($rws['image']) ?>"
                     alt="<?= htmlspecialchars($rws['car_name']) ?>"
                     class="w-full h-full object-cover">
            </div>
            <div class="p-6">
                <h2 class="text-2xl font-bold text-white"><?= htmlspecialchars($rws['car_name']) ?></h2>
                <p class="text-slate-400 mt-1"><?= htmlspecialchars($rws['car_type']) ?></p>
                <div class="mt-4 pt-4 border-t border-slate-800">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400 text-sm">Service Package Price</span>
                        <span class="text-orange-400 font-bold text-2xl">₹<?= number_format($rws['hire_cost']) ?></span>
                    </div>
                </div>
                <div class="mt-4 bg-slate-800/60 rounded-lg p-4 text-sm text-slate-400 space-y-1">
                    <div class="flex items-center gap-2"><span class="text-orange-400">✓</span> Admin review within 24 hours</div>
                    <div class="flex items-center gap-2"><span class="text-orange-400">✓</span> UPI / bank transfer payment</div>
                    <div class="flex items-center gap-2"><span class="text-orange-400">✓</span> Status tracked online</div>
                </div>
            </div>
        </div>

        <!-- Booking form -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6">
            <?php if (!empty($_SESSION['email'])): ?>
                <h3 class="text-xl font-semibold text-white mb-2">Ready to Book</h3>
                <p class="text-slate-400 text-sm mb-6">You're logged in as <span class="text-orange-400"><?= htmlspecialchars($_SESSION['email']) ?></span>.</p>
                <a href="pay.php"
                   class="block w-full text-center bg-orange-500 text-white py-3 rounded-lg font-semibold hover:bg-orange-600 transition-colors">
                    Proceed to Payment →
                </a>
            <?php else: ?>
                <h3 class="text-xl font-semibold text-white mb-1">Your Details</h3>
                <p class="text-slate-400 text-sm mb-6">Fill in your details to book this service.</p>

                <?php if ($error): ?>
                <div class="bg-red-900/30 border border-red-500/50 rounded-lg p-3 text-red-400 text-sm mb-5">
                    <?= htmlspecialchars($error) ?>
                </div>
                <?php endif; ?>

                <form method="post" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-1.5">Full Name</label>
                            <input type="text" name="fname" required placeholder="John Doe"
                                   class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-1.5">Phone Number</label>
                            <input type="tel" name="phone" required placeholder="9XXXXXXXXX"
                                   class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Email Address</label>
                        <input type="email" name="email" required placeholder="you@example.com"
                               class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Vehicle Reg. Number <span class="text-slate-500 font-normal">(becomes your password)</span></label>
                        <input type="text" name="reg_no" required placeholder="TS09AB1234"
                               class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-1.5">Gender</label>
                            <select name="gender"
                                    class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-1.5">Location</label>
                            <input type="text" name="location" required placeholder="City / Area"
                                   class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                        </div>
                    </div>
                    <button type="submit" name="save"
                            class="w-full bg-orange-500 text-white py-2.5 rounded-lg font-semibold hover:bg-orange-600 transition-colors focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 focus:ring-offset-slate-900 mt-1">
                        Submit &amp; Proceed to Payment →
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

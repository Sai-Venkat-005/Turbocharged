<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$error = '';

if (isset($_POST['send'])) {
    include 'includes/config.php';
    $message   = trim($_POST['message']);
    $client_id = $_SESSION['email'] ?? 0;

    $stmt = $conn->prepare("INSERT INTO message (message, client_id, time, status) VALUES (?, ?, NOW(), 'Unread')");
    $stmt->bind_param('ss', $message, $client_id);

    if ($stmt->execute()) {
        header('Location: success.php');
        exit;
    } else {
        $error = 'Message could not be sent. Please try again.';
    }
}

$pageTitle = 'Contact Us';
include 'header.php';
?>

<main class="flex-1 max-w-2xl mx-auto px-4 sm:px-6 py-12 w-full">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-white">Send Us a Message</h1>
        <p class="text-slate-400 text-sm mt-1">Have a question or concern? Our team will get back to you shortly.</p>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 md:p-8">
        <?php if ($error): ?>
        <div class="bg-red-900/30 border border-red-500/50 rounded-lg p-3 text-red-400 text-sm mb-6">
            <?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>

        <form method="post" class="space-y-5">
            <div>
                <label for="message" class="block text-sm font-medium text-slate-300 mb-1.5">Your Message</label>
                <textarea id="message" name="message" required rows="6"
                          placeholder="Describe your query or concern here..."
                          class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition resize-none"></textarea>
            </div>
            <button type="submit" name="send"
                    class="w-full bg-orange-500 text-white py-2.5 rounded-lg font-semibold hover:bg-orange-600 transition-colors focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 focus:ring-offset-slate-900">
                Send Message →
            </button>
        </form>
    </div>

    <div class="mt-6 bg-slate-900 border border-slate-800 rounded-xl p-5 text-sm text-slate-400">
        <p class="font-medium text-slate-300 mb-3">Other ways to reach us</p>
        <div class="space-y-2">
            <div class="flex items-center gap-3"><span class="text-orange-400">📞</span> 9515925928</div>
            <div class="flex items-center gap-3"><span class="text-orange-400">✉</span> teamturbocharged@gmail.com</div>
            <div class="flex items-center gap-3"><span class="text-orange-400">📍</span> NH-65, Abdullapurmet, Rangareddy, Telangana — 501512</div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

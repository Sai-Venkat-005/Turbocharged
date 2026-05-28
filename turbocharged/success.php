<?php
$pageTitle = 'Message Sent';
include 'header.php';
?>

<main class="flex-1 flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-md text-center">
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-10 shadow-xl">
            <div class="text-6xl mb-6">✅</div>
            <h1 class="text-2xl font-bold text-white mb-3">Message Sent!</h1>
            <p class="text-slate-400 leading-relaxed mb-8">
                Thank you for reaching out. We'll contact you shortly via call or email.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="index.php"
                   class="bg-orange-500 text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-orange-600 transition-colors">
                    Back to Home
                </a>
                <a href="status.php"
                   class="border border-slate-700 text-slate-300 px-6 py-2.5 rounded-lg hover:border-slate-500 transition-colors">
                    View My Status
                </a>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

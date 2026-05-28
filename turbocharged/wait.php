<?php
$pageTitle = 'Request Submitted';
include 'header.php';
?>

<main class="flex-1 flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-lg text-center">
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-10 shadow-xl">
            <div class="text-6xl mb-6">⏳</div>
            <h1 class="text-2xl font-bold text-white mb-3">Booking Submitted!</h1>
            <p class="text-slate-400 leading-relaxed mb-6">
                Thank you for sending your service request to Team Turbocharged.
                We will review your payment and get back to you within <span class="text-white font-medium">24 hours</span>.
            </p>
            <div class="bg-slate-800/60 border border-slate-700 rounded-lg p-4 text-sm text-slate-400 text-left mb-8">
                <p class="font-medium text-slate-300 mb-2">What's next?</p>
                <ul class="space-y-1.5">
                    <li class="flex gap-2"><span class="text-orange-400 shrink-0">1.</span> We verify your payment transaction.</li>
                    <li class="flex gap-2"><span class="text-orange-400 shrink-0">2.</span> Admin approves your booking.</li>
                    <li class="flex gap-2"><span class="text-orange-400 shrink-0">3.</span> You receive confirmation — bring your vehicle in!</li>
                </ul>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="account.php"
                   class="bg-orange-500 text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-orange-600 transition-colors">
                    Login to Track Status
                </a>
                <a href="index.php"
                   class="border border-slate-700 text-slate-300 px-6 py-2.5 rounded-lg hover:border-slate-500 transition-colors">
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

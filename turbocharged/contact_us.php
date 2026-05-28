<?php
$pageTitle = 'Contact Us';
include 'header.php';
?>

<main class="flex-1 max-w-4xl mx-auto px-4 sm:px-6 py-12 w-full">
    <h1 class="text-3xl font-bold text-white mb-2">Contact Us</h1>
    <p class="text-slate-400 mb-10">We'd love to hear from you. Visit us or get in touch.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Contact info -->
        <div class="space-y-6">
            <div class="bg-slate-900 border border-slate-800 rounded-xl p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Turbocharged Car Care Center</h2>
                <div class="space-y-4 text-sm">
                    <div class="flex gap-3">
                        <span class="text-orange-400 text-xl shrink-0">📍</span>
                        <div>
                            <p class="text-white font-medium">Address</p>
                            <p class="text-slate-400 mt-0.5">NH-65, Abdullapurmet<br>Rangareddy, Telangana — 501512</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <span class="text-orange-400 text-xl shrink-0">📞</span>
                        <div>
                            <p class="text-white font-medium">Phone</p>
                            <a href="tel:9515925928" class="text-slate-400 hover:text-orange-400 transition-colors mt-0.5 block">9515925928</a>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <span class="text-orange-400 text-xl shrink-0">✉</span>
                        <div>
                            <p class="text-white font-medium">Email</p>
                            <a href="mailto:teamturbocharged@gmail.com" class="text-slate-400 hover:text-orange-400 transition-colors mt-0.5 block">teamturbocharged@gmail.com</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-slate-900 border border-slate-800 rounded-xl p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Our Services</h2>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li class="flex items-center gap-2"><span class="text-orange-400">✓</span> Washing &amp; Sanitization</li>
                    <li class="flex items-center gap-2"><span class="text-orange-400">✓</span> Complete Servicing</li>
                    <li class="flex items-center gap-2"><span class="text-orange-400">✓</span> Wheel Balancing &amp; Alignment</li>
                    <li class="flex items-center gap-2"><span class="text-orange-400">✓</span> Engine Diagnostics</li>
                    <li class="flex items-center gap-2"><span class="text-orange-400">✓</span> Genuine Spare Parts</li>
                </ul>
            </div>
        </div>

        <!-- Map -->
        <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden">
            <a href="https://www.google.com/maps/search/Abdullapurmet+NH-65+Rangareddy+Telangana"
               target="_blank" rel="noopener noreferrer" class="block">
                <div class="h-72 bg-slate-800 flex items-center justify-center text-slate-500 hover:text-orange-400 transition-colors">
                    <div class="text-center">
                        <div class="text-5xl mb-3">🗺️</div>
                        <p class="font-medium text-slate-300">View on Google Maps</p>
                        <p class="text-sm mt-1">NH-65, Abdullapurmet</p>
                    </div>
                </div>
            </a>
            <div class="p-5 border-t border-slate-800">
                <p class="text-sm text-slate-400">Click above to open our location in Google Maps and get directions.</p>
                <a href="message_admin.php"
                   class="mt-4 block w-full text-center bg-orange-500 text-white py-2 rounded-lg text-sm font-medium hover:bg-orange-600 transition-colors">
                    Send Us a Message →
                </a>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

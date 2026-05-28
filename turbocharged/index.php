<?php
include 'includes/config.php';
$pageTitle = 'Home';
$stmt = $conn->prepare("SELECT * FROM cars WHERE status = 'Available'");
$stmt->execute();
$cars = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
include 'header.php';
?>

<div class="bg-gradient-to-br from-slate-900 via-slate-900 to-slate-950 border-b border-slate-800 py-20 text-center">
    <div class="max-w-2xl mx-auto px-4">
        <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4 leading-tight">
            Find Your <span class="text-orange-400">Service Package</span>
        </h1>
        <p class="text-slate-400 text-lg">Professional car care for your favourite vehicle. Book online in minutes.</p>
        <div class="mt-8 flex flex-wrap justify-center gap-6 text-sm text-slate-400">
            <div class="flex items-center gap-2"><span class="text-orange-400">✓</span> Expert Technicians</div>
            <div class="flex items-center gap-2"><span class="text-orange-400">✓</span> Genuine Parts</div>
            <div class="flex items-center gap-2"><span class="text-orange-400">✓</span> Transparent Pricing</div>
        </div>
    </div>
</div>

<main class="flex-1 max-w-6xl mx-auto px-4 sm:px-6 py-12 w-full">
    <h2 class="text-2xl font-bold text-white mb-8">Available Service Packages</h2>

    <?php if (empty($cars)): ?>
        <div class="text-center py-20 text-slate-400">
            <div class="text-5xl mb-4">🔧</div>
            <p class="text-lg">No service packages available at the moment.</p>
            <p class="text-sm mt-2">Check back soon — more vehicles will be added.</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($cars as $rws): ?>
            <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden hover:border-orange-500/40 transition-all group">
                <a href="book_car.php?id=<?= (int)$rws['car_id'] ?>">
                    <div class="overflow-hidden h-48 bg-slate-800">
                        <img src="cars/<?= htmlspecialchars($rws['image']) ?>"
                             alt="<?= htmlspecialchars($rws['car_name']) ?>"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                </a>
                <div class="p-5">
                    <h3 class="text-lg font-semibold text-white"><?= htmlspecialchars($rws['car_name']) ?></h3>
                    <p class="text-slate-400 text-sm mt-1"><?= htmlspecialchars($rws['car_type']) ?></p>
                    <div class="flex items-center justify-between mt-5">
                        <span class="text-orange-400 font-bold text-xl">₹<?= number_format($rws['hire_cost']) ?></span>
                        <a href="book_car.php?id=<?= (int)$rws['car_id'] ?>"
                           class="bg-orange-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-orange-600 transition-colors font-medium">
                            Book Now →
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>

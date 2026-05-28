<?php
include 'includes/config.php';
$pageTitle = 'Spare Parts';
$stmt = $conn->prepare("SELECT * FROM spares WHERE status = 'Available'");
$stmt->execute();
$parts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
include 'header.php';
?>

<div class="bg-gradient-to-br from-slate-900 via-slate-900 to-slate-950 border-b border-slate-800 py-16 text-center">
    <div class="max-w-2xl mx-auto px-4">
        <h1 class="text-4xl font-bold text-white mb-3">Spare <span class="text-orange-400">Parts</span></h1>
        <p class="text-slate-400 text-lg">Genuine spare parts and accessories for your vehicle</p>
    </div>
</div>

<main class="flex-1 max-w-6xl mx-auto px-4 sm:px-6 py-12 w-full">
    <?php if (empty($parts)): ?>
        <div class="text-center py-20 text-slate-400">
            <div class="text-5xl mb-4">🔩</div>
            <p class="text-lg">No spare parts available at the moment.</p>
            <p class="text-sm mt-2">Check back soon — more parts will be added.</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($parts as $rws): ?>
            <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden hover:border-orange-500/40 transition-all group">
                <a href="book_spare.php?id=<?= (int)$rws['spare_id'] ?>">
                    <div class="overflow-hidden h-48 bg-slate-800">
                        <img src="spares/<?= htmlspecialchars($rws['image']) ?>"
                             alt="<?= htmlspecialchars($rws['car_name']) ?>"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                </a>
                <div class="p-5">
                    <h3 class="text-lg font-semibold text-white"><?= htmlspecialchars($rws['car_name']) ?></h3>
                    <p class="text-slate-400 text-sm mt-1"><?= htmlspecialchars($rws['spare_type']) ?></p>
                    <div class="flex items-center justify-between mt-5">
                        <span class="text-orange-400 font-bold text-xl">₹<?= number_format($rws['spare_cost']) ?></span>
                        <a href="book_spare.php?id=<?= (int)$rws['spare_id'] ?>"
                           class="bg-orange-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-orange-600 transition-colors font-medium">
                            Order Now →
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>

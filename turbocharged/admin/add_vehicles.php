<?php
include '../includes/config.php';
$error   = '';
$success = '';

// Handle add vehicle form
if (isset($_POST['add_car'])) {
    $car_name  = trim($_POST['car_name']);
    $car_type  = trim($_POST['car_type']);
    $hire_cost = intval($_POST['hire_cost']);
    $capacity  = intval($_POST['capacity']);
    $image     = trim($_POST['image']);

    $stmt = $conn->prepare(
        "INSERT INTO cars (car_name, car_type, image, hire_cost, capacity, status) VALUES (?, ?, ?, ?, ?, 'Available')"
    );
    $stmt->bind_param('sssii', $car_name, $car_type, $image, $hire_cost, $capacity);
    if ($stmt->execute()) {
        $success = 'Vehicle added successfully.';
    } else {
        $error = 'Failed to add vehicle. Please try again.';
    }
}

$stmt = $conn->prepare("SELECT * FROM cars WHERE status = 'Available' ORDER BY car_id DESC");
$stmt->execute();
$vehicles = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Management — Turbocharged Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Inter', system-ui, sans-serif; }</style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex flex-col">

<?php include 'menu.php'; ?>

<main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 py-8 w-full">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="index.php" class="hover:text-orange-400 transition-colors">Dashboard</a>
        <span>›</span>
        <span class="text-slate-300">Vehicle Management</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Vehicle list -->
        <div class="lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-2xl font-bold text-white">Vehicles</h1>
                <span class="bg-slate-800 border border-slate-700 text-slate-300 text-sm px-3 py-1 rounded-full">
                    <?= count($vehicles) ?> listed
                </span>
            </div>

            <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
                <?php if (empty($vehicles)): ?>
                    <div class="text-center py-16 text-slate-400">
                        <div class="text-4xl mb-3">🚗</div>
                        <p>No vehicles listed yet.</p>
                    </div>
                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-800 text-left">
                                    <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Make</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800">
                                <?php foreach ($vehicles as $row): ?>
                                <tr class="hover:bg-slate-800/40 transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="text-white font-medium"><?= htmlspecialchars($row['car_name']) ?></p>
                                    </td>
                                    <td class="px-6 py-4 text-slate-300"><?= htmlspecialchars($row['car_type']) ?></td>
                                    <td class="px-6 py-4 text-orange-400 font-medium">₹<?= number_format($row['hire_cost']) ?></td>
                                    <td class="px-6 py-4 text-right">
                                        <button onclick="confirmDelete(<?= (int)$row['car_id'] ?>)"
                                                class="text-red-400 hover:text-red-300 text-xs font-medium border border-red-500/40 hover:border-red-400 px-3 py-1 rounded-lg transition-all">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Add vehicle form -->
        <div>
            <h2 class="text-lg font-bold text-white mb-4">Add New Vehicle</h2>
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6">
                <?php if ($success): ?>
                <div class="bg-green-900/30 border border-green-500/50 rounded-lg p-3 text-green-400 text-sm mb-5">
                    <?= htmlspecialchars($success) ?>
                </div>
                <?php endif; ?>
                <?php if ($error): ?>
                <div class="bg-red-900/30 border border-red-500/50 rounded-lg p-3 text-red-400 text-sm mb-5">
                    <?= htmlspecialchars($error) ?>
                </div>
                <?php endif; ?>

                <form method="post" class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-400 mb-1.5 uppercase tracking-wider">Car Make</label>
                        <input type="text" name="car_name" required placeholder="e.g. Maruti Suzuki"
                               class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-400 mb-1.5 uppercase tracking-wider">Car Model / Type</label>
                        <input type="text" name="car_type" required placeholder="e.g. Swift Dzire"
                               class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-400 mb-1.5 uppercase tracking-wider">Image Filename</label>
                        <input type="text" name="image" required placeholder="e.g. car8.jpg"
                               class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-sm">
                        <p class="text-xs text-slate-500 mt-1">Upload image to the <code class="text-orange-400">cars/</code> directory first.</p>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1.5 uppercase tracking-wider">Price (₹)</label>
                            <input type="number" name="hire_cost" required placeholder="20000" min="0"
                                   class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1.5 uppercase tracking-wider">Capacity</label>
                            <input type="number" name="capacity" required placeholder="5" min="1"
                                   class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-sm">
                        </div>
                    </div>
                    <button type="submit" name="add_car"
                            class="w-full bg-orange-500 text-white py-2.5 rounded-lg font-semibold text-sm hover:bg-orange-600 transition-colors focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 focus:ring-offset-slate-900 mt-1">
                        Add Vehicle
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>

<footer class="bg-slate-900 border-t border-slate-800 py-4 text-center text-slate-500 text-xs">
    &copy; <?= date('Y') ?> Turbocharged Car Care Center
</footer>

<script>
function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this vehicle?')) {
        window.location.href = 'delete_car.php?id=' + id;
    }
}
</script>
</body>
</html>

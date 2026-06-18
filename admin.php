<?php
require_once 'db.php';

$message = "";
$status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $title = trim($_POST['title']);
    $points = intval($_POST['points']);
    $region = $_POST['region'];
    
    $vanilla = $_POST['tier_vanilla'];
    $uhc = $_POST['tier_uhc'];
    $pot = $_POST['tier_pot'];
    $netpot = $_POST['tier_netpot'];
    $smp = $_POST['tier_smp'];
    $sword = $_POST['tier_sword'];
    $axe = $_POST['tier_axe'];
    $mace = $_POST['tier_mace'];

    if (!empty($username)) {
        $sql = "INSERT INTO players (username, title, points, region, tier_vanilla, tier_uhc, tier_pot, tier_netpot, tier_smp, tier_sword, tier_axe, tier_mace) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssisssssssss", $username, $title, $points, $region, $vanilla, $uhc, $pot, $netpot, $smp, $sword, $axe, $mace);
            if ($stmt->execute()) {
                $message = "Player successfully added to ranks database!";
                $status = "success";
            } else {
                $message = "Database error: " . $stmt->error;
                $status = "error";
            }
            $stmt->close();
        }
    } else {
        $message = "Please enter a valid Minecraft username.";
        $status = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mythic Tiers - Add Player</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body { background-color: #0b0f19; color: #f3f4f6; }
    </style>
</head>
<body class="p-6 md:p-12">

    <div class="max-w-3xl mx-auto bg-[#111827] border border-[#1f2937] rounded-xl shadow-2xl p-6 md:p-8">
        
        <div class="flex items-center justify-between border-b border-[#1f2937] pb-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold tracking-wide text-white">Add New Player Record</h1>
                <p class="text-sm text-gray-400">Insert player statistics directly into the leaderboard ecosystem.</p>
            </div>
            <a href="admin.php" class="text-sm bg-gray-800 hover:bg-gray-700 text-gray-300 py-2 px-4 rounded-lg transition">Back to Panel</a>
        </div>

        <?php if (!empty($message)): ?>
            <div class="mb-6 p-4 rounded-lg text-sm font-semibold <?php echo $status === 'success' ? 'bg-emerald-950/50 border border-emerald-500 text-emerald-400' : 'bg-rose-950/50 border border-rose-500 text-rose-400'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="add_player.php" method="POST" class="space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Minecraft Username</label>
                    <input type="text" name="username" required placeholder="e.g. coldified" class="w-full bg-[#1f2937] border border-[#374151] rounded-lg p-2.5 text-white focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Display Subtitle</label>
                    <input type="text" name="title" value="Combat Master" class="w-full bg-[#1f2937] border border-[#374151] rounded-lg p-2.5 text-white focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Points</label>
                    <input type="number" name="points" value="0" class="w-full bg-[#1f2937] border border-[#374151] rounded-lg p-2.5 text-white focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Server Region Badge</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 bg-[#1f2937] border border-[#374151] py-2 px-4 rounded-lg cursor-pointer text-sm">
                        <input type="radio" name="region" value="AS" checked class="accent-blue-500"> <span class="text-sky-400 font-bold">AS</span> (Asia)
                    </label>
                    <label class="flex items-center gap-2 bg-[#1f2937] border border-[#374151] py-2 px-4 rounded-lg cursor-pointer text-sm">
                        <input type="radio" name="region" value="NA" class="accent-blue-500"> <span class="text-emerald-400 font-bold">NA</span> (North America)
                    </label>
                    <label class="flex items-center gap-2 bg-[#1f2937] border border-[#374151] py-2 px-4 rounded-lg cursor-pointer text-sm">
                        <input type="radio" name="region" value="EU" class="accent-blue-500"> <span class="text-amber-500 font-bold">EU</span> (Europe)
                    </label>
                </div>
            </div>

            <hr class="border-[#1f2937]">

            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-gray-300 mb-4">Assign Individual Gamemode Tiers</h3>
                
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <?php 
                    $modes = [
                        'tier_vanilla' => 'Vanilla', 'tier_uhc' => 'UHC', 'tier_pot' => 'Pot', 'tier_netpot' => 'Netherite Pot',
                        'tier_smp' => 'SMP', 'tier_sword' => 'Sword', 'tier_axe' => 'Axe', 'tier_mace' => 'Mace'
                    ];
                    $tiers_list = ['HT1', 'LT1', 'HT2', 'LT2', 'HT3', 'LT3', 'HT4', 'LT4', 'HT5', 'LT5', 'NONE'];
                    
                    foreach($modes as $key => $label): ?>
                        <div class="bg-[#192231] p-3 rounded-lg border border-[#243249]">
                            <label class="block text-xs font-semibold text-gray-300 mb-1.5"><?php echo $label; ?></label>
                            <select name="<?php echo $key; ?>" class="w-full bg-[#1f2937] border border-[#374151] text-xs rounded p-1.5 text-white focus:outline-none">
                                <?php foreach($tiers_list as $tier): ?>
                                    <option value="<?php echo $tier; ?>" <?php echo $tier == 'NONE' ? 'selected' : ''; ?>><?php echo $tier; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 px-6 rounded-lg shadow-lg tracking-wide transform transition active:scale-[0.99]">
                    Publish Player to Leaderboard
                </button>
            </div>

        </form>
    </div>

</body>
</html>
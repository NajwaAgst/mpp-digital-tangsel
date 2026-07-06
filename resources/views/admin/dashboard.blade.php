<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$title = "Dashboard Admin";

ob_start();

?>

<div class="space-y-8">

    <!-- ===================== -->
    <!-- WELCOME -->
    <!-- ===================== -->

    <div class="rounded-3xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white p-8 shadow-xl">

        <h1 class="text-4xl font-bold">

            Selamat Datang,
            <?= htmlspecialchars($_SESSION["user"]["name"] ?? "Administrator") ?>

        </h1>

        <p class="mt-3 text-emerald-100">

            Dashboard Administrator
            Mall Pelayanan Publik Digital (SPBE)

        </p>

    </div>

    <!-- ===================== -->
    <!-- SUMMARY -->
    <!-- ===================== -->

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white rounded-3xl shadow-lg p-7">

            <div class="text-slate-500">
                Total Pengajuan
            </div>

            <div class="mt-4 text-5xl font-bold text-slate-800">
                <?= $total ?>
            </div>

        </div>

        <div class="bg-yellow-500 rounded-3xl shadow-lg p-7 text-white">

            <div>
                Pending
            </div>

            <div class="mt-4 text-5xl font-bold">
                <?= $pending ?>
            </div>

        </div>

        <div class="bg-green-600 rounded-3xl shadow-lg p-7 text-white">

            <div>
                Approved
            </div>

            <div class="mt-4 text-5xl font-bold">
                <?= $approved ?>
            </div>

        </div>

        <div class="bg-red-600 rounded-3xl shadow-lg p-7 text-white">

            <div>
                Rejected
            </div>

            <div class="mt-4 text-5xl font-bold">
                <?= $rejected ?>
            </div>

        </div>

    </div>

    <!-- ===================== -->
<!-- EMERGENCY SUMMARY -->
<!-- ===================== -->

<div class="mt-10">

    <div class="flex items-center justify-between mb-6">

        <h2 class="text-2xl font-bold">

            🚨 Emergency 112

        </h2>

        <a
            href="/admin/emergencies"
            class="rounded-lg bg-red-600 px-5 py-3 text-white hover:bg-red-700">

            Kelola Laporan

        </a>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white rounded-3xl shadow-lg p-7">

            <div class="text-slate-500">

                Total Laporan

            </div>

            <div class="mt-4 text-5xl font-bold text-red-600">

                <?= $totalEmergency ?>

            </div>

        </div>

        <div class="bg-yellow-500 rounded-3xl shadow-lg p-7 text-white">

            <div>

                Menunggu

            </div>

            <div class="mt-4 text-5xl font-bold">

                <?= $waitingEmergency ?>

            </div>

        </div>

        <div class="bg-blue-600 rounded-3xl shadow-lg p-7 text-white">

            <div>

                Diproses

            </div>

            <div class="mt-4 text-5xl font-bold">

                <?= $processEmergency ?>

            </div>

        </div>

        <div class="bg-green-600 rounded-3xl shadow-lg p-7 text-white">

            <div>

                Selesai

            </div>

            <div class="mt-4 text-5xl font-bold">

                <?= $doneEmergency ?>

            </div>

        </div>

    </div>

</div>

    <!-- ===================== -->
    <!-- CHART -->
    <!-- ===================== -->

    <div class="grid lg:grid-cols-3 gap-8">

        <!-- BAR CHART -->

        <div class="lg:col-span-2 bg-white rounded-3xl shadow-lg p-8">

            <h2 class="text-xl font-bold mb-6">

                Statistik Pengajuan per Layanan

            </h2>

            <canvas id="serviceChart"></canvas>

        </div>

        <div class="bg-white rounded-3xl shadow-lg p-8 mt-8">

    <h2 class="text-2xl font-bold mb-6">

        Status Emergency

    </h2>

    <canvas id="statusEmergencyChart"></canvas>

</div>

        <!-- PIE CHART -->

        <div class="bg-white rounded-3xl shadow-lg p-8">

            <h2 class="text-xl font-bold mb-6">

                Status Pengajuan

            </h2>

            <canvas id="statusChart"></canvas>

        </div>

        <div class="bg-white rounded-3xl shadow-lg p-8 mt-8">

    <h2 class="text-2xl font-bold mb-6">

        Statistik Emergency Berdasarkan Kategori

    </h2>

    <canvas id="emergencyCategoryChart"></canvas>

</div>

    </div>

    <!-- ===================== -->
    <!-- RECENT -->
    <!-- ===================== -->

    <div class="bg-white rounded-3xl shadow-lg">

        <div class="flex items-center justify-between border-b p-6">

            <h2 class="text-2xl font-bold">

                Pengajuan Terbaru

            </h2>

            <a
                href="/admin/applications"
                class="text-emerald-600 font-semibold hover:underline">

                Lihat Semua →

            </a>

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-slate-100">

                    <tr>

                        <th class="text-left p-4">ID</th>
                        <th class="text-left p-4">Layanan</th>
                        <th class="text-left p-4">Nama</th>
                        <th class="text-left p-4">Status</th>
                        <th class="text-left p-4">Tanggal</th>

                    </tr>

                </thead>

                <tbody>

                <?php if(empty($recentApplications)): ?>

                    <tr>

                        <td colspan="5" class="text-center text-slate-500 py-8">

                            Belum ada data.

                        </td>

                    </tr>

                <?php else: ?>

                    <?php foreach($recentApplications as $row): ?>

                    <tr class="border-b hover:bg-slate-50">

                        <td class="p-4">

                            #<?= $row["id"] ?>

                        </td>

                        <td class="p-4">

                            <?= htmlspecialchars($row["service_name"]) ?>

                        </td>

                        <td class="p-4">

                            <?= htmlspecialchars($row["name"] ?? $row["nama"] ?? "-") ?>

                        </td>

                        <td class="p-4">

                            <?php

                            switch($row["status"]){

                                case "Approved":

                                    echo "<span class='px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold'>Approved</span>";

                                break;

                                case "Rejected":

                                    echo "<span class='px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold'>Rejected</span>";

                                break;

                                default:

                                    echo "<span class='px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold'>Pending</span>";

                            }

                            ?>

                        </td>

                        <td class="p-4">

                            <?= date("d M Y", strtotime($row["created_at"])) ?>

                        </td>

                    </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

    <!-- ===================== -->
    <!-- SPBE -->
    <!-- ===================== -->

    <div class="bg-white rounded-3xl shadow-lg p-8">

        <h2 class="text-2xl font-bold mb-8">

            Monitoring Interoperabilitas SPBE

        </h2>

        <div class="grid md:grid-cols-3 gap-6">

            <div class="rounded-2xl bg-blue-50 p-6">

                <div class="text-blue-700 font-semibold">

                    Dukcapil

                </div>

                <div class="text-4xl font-bold mt-3">

                    400 ms

                </div>

            </div>

            <div class="rounded-2xl bg-purple-50 p-6">

                <div class="text-purple-700 font-semibold">

                    NPWP

                </div>

                <div class="text-4xl font-bold mt-3">

                    700 ms

                </div>

            </div>

            <div class="rounded-2xl bg-green-50 p-6">

                <div class="text-green-700 font-semibold">

                    OSS / NIB

                </div>

                <div class="text-4xl font-bold mt-3">

                    900 ms

                </div>

            </div>

        </div>

    </div>

</div>

<!-- ===================== -->
<!-- CHART JS -->
<!-- ===================== -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

// =======================
// BAR CHART
// =======================

new Chart(document.getElementById("serviceChart"),{

    type:"bar",

    data:{

        labels:[

            <?php if(!empty($chart)): ?>

                <?php foreach($chart as $c): ?>

                    "<?= addslashes($c["service_name"]) ?>",

                <?php endforeach; ?>

            <?php endif; ?>

        ],

        datasets:[{

            label:"Jumlah Pengajuan",

            data:[

                <?php if(!empty($chart)): ?>

                    <?php foreach($chart as $c): ?>

                        <?= $c["total"] ?>,

                    <?php endforeach; ?>

                <?php endif; ?>

            ],

            backgroundColor:"#0F766E"

        }]

    },

    options:{

        responsive:true,

        plugins:{

            legend:{
                display:false
            }

        }

    }

});

// =======================
// PIE CHART
// =======================

new Chart(document.getElementById("statusChart"),{

    type:"pie",

    data:{

        labels:[
            "Pending",
            "Approved",
            "Rejected"
        ],

        datasets:[{

            data:[
                <?= $pending ?>,
                <?= $approved ?>,
                <?= $rejected ?>
            ],

            backgroundColor:[
                "#FACC15",
                "#10B981",
                "#EF4444"
            ]

        }]

    }

    

});

new Chart(document.getElementById("statusEmergencyChart"),{

    type:"pie",

    data:{

        labels:[

            <?php foreach($emergencyStatusChart as $row): ?>

                "<?= $row["status"] ?>",

            <?php endforeach; ?>

        ],

        datasets:[{

            data:[

                <?php foreach($emergencyStatusChart as $row): ?>

                    <?= $row["total"] ?>,

                <?php endforeach; ?>

            ],

            backgroundColor:[
                "#FACC15",
                "#3B82F6",
                "#10B981"
            ]

        }]

    }

});

new Chart(document.getElementById("emergencyCategoryChart"),{

    type:"doughnut",

    data:{

        labels:[

            <?php foreach($emergencyChart as $row): ?>

            "<?= addslashes($row["category"]) ?>",

            <?php endforeach; ?>

        ],

        datasets:[{

            data:[

                <?php foreach($emergencyChart as $row): ?>

                <?= $row["total"] ?>,

                <?php endforeach; ?>

            ],

            backgroundColor:[

                "#ef4444",
                "#3b82f6",
                "#10b981",
                "#f59e0b",
                "#8b5cf6",
                "#ec4899"

            ]

        }]

    }

});


</script>

<?php

$content = ob_get_clean();

include __DIR__ . '/layout.blade.php';

?>
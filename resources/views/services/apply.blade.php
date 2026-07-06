<?php

$title = 'Ajukan ' . $service['name'];

$authUser = $_SESSION['user'] ?? null;

$form = $service['form'] ?? [];

ob_start();

?>

<div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">

    <a
        href="/services/<?= htmlspecialchars($service['slug']) ?>"
        class="mb-6 inline-flex items-center gap-2 text-sm font-semibold text-emerald-600">

        ← Kembali ke Detail Layanan

    </a>

    <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">

        <!-- ======================================= -->
        <!-- INFORMASI LAYANAN -->
        <!-- ======================================= -->

        <div class="rounded-[2rem] border border-white bg-white p-8 shadow-xl">

            <div class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-sm font-semibold text-emerald-700">

                <?= htmlspecialchars($service['category']) ?>

            </div>

            <h1 class="mt-5 text-3xl font-bold text-slate-900">

                <?= htmlspecialchars($service['name']) ?>

            </h1>

            <p class="mt-4 text-slate-600">

                Lengkapi formulir berikut.

                Seluruh data identitas akan diambil otomatis melalui
                layanan interoperabilitas SPBE
                (Dukcapil, DJP/NPWP dan OSS/NIB)
                berdasarkan NIK yang dimasukkan.

            </p>

            <div class="mt-8">

                <h3 class="font-semibold text-slate-900">

                    Persyaratan

                </h3>

                <ul class="mt-4 space-y-2 text-sm text-slate-600">

                    <?php foreach($service['documents'] as $doc): ?>

                        <li>

                            • <?= htmlspecialchars($doc) ?>

                        </li>

                    <?php endforeach; ?>

                </ul>

            </div>

        </div>

        <!-- ======================================= -->
        <!-- FORM -->
        <!-- ======================================= -->

        <div class="rounded-[2rem] bg-slate-900 p-8 text-white shadow-xl">

            <?php if(!empty($errorMessage)): ?>

                <div class="mb-5 rounded-xl border border-red-500 bg-red-500/20 p-4">

                    <?= htmlspecialchars($errorMessage) ?>

                </div>

            <?php endif; ?>


            <?php if(!empty($submitted)): ?>

                <div class="mb-5 rounded-xl border border-emerald-500 bg-emerald-500/20 p-4">

                    Pengajuan berhasil.

                    <br><br>

                    Nomor Pengajuan :

                    <strong>

                        #<?= htmlspecialchars($submissionId) ?>

                    </strong>

                </div>

            <?php endif; ?>


            <form
                method="POST"
                action="/services/<?= htmlspecialchars($service['slug']) ?>/apply"
                class="space-y-6">

                <!-- ============================== -->
                <!-- NIK -->
                <!-- ============================== -->

                <div>

                    <label class="mb-2 block text-sm font-semibold">

                        NIK

                    </label>

                    <input
                        id="nik"
                        name="nik"
                        maxlength="16"
                        autocomplete="off"
                        required
                        value="<?= htmlspecialchars($submittedData['nik'] ?? '') ?>"
                        class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">

                    <small
                        id="nik-mask"
                        class="mt-2 block text-xs text-emerald-300">

                    </small>

                </div>

                <!-- Loading -->

                <div
                    id="loading"
                    class="hidden rounded-xl bg-blue-600/20 border border-blue-500 p-4 text-sm">

                    Mengambil data dari layanan interoperabilitas...

                </div>

                <!-- ============================== -->
                <!-- FORM DINAMIS -->
                <!-- ============================== -->

                <?php

                $formFile = __DIR__.'/forms/'.($form['code'] ?? '').'.blade.php';

                if(file_exists($formFile))
                {
                    include $formFile;
                }

                ?>

                <!-- ============================== -->
                <!-- Keterangan -->
                <!-- ============================== -->

                <div>

                    <label class="mb-2 block text-sm font-semibold">

                        Keterangan Tambahan

                    </label>

                    <textarea
                        name="keterangan"
                        rows="4"
                        class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white"><?= htmlspecialchars($submittedData['keterangan'] ?? '') ?></textarea>

                </div>

                <button
                    type="submit"
                    class="w-full rounded-xl bg-emerald-500 py-3 font-semibold transition hover:bg-emerald-600">

                    Kirim Pengajuan

                </button>

            </form>

        </div>

    </div>

</div>

<script>

document.addEventListener("DOMContentLoaded", function () {

    const nikInput = document.getElementById("nik");
    const loading = document.getElementById("loading");
    const nikMask = document.getElementById("nik-mask");

    if (!nikInput) return;

    let timer = null;

    //------------------------------------------------------
    // MASKING NIK
    //------------------------------------------------------

    function maskNik(nik){

        if(!nik || nik.length < 16){

            nikMask.innerHTML="";

            return;

        }

        const masked =
            nik.substring(0,4) +
            "********" +
            nik.substring(12);

        nikMask.innerHTML =
            "NIK terverifikasi : <b>"+masked+"</b>";

    }

    //------------------------------------------------------
    // CLEAR FIELD
    //------------------------------------------------------

    function clearField(id){

        const el=document.getElementById(id);

        if(el){

            el.value="";

        }

    }

    function clearAll(){

        [

            "nama",

            "tempat_lahir",

            "tanggal_lahir",

            "alamat",

            "npwp",

            "status_npwp",

            "nib",

            "nama_usaha",

            "jenis_usaha"

        ].forEach(clearField);

    }

    //------------------------------------------------------
    // SET VALUE
    //------------------------------------------------------

    function setValue(id,value){

        const el=document.getElementById(id);

        if(!el) return;

        el.value=value ?? "";

    }

    //------------------------------------------------------
    // EVENT NIK
    //------------------------------------------------------

    nikInput.addEventListener("keyup",function(){

        clearTimeout(timer);

        maskNik(nikInput.value);

        if(nikInput.value.length!=16){

            clearAll();

            return;

        }

        timer=setTimeout(loadData,500);

    });

    //------------------------------------------------------
    // LOAD INTEROPERABILITY
    //------------------------------------------------------

    async function loadData(){

        loading.classList.remove("hidden");

        try{

            const url="/mock/interoperability/"+nikInput.value;

            console.log("====================================");
            console.log("CALL API");
            console.log(url);

            const response=await fetch(url);

            console.log("STATUS :",response.status);

            const text=await response.text();

            console.log(text);

            const json=JSON.parse(text);

            console.log(json);

            loading.classList.add("hidden");

            if(!json.success){

                alert(json.message);

                clearAll();

                return;

            }

            //--------------------------------------------------
            // DUKCAPIL
            //--------------------------------------------------

            if(json.data.dukcapil){

                setValue("nik",
                    json.data.dukcapil.nik);

                setValue("nama",
                    json.data.dukcapil.nama);

                setValue("tempat_lahir",
                    json.data.dukcapil.tempat_lahir);

                setValue("tanggal_lahir",
                    json.data.dukcapil.tanggal_lahir);

                setValue("alamat",
                    json.data.dukcapil.alamat);

            }

            //--------------------------------------------------
            // NPWP
            //--------------------------------------------------

            if(json.data.npwp){

                setValue("npwp",
                    json.data.npwp.npwp);

                setValue("status_npwp",
                    json.data.npwp.status_npwp);

            }

            //--------------------------------------------------
            // NIB
            //--------------------------------------------------

            if(json.data.nib){

                setValue("nib",
                    json.data.nib.nib);

                setValue("nama_usaha",
                    json.data.nib.nama_usaha);

                setValue("jenis_usaha",
                    json.data.nib.jenis_usaha);

            }

            console.log("AUTOFILL BERHASIL");

        }

        catch(error){

            loading.classList.add("hidden");

            console.error(error);

            alert("Gagal mengambil data dari layanan interoperabilitas.");

        }

    }

});

</script>

<?php

$content = ob_get_clean();

include __DIR__.'/../layout.blade.php';

?>
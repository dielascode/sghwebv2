<?php


require_once __DIR__ . '/../../config/connection.php';
require_once __DIR__ . '/../../logic/costumer/pesananApi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan</title>
</head>
<body>

<div class="pengaduan-main">

    <!-- Header -->
    <div class="page-header-pengaduan">
        <h1>Form Pengaduan</h1>
        <p>
            Silakan sampaikan keluhan atau kendala yang Anda alami.
        </p>
    </div>

    <div class="divider-pengaduan"></div>

    <!-- Card -->
    <div class="form-card-pengaduan">

        <form action="/sghwebv2/ec/logic/costumer/pengaduanApi.php" method="POST">

            <!-- Subjek -->
            <div class="field-group-pengaduan">

                <label>
                    Subjek
                    <span class="required-pengaduan">*</span>
                </label>

                <div class="input-wrap-pengaduan">

                    <input
                        type="text"
                        name="subjek"
                        placeholder="Masukkan subjek pengaduan"
                        required
                    >

                </div>

            </div>

            <!-- Pesan -->
            <div class="field-group-pengaduan">

                <label>
                    Pesan
                    <span class="required-pengaduan">*</span>
                </label>

                <textarea
                    name="pesan"
                    placeholder="Tuliskan pengaduan Anda..."
                    required
                ></textarea>

            </div>

            <!-- Button -->
            <button
                type="submit"
                name="submit_pengaduan"
                class="btn-submit-pengaduan"
            >
                Kirim Pengaduan
            </button>

        </form>

    </div>

</div>

</body>
</html>
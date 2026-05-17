<?php
$user = $_SESSION['user'];
?>
<link rel="stylesheet" href="../../assets/css/style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container-fluid p-4 p-lg-5">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 mb-lg-5">
        <div>
            <h1 class="h3 mb-0">Manajemen Buah</h1>
            <p class="text-muted mb-0">Kelola jenis buah anda disini</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary" onclick="openEditProfile()">
                <i class="bi bi-pencil me-2"></i>Edit Profile
            </button>
        </div>
    </div>

    <!-- Product Management Container -->
    <div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-3">Profile</h4>

                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nama:</strong> <?= $user['nama'] ?></p>
                        <p><strong>Email:</strong> <?= $user['email'] ?></p>
                        <p><strong>Username:</strong> <?= $user['username'] ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>No HP:</strong> <?= $user['nomor_telepon'] ?></p>
                        <p><strong>Status:</strong>
                            <span class="badge bg-success"><?= $user['status'] ?></span>
                        </p>
                    </div>
                </div>

            </div>
        </div>

    </div> <!-- End Product Management Container -->

</div>

<div class="modal fade" id="editProfileModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Edit Profile</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="formEditProfile">

                    <input type="hidden" name="id" value="<?= $user['id']; ?>">

                    <div class="mb-2">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" value="<?= $user['nama']; ?>" required>
                    </div>

                    <div class="mb-2">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?= $user['email']; ?>" required>
                    </div>

                    <div class="mb-2">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" value="<?= $user['username']; ?>" required>
                    </div>

                    <div class="mb-2">
                        <label>No HP</label>
                        <input type="text" name="nomor_telepon" class="form-control" value="<?= $user['nomor_telepon']; ?>" required>
                    </div>

                    <div class="mb-2">
                        <label>Password (opsional)</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <button class="btn btn-primary w-100 mt-2">Simpan</button>

                </form>
            </div>

        </div>
    </div>
</div>

<script>
    function openEditProfile() {
        new bootstrap.Modal(document.getElementById('editProfileModal')).show();
    }

    document.getElementById('formEditProfile').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('/sghwebv2/ec/admin/crud/profileController.php?action=update', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text()) // ⬅️ ganti
            .then(text => {
                console.log("RESPON ASLI:", text); // 🔥 LIHAT INI DI CONSOLE

                try {
                    const data = JSON.parse(text); // ⬅️ parse manual

                    if (data.status) {
                        alert("Berhasil update!");
                        location.reload();
                    } else {
                        alert("Gagal: " + data.message);
                    }

                } catch (err) {
                    console.error("JSON ERROR:", err);
                    alert("Response bukan JSON, cek console!");
                }
            })
            .catch(err => console.error(err));
    });
</script>
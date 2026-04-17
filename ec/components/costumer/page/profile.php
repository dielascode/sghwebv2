<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Profil Saya</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f5f5;
        }

        .sidebar {
            height: 100vh;
            background: #fff;
            border-right: 1px solid #ddd;
        }

        .profile-card img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #ddd;
        }
        h5{
            color: #4d4949;
        }

        .btn-green {
            background-color: #2e7d5b;
            color: #fff;
            border-radius: 50px;
        }

        .btn-green:hover {
            background-color: #256b4d;
            color: #fff;
        }
        .btn-secondary{
            border-radius: 15px;
        }

        .modal-content {
            border-radius: 15px;
            
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->

            <!-- Content -->
            <div class="col-md-9 col-lg-10 p-4">

                <h3><b>Profil saya</b></h3>
                <p class="text-muted">
                    Kelola informasi profil Anda untuk mengontrol, melindungi dan mengamankan akun
                </p>

                <div class="row">

                    <!-- Kiri -->
                    <div class="col-md-4">
                        <div class="card text-center p-4 shadow-sm profile-card">
                            <img src="https://via.placeholder.com/150" class="mx-auto">
                            <h5 class="mt-3">Aril Punk123</h5>

                            <button class="btn btn-green mt-3">Ganti Foto</button>
                        </div>
                    </div>

                    <!-- Kanan -->
                    <div class="col-md-8">
                        <div class="card p-4 shadow-sm">
                            <h4><b>Informasi Akun</b></h4>

                                <div class="mb-3">
                                    <label>Username</label>
                                    <h5 id="UsernameProfile">Aril Punk123
                                        <h5>
                                </div>

                                <div class="mb-3">
                                    <label>Nama</label>
                                    <h5 id="namaProdile">Aril Bagus
                                        <h5>
                                </div>

                                <div class="mb-3">
                                    <label>Email</label>
                                    <h5 id="emailProfile">@Arilbagus<h5>
                                </div>

                                <div class="mb-3">
                                    <label>Nomor Telepon</label>
                                    <h5 id="nomorProfile">08123123
                                        <h5>
                                </div>

                                <div class="mb-3">
                                    <label>Jenis Kelamin</label><br>
                                    <h5 id="jkProfil">Laki-Laki</h5>

                                </div>
                                <button class="btn btn-green mt-3" data-bs-toggle="modal" data-bs-target="#modalProfil">EditProfil</button>
                        </div>
                    </div>

                    <!-- Pop Up Ubah -->
                    <!-- button class="btn btn-green mt-3" data-bs-toggle="modal"
                        data-bs-target="#modalProfil">EditProfil</-button -->

                    <!-- Modal Profil -->
                    <div class="modal fade" id="modalProfil" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Informasi Akun</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <form>

                                        <div class="mb-3">
                                            <label>Username</label>
                                            <input type="text" id="inputUsername" class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <label>Nama</label>
                                            <input type="text" id="inputNama" class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <label>Email</label>
                                            <input type="email" id="inputEmail" class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <label>Nomor Telepon</label>
                                            <input type="text" id="inputTelp" class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <label>Jenis Kelamin</label><br>
                                            <input type="radio" name="jk" value="L" id="laki"> Laki-Laki
                                            <input type="radio" name="jk" value="P" id="perempuan"> Perempuan
                                        </div>

                                    </form>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button class="btn btn-green">Simpan Perubahan</button>
                                </div>

                                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

</body>

</html>
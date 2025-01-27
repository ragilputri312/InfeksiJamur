<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrasi Pengguna</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <style>
    body {
      background-image: url('landing/img/bg_infeksi.PNG');
      background-size: cover;
      background-position: center;
      font-family: 'Lato', sans-serif;
    }
    .registration-card {
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 20px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      padding: 30px;
      max-width: 450px;
      margin: 100px auto;
      animation: fadeInDown 1s;
    }
    .registration-card h1 {
      font-size: 2rem;
      margin-bottom: 20px;
      text-align: center;
    }
    .form-control {
      border-radius: 20px;
      background-color: rgba(0, 0, 0, 0.1);
      border: none;
    }
    .form-control:focus {
      box-shadow: none;
      border-color: #ddd;
    }
    .form-check-label {
      margin-left: 10px;
    }
    .btn {
      border-radius: 20px;
      background-color: #3498db;
      color: white;
      font-size: 18px;
      padding: 12px 30px;
      border: none;
    }
    .btn:hover {
      background-color: #2980b9;
    }

    .login-link {
      text-align: center;
      margin-top: 20px;
    }
    .login-link a {
      color: #3498db;
      font-weight: bold;
      text-decoration: none;
    }
    .login-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
    <div class="registration-card animate__animated animate__fadeInDown">
        <h1>Registrasi</h1>

        <!-- Menampilkan pesan sukses -->
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Menampilkan pesan error -->
        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('user.store') }}">
            @csrf
            <div class="form-group">
                <label for="username">Nama Pengguna:</label>
                <input id="username" type="text" class="form-control" name="nama" value="{{ old('nama') }}" required placeholder="Masukkan nama pengguna">
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi:</label>
                <input id="password" type="password" class="form-control" name="sandi" required placeholder="Masukkan kata sandi">
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Kata Sandi:</label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required placeholder="Konfirmasi kata sandi">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Masukkan email">
            </div>

            <div class="form-group">
                <label for="address">Alamat:</label>
                <input id="address" type="text" class="form-control" name="alamat" value="{{ old('alamat') }}" required placeholder="Masukkan alamat">
            </div>

            <div class="form-group">
                <label>Jenis Kelamin:</label>
                <div>
                    <input type="radio" id="male" name="jk" value="Laki-laki" {{ old('jk') == 'Laki-laki' ? 'checked' : '' }} required>
                    <label for="male" class="form-check-label">Laki-laki</label>
                </div>
                <div>
                    <input type="radio" id="female" name="jk" value="Perempuan" {{ old('jk') == 'Perempuan' ? 'checked' : '' }} required>
                    <label for="female" class="form-check-label">Perempuan</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Daftar</button>

            <div class="login-link">
                Sudah Punya Akun? <a href="/login">Login</a>
            </div>

            <div class="login-link">
                <a href="{{ route('landing') }}">Back to landing page</a>
            </div>

        </form>
    </div>


  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-7+XkFbhH0JwL1Qv4eR+POU22EEZDFbO5K1pXXxINmQaBQ9vcz/J2+/AklHpQ3H3r" crossorigin="anonymous"></script>
</body>
</html>

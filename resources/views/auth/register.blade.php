<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register | cashier</title>
  <link rel="shortcut icon" type="image/png" href="../assets/de.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <style>
    .card {
      border-radius: 10px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      padding: 20px 30px;
      background-color: #fff;
      width: 100%;
      max-width: 400px;
      margin-top: 50px;
    }

    .card-body {
      padding: 10px 20px;
    }

    .form-label {
      font-size: 14px;
      font-weight: bold;
      color: #333;
    }

    .form-control {
      border-radius: 10px;
      padding: 10px;
      border: 1px solid #ddd;
    }

    .btn-primary {
      background-color: #0072ff;
      border-color: #0072ff;
      padding: 10px;
      border-radius: 10px;
      font-weight: bold;
    }

    .btn-primary:hover {
      background-color: #005bb5;
      border-color: #005bb5;
    }

    .invalid-feedback {
      font-size: 12px;
      color: #e74c3c;
    }

    p {
      color: #333;
      font-size: 14px;
      margin-bottom: 15px;
    }
  </style>
</head>

<body>
  <div class="page-wrapper" id="main-wrapper">
    <div class="d-flex align-items-center justify-content-center w-100">
      <div class="row justify-content-center w-100">
        <div class="col-md-8 col-lg-6 col-xxl-3">
          <div class="card mb-0">
            <div class="card-body">
              <a href="" class="text-nowrap logo-img text-center d-block py-3">
                <img src="{{ asset('assets/de.png') }}" width="180" alt="Logo">
              </a>
              <p class="text-center">Create a new account</p>

              <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                  <label for="name" class="form-label">Name</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Enter your name" required>
                  @error('name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                  @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter your password" required>
                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="mb-4">
                  <label for="password-confirm" class="form-label">Confirm Password</label>
                  <input type="password" class="form-control" id="password-confirm" name="password_confirmation" placeholder="Confirm your password" required>
                </div>
                <button class="btn btn-primary w-100" type="submit">REGISTER</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<p>&nbsp;</p>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

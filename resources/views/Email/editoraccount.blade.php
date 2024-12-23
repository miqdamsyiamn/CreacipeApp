<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Akun Editor</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 600px;
      margin: 20px auto;
      padding: 20px;
      background: #ffffff;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    h1 {
      color: #4CAF50;
      text-align: center;
    }

    p {
      font-size: 16px;
      line-height: 1.6;
      color: #333333;
    }

    ul {
      list-style-type: none;
      padding: 0;
    }

    ul li {
      padding: 8px 0;
      border-bottom: 1px solid #eeeeee;
    }

    ul li:last-child {
      border-bottom: none;
    }

    .footer {
      margin-top: 20px;
      text-align: center;
      font-size: 14px;
      color: #777777;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Selamat Bergabung di Creacipe!</h1>
    <p>Halo, <strong>{{ $user->name }}</strong></p>
    <p>Admin telah membuat akun editor untuk Anda di platform Creacipe. Berikut detail akun Anda:</p>

    <ul>
      <li><strong>Nama:</strong> {{ $user->name }}</li>
      <li><strong>Email:</strong> {{ $user->email }}</li>
      <li><strong>Password:</strong> {{ $password }}</li>
    </ul>

    <p>Harap segera login dan ubah password Anda demi keamanan akun.</p>
    <p class="footer">Salam hormat,<br>Tim Creacipe</p>
  </div>
</body>

</html>
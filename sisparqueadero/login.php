<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login</title>

  <?php include('./header.php'); ?>
  <?php include('./db_connect.php'); ?>
  <?php 
  session_start();
  if(isset($_SESSION['login_id']))
    header("location:index.php?page=home");
  ?>

</head>
<style>
  body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-image: url('car.jpeg');
    background-size: cover;
    background-position: center;
    font-family: Arial, sans-serif;
  }

  .card {
    width: 400px;
    background: #05252b; /* Color VERDE */
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
  }

  .logo {
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 4rem;
    background: linear-gradient(135deg, #1a7f11, #b1df9b);
    color: #ffff;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    margin: 0 auto 20px;
  }

  .form-group label {
    color: #4c9f3f;
    font-weight: bold;
    margin-bottom: 5px;
  }

  .form-control {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }

  .btn-primary {
    background: linear-gradient(135deg, #c850c0, #4158d0);
    border: none;
    margin-top: 20px;
  }

  .btn-primary:hover {
    background: linear-gradient(135deg, #a843b0, #3143c0);
  }
</style>

<body>

  <div class="card">
    <div class="logo"><span class="fa fa-car"></span></div>

    <form id="login-form">
      <div class="form-group">
        <label for="username">Nombre de usuario</label>
        <input type="text" id="username" name="username" class="form-control">
      </div>
      <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" class="form-control">
      </div>
      <button class="btn btn-primary btn-block">Ingresar</button>
    </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $('#login-form').submit(function(e) {
      e.preventDefault();
      $('button[type="submit"]').attr('disabled', true).html('Ingresando...');
      if ($(this).find('.alert-danger').length > 0)
        $(this).find('.alert-danger').remove();
      $.ajax({
        url: 'ajax.php?action=login',
        method: 'POST',
        data: $(this).serialize(),
        error: err => {
          console.log(err);
          $('button[type="submit"]').removeAttr('disabled').html('Ingresar');
        },
        success: function(resp) {
          if (resp == 1) {
            location.href = 'index.php?page=home';
          } else if (resp == 2) {
            location.href = 'voting.php';
          } else {
            $('#login-form').prepend('<div class="alert alert-danger">Nombre de usuario o contraseña incorrectos.</div>');
            $('button[type="submit"]').removeAttr('disabled').html('Ingresar');
          }
        }
      });
    });
  </script>
</body>

</html>

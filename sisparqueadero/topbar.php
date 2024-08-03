<style>
  .logo {
    margin: auto;
    font-size: 20px;
    background: white;
    padding: 7px 11px;
    border-radius: 50%;
    color: #05252b;
  }
  .navbar-brand {
    color: #7fbf6d !important; /* Asegura que el color del texto "PARKINGBOXi" sea verde */
  }
</style>

<nav class="navbar navbar-light fixed-top" style="padding:0;min-height: 3.5rem;background-color: #05252b;">
  <div class="container-fluid mt-2 mb-2">
    <div class="col-lg-12">
      <div class="col-md-1 float-left" style="display: flex;">
        <!-- Puedes añadir un logo aquí si lo deseas -->
      </div>
      <div class="col-md-4 float-left text-white">
        <large><b class="navbar-brand">PARKINGBOXi</b></large>
      </div>
      <div class="col-md-2 float-right text-white">
        <a href="ajax.php?action=logout" class="text-white"><?php echo $_SESSION['login_name'] ?> <i class="fa fa-power-off"></i></a>
      </div>
    </div>
  </div>
</nav>

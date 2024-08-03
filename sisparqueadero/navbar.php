
<style>
	.collapse a{
		text-indent:10px;
	}
</style>
<nav id="sidebar" class='mx-lt-5' style="background-color:#05252b" >
		
		<div class="sidebar-list bg-info">
				<?php if($_SESSION['login_type'] == 1): ?>

				<a href="index.php?page=home" class="nav-item nav-home text-white"><span class='icon-field'><i class="fa fa-home"></i></span> Inicio</a>
				
			
				
				<a href="index.php?page=manage_park" class="nav-item nav-manage_park text-white"><span class='icon-field'><i class="fa fa-car"></i></span> Entrada vehículos</a>

				<a href="index.php?page=park_list" class="nav-item nav-park_list text-white"><span class='icon-field'><i class="fas fa-sign-out-alt"></i>
                </span> Salida vehículos</a>

				<a href="index.php?page=category" class="nav-item nav-category text-white"><span class='icon-field'><i class="fa fa-list"></i></span> Categoria</a>	
				<a href="index.php?page=location" class="nav-item nav-location text-white"><span class='icon-field'><i class="fa fa-map"></i></span>  Área parqueo</a>
				<a href="index.php?page=users" class="nav-item nav-users text-white"><span class='icon-field'><i class="fa fa-users"></i></span> Usuarios</a>
				
			<?php else: ?>
	          <a href="index.php?page=home" class="nav-item nav-home text-white"><span class='icon-field'><i class="fa fa-home"></i></span> Inicio</a>
				
				<a href="index.php?page=manage_park" class="nav-item nav-manage_park text-white"><span class='icon-field'><i class="fa fa-car"></i></span> Entrada vehículos</a>

				<a href="index.php?page=park_list" class="nav-item nav-park_list text-white"><span class='icon-field'><i class="fas fa-sign-out-alt"></i>
                </span> Salida vehículos</a>

				<a href="index.php?page=category" class="nav-item nav-category text-white"><span class='icon-field'><i class="fa fa-list"></i></span> Categoria</a>	
				<a href="index.php?page=location" class="nav-item nav-location text-white"><span class='icon-field'><i class="fa fa-map"></i></span>  Área parqueo</a>
			<?php endif; ?>
		</div>

</nav>
<script>
	$('.nav_collapse').click(function(){
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>

<?php 

?>

<div class="container-fluid ">
	
	<div class="row">
	<div class="col-lg-12">
			<button class="btn btn-info float-right btn-sm" id="new_user"><i class="fa fa-plus"></i> Agregar</button>
	</div>
	</div>
	<br>


	<div class="row">


		<div class="card col-lg-12">

		<div class="card-header" style="background-color: #4c9f3f; color: white;">
				USUARIOS
			</div>

			<div class="card-body">

				<table class="table-striped table-bordered col-md-12">
				<thead style="background-color: #529cab; color: white;">

				<tr>
					<th class="text-center">#</th>
					<th class="text-center">Nombres</th>
					<th class="text-center">Users</th>
					<th class="text-center">Acción</th>
				</tr>
			</thead>
			<tbody>
				<?php
 					include 'db_connect.php';
 					$users = $conn->query("SELECT * FROM users u order by name asc");
 					$i = 1;
 					while($row= $users->fetch_assoc()):
				 ?>
				 <tr>
				 	<td class="text-center">
				 		<?php echo $i++ ?>
				 	</td>
				 	<td>
				 		<?php echo ucwords($row['name']) ?>
				 	</td>
				 	
				 	<td>
				 		<?php echo $row['username'] ?>
				 	</td>
				 	<td>
				 		<center>
								<div class="btn-group">
								  <button type="button" class="btn btn-primary">Acción</button>
								  <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    <span class="sr-only">Toggle Dropdown</span>
								  </button>
								  <div class="dropdown-menu">
								    <a class="dropdown-item edit_user" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Editar</a>
								    <div class="dropdown-divider"></div>
								    <a class="dropdown-item delete_user" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Eliminar</a>
								  </div>
								</div>
								</center>
				 	</td>
				 </tr>
				<?php endwhile; ?>
			</tbody>
		</table>
			</div>
		</div>
	</div>

</div>
<script>
	$('table').dataTable();
$('#new_user').click(function(){
	uni_modal('Nuevo usuario','manage_user.php')
})
$('.edit_user').click(function(){
	uni_modal('Editar Usuario','manage_user.php?id='+$(this).attr('data-id'))
})
$('.delete_user').click(function(){
		_conf("¿Estás seguro de eliminar a este usuario?","delete_user",[$(this).attr('data-id')])
	})
	function delete_user($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_user',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Datos eliminados con éxito",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>
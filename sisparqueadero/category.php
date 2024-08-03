<?php include('db_connect.php');?>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
				<button class="btn btn-info btn-block btn-sm col-sm-2 float-right" type="button" id="new_category">
					<i class="fa fa-plus"></i> Agregar
				</button>
			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
			<div class="card-header" style="background-color: #4c9f3f; color: white;">
				CATEGORIA
			</div>
			
				<div class="card">
					<div class="card-body">
						<table class="table table-condensed table-hover">
						    <thead style="background-color: #529cab; color: white;">
								<tr>
									<th class="text-center">#</th>
									<th class="">Categoria</th>
									<th class="">Tarifa por hora</th>
									<th class="text-center">Acción</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$types = $conn->query("SELECT * FROM category order by id asc");
								while($row=$types->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									
									<td class="">
										 <p> <b><?php echo $row['name'] ?></b></p>
									</td>
									<td class="">
										 <p> <b><?php echo number_format($row['rate'],2) ?></b></p>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_category" type="button" data-id="<?php echo $row['id'] ?>" >Editar</button>
										<button class="btn btn-sm btn-danger delete_category" type="button" data-id="<?php echo $row['id'] ?>">Eliminar</button>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height:150px;
	}
</style>
<script>
	$('table').dataTable();

	$('#new_category').click(function(){
		uni_modal("Categoría de vehículo","manage_category.php")
	})
	
	$('.edit_category').click(function(){
		uni_modal("Editar categoria de vehículo","manage_category.php?id="+$(this).attr('data-id'))
		
	})
	$('.delete_category').click(function(){
		_conf("¿Estás seguro de eliminar esta categoría?","delete_category",[$(this).attr('data-id')])
	})
	
	function delete_category($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_category',
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
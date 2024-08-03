<?php include 'db_connect.php' ?>

<div class="conataine-fluid mt-4">
	<div class="col-lg-12">
	<div class="card-header" style="background-color: #4c9f3f; color: white;">
				SALIDA
			</div>
		<div class="card">

			<div class="card-body">
				<table class="table-condensed table">
				    <thead style="background-color: #529cab; color: white;">
						<tr>
							<th class="text-center">#</th>
							<th>Fecha</th>
							<th>N° Referencia</th>
							<th>Propietario</th>
							<th>Estado</th>
							<th>Acción</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						$qry = $conn->query("SELECT * FROM parked_list order by id desc ");
						while($row=$qry->fetch_assoc()):
						?>	
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo date('M d,Y',strtotime($row['date_created'])) ?></td>
							<td><?php echo $row['ref_no'] ?></td>
							<td><?php echo $row['owner'] ?></td>
							<td>
								<?php if($row['status'] == 1): ?>
									<span class="badge badge-warning">Entrada</span>
								<?php else: ?>
									<span class="badge badge-success">Salida</span>
								<?php endif; ?>

							</td>
							<td class="text-center">
								<a class="btn btn-sm btn-primary view_park" href="index.php?page=view_parked_details&id=<?php echo $row['id'] ?>" class="<?php echo $row['id'] ?>">Ver</a>
								
							</td>
						</tr>
					<?php endwhile ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
	$('table').dataTable()
	$('.delete_park').click(function(){
		_conf("¿Estás seguro de eliminar estos datos?","delete_park",[$(this).attr('data-id')])
	})
	
	function delete_park($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_vehicle',
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
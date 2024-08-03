<?php include 'db_connect.php' ?>
<style>
   span.float-right.summary_icon {
    font-size: 3rem;
    position: absolute;
    right: 1rem;
    color: #ffffff96;
}
</style>

<div class="containe-fluid">
    <div class="row mt-3 mb-3 pl-5 pr-5">
        <div class="col-md-4 offset-md-2">
            <div class="card bg-dark">
                <div class="card-body" style="background-color: #05252b;">
                    <span class="float-right summary_icon"><i class="fa fa-car"></i></span>
                    <h4><b style="color: white;">
                        <?php echo $conn->query("SELECT * FROM parked_list where status = 1")->num_rows; ?>
                    </b></h4>
                    <p><b style="color: white;">Ingresaron</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger">
                <div class="card-body" style="background-color: #05252b;">
                    <span class="float-right summary_icon"><i class="fa fa-car"></i></span>
                    <h4><b style="color: white;">
                        <?php echo $conn->query("SELECT * FROM parked_list where status = 2")->num_rows; ?>

                    </b></h4>
                    <p><b style="color: white;">Salieron</b></p>
                </div>
            </div>
        </div>

    </div>

       <div class="row mt-3 mb-3 pl-5 pr-5">
        <div class="col-md-4 offset-md-2">
            <div class="card bg-primary">
                <div class="card-body" style="background-color: #05252b;">
                    <span class="float-right summary_icon"><i class="fa fa-list"></i></span>
                    <h4><b style="color: white;">
                        <?php echo $conn->query("SELECT * FROM category")->num_rows; ?>
                    </b></h4>
                    <p><b style="color: white;">Categorias</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info">
                <div class="card-body" style="background-color: #05252b;">
                    <span class="float-right summary_icon"><i class="fa fa-map"></i></span>
                    <h4><b style="color: white;">
                        <?php echo $conn->query("SELECT * FROM parking_locations")->num_rows; ?>

                    </b></h4>
                    <p><b style="color: white;">Áreas</b></p>
                </div>
            </div>
        </div>
        
    </div>

	<div class="row mt-3 ml-3 mr-3">
			<div class="col-lg-12">
    		<div class="card" style="background-color: #b1df9b;">
    				<div class="card-body" style="opacity: 3;">
    				<strong><?php echo "BienvenidoX "; ?></strong>
    					<hr>	

                        <div class="row">
                            <div class="col-lg-8 offset-2">
                                    <table class="table table-striped table-hover" style="border-collapse: collapse; width: 100%;">
                                    <thead style="background-color: #05252b; color: white;">
                                    <tr>
                                        <th class="text-center">Área</th>
                                        <th class="text-center">Libres</th>
                                    </tr>
                                    <?php
                                    $cat = $conn->query("SELECT * FROM category order by name asc");
                                    while($crow = $cat->fetch_assoc()):
                                    ?>
                                    <tr>
                                        <th class="text-center" colspan="2"><?php echo $crow['name'] ?></th>
                                    </tr>
                                    <?php 
                                  
                                    $location = $conn->query("SELECT * FROM parking_locations where category_id = '".$crow['id']."'  order by location asc");
                                    while($lrow= $location->fetch_assoc()):
                                        $in = $conn->query("SELECT * FROM parked_list where status = 1 and location_id = ".$lrow['id'])->num_rows;
                                        $available = $lrow['capacity'] - ( $in);


                                    ?>
                                    <tr>
                                        <td><?php echo $lrow['location'] ?></td>
                                        <td class="text-center"><?php echo $available ?></td>
                                    </tr>
                                <?php endwhile; ?>
                                <?php endwhile; ?>
                                </table>
                            </div>
                        </div>      			
    				</div>
    				
    				
    		      </div>
                </div>
	</div>
<hr>
<?php if($_SESSION['login_type'] == 2): ?>
<?php 

?>
<script>
    function queueNow(){
            $.ajax({
                url:'ajax.php?action=update_queue',
                success:function(resp){
                    resp = JSON.parse(resp)
                    $('#sname').html(resp.data.name)
                    $('#squeue').html(resp.data.queue_no)
                    $('#window').html(resp.data.wname)
                }
            })
    }
</script>



<?php endif; ?>


</div>
<script>
	
</script>
<?php
include 'db_connect.php';

// Obtener ID del parámetro de consulta y validarlo
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Preparar y ejecutar la consulta para obtener detalles de la lista de estacionamiento
$query = "SELECT p.*, c.name as cname, c.rate, l.location as lname 
          FROM parked_list p 
          INNER JOIN category c ON c.id = p.category_id 
          INNER JOIN parking_locations l ON l.id = p.location_id 
          WHERE p.id = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die("Error al preparar la consulta: " . $conn->error);
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    die("Error al ejecutar la consulta: " . $stmt->error);
}

$parkedData = $result->fetch_assoc();

// Verificar si se obtuvo algún dato
if (!$parkedData) {
    die("Registro no encontrado.");
}

// Extraer valores
foreach ($parkedData as $key => $value) {
    $$key = $value;
}

// Preparar y ejecutar la consulta para obtener el movimiento de entrada
$queryIn = "SELECT * FROM parking_movement WHERE pl_id = ? AND status = 1";
$stmtIn = $conn->prepare($queryIn);

if ($stmtIn === false) {
    die("Error al preparar la consulta de entrada: " . $conn->error);
}

$stmtIn->bind_param("i", $id);
$stmtIn->execute();
$inResult = $stmtIn->get_result();

if ($inResult === false) {
    die("Error al ejecutar la consulta de entrada: " . $stmtIn->error);
}

$inTimestamp = $inResult->num_rows > 0 ? date("M d, Y h:i A", strtotime($inResult->fetch_array()['created_timestamp'])) : 'N/A';

// Preparar y ejecutar la consulta para obtener el movimiento de salida
$queryOut = "SELECT * FROM parking_movement WHERE pl_id = ? AND status = 2";
$stmtOut = $conn->prepare($queryOut);

if ($stmtOut === false) {
    die("Error al preparar la consulta de salida: " . $conn->error);
}

$stmtOut->bind_param("i", $id);
$stmtOut->execute();
$outResult = $stmtOut->get_result();

if ($outResult === false) {
    die("Error al ejecutar la consulta de salida: " . $stmtOut->error);
}

$outTimestamp = $outResult->num_rows > 0 ? date("M d, Y h:i A", strtotime($outResult->fetch_array()['created_timestamp'])) : 'N/A';

// Calcular el tiempo de estacionamiento y el monto adeudado si el vehículo ha salido
if ($status == 2) {
    $inTimestampUnix = strtotime($inTimestamp);
    $outTimestampUnix = strtotime($outTimestamp);
    $diffInSeconds = abs($outTimestampUnix - $inTimestampUnix);
    $diffInHours = $diffInSeconds / (60 * 60);
    
    $hours = floor($diffInHours);
    $minutes = floor(60 * ($diffInHours - $hours));
    
    $calc = $hours;
    if ($minutes >= 60) {
        $calc .= ':00';
    } else {
        $calc .= ':' . str_pad($minutes, 2, '0', STR_PAD_LEFT);
    }
}
?>
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <a href="index.php?page=manage_park&id=<?php echo $id ?>" class="btn btn-sm btn-primary btn-block col-sm-2 float-right"><i class="fa fa-edit"></i> Editar</a>
                <a href="javascript:void(0)" id="btn_print" class="btn btn-sm btn-primary btn-block col-sm-2 float-right mr-2 mt-0"><i class="fa fa-print"></i> Imprimir ticket</a>
                <h4><b>N° de referencia de parqueo : <?php echo $ref_no ?></b></h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p>Área de estacionamiento del vehículo: <b><?php echo $lname ?></b></p>
                        <p>Categoría del vehículo: <b><?php echo $cname ?></b></p>
                        <p>Dueño del vehículo: <b><?php echo $owner ?></b></p>
                        <p>N° de placa: <b><?php echo $vehicle_registration ?></b></p>
                        <p>Marca del vehículo: <b><?php echo $vehicle_brand ?></b></p>
                        <p>Descripción del vehículo: <b><?php echo !empty($vehicle_description) ? $vehicle_description : "No se ingresaron detalles" ?></b></p>
                        <p>Vehículo ingresado en: <b><?php echo $inTimestamp ?></b></p>
                    </div>
                    <div class="col-md-6">
                        <?php if ($status == 1): ?>
                            <button type="button" id="checkout_btn" class="btn-sm btn btn-block col-sm-5 btn-primary"><i class="fa fa-calculator"></i> Calcular para pagar</button>
                            <div id="check_details"></div>
                        <?php else: ?>
                            <table class="table table-bordered" width="100%">
                                <tr>
                                    <th class="text-center" colspan='2'>
                                        <a href="javascript:void(0)" id="btn_print_receipt" class="btn btn-sm btn-primary float-right mr-2 mt-0"><i class="fa fa-print"></i></a>
                                        Detalles de pago
                                    </th>
                                </tr>
                                <tr>
                                    <th>Hora de ingreso</th>
                                    <td class="text-right"><?php echo $inTimestamp ?></td>
                                </tr>
                                <tr>
                                    <th>Hora de salida</th>
                                    <td class="text-right"><?php echo $outTimestamp ?></td>
                                </tr>
                                <tr>
                                    <th>Diferencia de tiempo</th>
                                    <td class="text-right"><?php echo $calc . " (" . number_format($diffInHours, 2) . " horas)" ?></td>
                                </tr>
                                <tr>
                                    <th>Tarifa por hora del tipo de vehículo</th>
                                    <td class="text-right"><?php echo number_format($rate, 2) ?></td>
                                </tr>
                                <tr>
                                    <th>Monto adeudado</th>
                                    <td class="text-right"><?php echo number_format($rate * $diffInHours, 2) ?></td>
                                </tr>
                                <tr>
                                    <th>Monto pagado</th>
                                    <td class="text-right"><?php echo number_format($amount_tendered, 2) ?></td>
                                </tr>
                                <tr>
                                    <th>Cambio</th>
                                    <td class="text-right"><?php echo number_format($amount_change, 2) ?></td>
                                </tr>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#btn_print').click(function(){
        var nw = window.open("print_receipt.php?id=<?php echo $id ?>", "_blank", "height=500,width=800");
        nw.print();
        setTimeout(function(){
            nw.close();
        }, 500);
    });

    $('#btn_print_receipt').click(function(){
        var nw = window.open("print_checkout_receipt.php?id=<?php echo $id ?>", "_blank", "height=500,width=800");
        nw.print();
        setTimeout(function(){
            nw.close();
        }, 500);
    });

    $('#checkout_btn').click(function(){
        start_load();
        $.ajax({
            url: 'get_check_out.php?id=<?php echo $id ?>',
            success: function(resp){
                if (resp) {
                    $('#check_details').html(resp);
                    end_load();
                }
            }
        });
    });
</script>

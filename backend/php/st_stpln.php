<?php 
require_once('../../backend/bd/ctconex.php'); 

if(isset($_POST['staddplan'])) {
    $nompla = trim($_POST['txtnampla']);
    $estp = trim($_POST['txtesta']);
    $prec = trim($_POST['txtprepl']);
    
    if (empty($nompla)) {
        echo '<script type="text/javascript">
            swal("Error!", "Por favor, ingrese un nombre.", "error").then(function() {
                window.location = "../plan/nuevo.php";
            });
            </script>';
    } else {
        // Validaremos primero que el documento no exista
        $sql = "SELECT * FROM plan WHERE nompla ='$nompla'";
        $stmt = $connect->prepare($sql);
        $stmt->execute();

        if ($stmt->fetchColumn() == 0) {
            if (!isset($errMSG)) {
                $stmt = $connect->prepare("INSERT INTO plan(nompla, estp, prec) VALUES(:nompla, :estp, :prec)");
                $stmt->bindParam(':nompla', $nompla);
                $stmt->bindParam(':estp', $estp);
                $stmt->bindParam(':prec', $prec);

                if ($stmt->execute()) {
                    echo '<script type="text/javascript">
                        swal("¡Registrado!", "Se agregó correctamente", "success").then(function() {
                            window.location = "../plan/mostrar.php";
                        });
                        </script>';
                } else {
                    $errMSG = "Error al insertar...";
                }
            }
        } else {
            echo '<script type="text/javascript">
                swal("Error!", "Ya existe el registro a agregar!", "error").then(function() {
                    window.location = "../plan/nuevo.php";
                });
                </script>';
        }
    }
}
?>

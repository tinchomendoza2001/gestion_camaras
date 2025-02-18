<?php
// Incluir configuración general
include_once('configuration.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link rel="stylesheet" href="">
</head>
<body>
    <h3>Configuración Back-end</h3>
    <div style="background-color: #eee; padding: 10px; border: 1px solid #ccc;">
        <pre><?php echo var_dump($appConfig); ?></pre>
    </div>

    <h3>Configuración Front-end</h3>
    <p>Probar configuración: <button id="test-button">Ver valor</button> o imprimir todo en la consola <button id="test-console">log!</button></p>

    <script>
        var projectNameApp = <?php echo json_encode($appConfigJs);?>

        // Eventos
        var button =document.getElementById('test-button');
        button.onclick = function(){
            alert('projectNameApp.arcgis.services: ' + projectNameApp.arcgis.services);
            return false;
        };

        var buttonLog =document.getElementById('test-console');
        buttonLog.onclick = function(){
            console.log(projectNameApp);
            return false;
        };
    </script>
</body>
</html>

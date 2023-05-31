<?php

function obtenerCoordenadas($direccion) {
    // Codifica la dirección para que sea segura para la URL
    $direccion_codificada = urlencode($direccion);
    
    // Construye la URL de la solicitud a la API de Geocodificación de Google Maps
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$direccion_codificada}&key=AIzaSyAVNS1lqK1cBs0raTgMXDpg_Rxp6C20ZQ4";
    
    // Realiza la solicitud GET a la API
    $respuesta = file_get_contents($url);
    
    // Decodifica la respuesta JSON
    $datos = json_decode($respuesta, true);
    
    // Verifica si se obtuvo una respuesta válida
    if ($datos['status'] === 'OK') {
        // Obtiene las coordenadas de latitud y longitud
        $latitud = $datos['results'][0]['geometry']['location']['lat'];
        $longitud = $datos['results'][0]['geometry']['location']['lng'];
        
        // Retorna un arreglo con las coordenadas
        return ['latitud' => $latitud, 'longitud' => $longitud];
    }
    
    // Si no se pudo obtener la respuesta, retorna NULL o muestra un mensaje de error
    return null;
}

// Ejemplo de uso
$direccion = "1600 Amphitheatre Parkway, Mountain View, CA";
$coordenadas = obtenerCoordenadas($direccion);

if ($coordenadas) {
    echo "Latitud: " . $coordenadas['latitud'] . "<br>";
    echo "Longitud: " . $coordenadas['longitud'];
} else {
    echo "No se pudo obtener las coordenadas.";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>localización</title>
	<!-- Enlace a los estilos CSS de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Puntos en mapa</h1>
 
        <h3 class="mt-5">Mapa</h3>
		 <!-- Mapa de Google Maps -->
        <div id="map"></div>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAVNS1lqK1cBs0raTgMXDpg_Rxp6C20ZQ4"></script>
	 <!-- Script para cargar el mapa y los datos -->
    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 4,
                center: {
                    lat: 32.7617,
                    lng: -83.1918
                } // Miami coordinates
            });

   

          
                var marker = new google.maps.Marker({
                    position: {
                        lat: <?php echo $coordenadas['latitud'] ?> ,
                        lng: <?php echo $coordenadas['longitud'] ?>
                    },
                    map,
                    title: "coordenadas <?php echo $coordenadas['latitud'] ?>  <?php echo $coordenadas['longitud'] ?> ", 
                });
           
        }

        // Inicializar el mapa una vez se cargue la página
        google.maps.event.addDomListener(window, 'load', initMap);
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAVNS1lqK1cBs0raTgMXDpg_Rxp6C20ZQ4&callback=initMap"></script>
</body>
</html>


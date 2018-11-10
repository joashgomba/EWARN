<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <title>Google Maps Demo</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <meta name="description" content="">
  <meta name="viewport" content="width=device-width">

  <style>
    #map-canvas{
      width: 800px;
      height: 800px;
    }
  </style>
</head>
<body>
  <div id="json_data" style="display:none;">
    <?php
	
	
      $points = array(
	    array(
          'position' => array(
            'lat' => '-1.112982366348',
            'lng' => '36.635627746582',
          ),
          'icon' => 'img/pin2.png',
          'info' => 'Hello Joash!'
        ),
        array(
          'position' => array(
            'lat' => '-1.3930664629646',
            'lng' => '36.691761016846',
          ),
          'icon' => 'img/pin2.png',
          'info' => 'Hello World!'
        ),
        array(
          'position' => array(
            'lat' => '-1.3127513406',
            'lng' => '36.789608001709',
          ),
          'icon' => 'img/pin2.png',
          'info' => 'Hello World!'
        ),
        array(
          'position' => array(
            'lat' => '0.043945308191358',
            'lng' => '34.652423858643',
          ),
          'icon' => 'img/pin2.png',
          'info' => 'Hello World!'
        ),
        array(
          'position' => array(
            'lat' => '-1.3402098002785',
            'lng' => '36.809692382812',
          ),
          'icon' => 'img/pin2.png',
          'info' => 'Hello World!'
        ),
        array(
          'position' => array(
            'lat' => '-1.3072596122757',
            'lng' => '36.853637695312',
          ),
          'icon' => 'img/pin2.png',
          'info' => 'Hello World!'
        ),
        array(
          'position' => array(
            'lat' => '-1.3292264529974',
            'lng' => '36.864624023438',
          ),
          'icon' => 'img/pin2.png',
          'info' => 'Hello World!'
        ),
        array(
          'position' => array(
            'lat' => '1.4061088354351',
            'lng' => '36.930541992188',
          ),
          'icon' => 'img/pin2.png',
          'info' => 'Hello World!'
        ),
        array(
          'position' => array(
            'lat' => '-3.6669277409287',
            'lng' => '36.573486328125',
          ),
          'icon' => 'img/pin2.png',
          'info' => 'Hello World!'
        ),
        array(
          'position' => array(
            'lat' => '-1.2962761196418',
            'lng' => '36.853637695312',
          ),
          'icon' => 'img/pin2.png',
          'info' => 'Hello World!'
        ),
        array(
          'position' => array(
            'lat' => '-0.64500182074986',
            'lng' => '36.227135360241',
          ),
          'icon' => 'img/pin2.png',
          'info' => 'Hello World!'
        ),
        array(
          'position' => array(
            'lat' => '-1.3354045918802',
            'lng' => '36.974830627441',
          ),
          'icon' => 'img/pin2.png',
          'info' => 'Hello World!'
        ),
        array(
          'position' => array(
            'lat' => '-1.3072596122757',
            'lng' => '36.952514648438',
          ),
          'icon' => 'img/pin2.png',
          'info' => 'Hello World!'
        ),
      );
      echo json_encode($points);
     ?>
  </div>
  <div id="map-canvas"></div>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="js/markerclusterer.js"></script>
  <script src="js/map.js"></script>
</body>
</html>

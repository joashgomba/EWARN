<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>Full Screen Google Maps</title>
    <style type="text/css">

    html, body {
      height: 100%;
      overflow: hidden;
    }

    body {
      background-color: white;
      font-family: Arial, sans-serif;
      margin: 0;
    }

    a:link {
      color: #0000cc;
    }

    a:active {
      color: red;
    }

    a:visited {
      color: #551a8b;
    }
/**
   #map-canvas{
      width: 100%;
      height: 100%;
    }
	**/
	 #map-canvas {
position: relative;
padding-bottom: 75%; // This is the aspect ratio
height: 100%;
overflow: hidden;
}

    .loading {
      color: gray;
      font-size: medium;
      padding: 1em;
    }

    </style>
  </head>
  <table>
  <tr><td>Zone</td><td>
  <select>
  <option value="">zone one</option>
  <option value="">zone two</option>
  </select>
  </td></tr>
  </table>
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
</html>

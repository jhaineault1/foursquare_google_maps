<!DOCTYPE html>
<html>
<head>
<title>nearbysearch</title>

 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
 <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyCVdcp9xRIe16S9_T4TTSLRFRrX9WUTn1k"></script>
 <script type="text/javascript" src="gmaps.js"></script>
 <script type="text/javascript">
  var map;
  $(document).ready(function(){
        map = new GMaps({
        div: '#map',
        lat: 33,
        lng: -84,
        zoom:4,
      });
  });   // end of ready


//Connects to Foursquare API using client_id and client_secret keys.  
<?php   
          if (isset($_GET['search']))  {

            $client_id = 'BZ1PKAFCPQN3HRK2PGSLQN2NUYCF5F4LTMF4WRRQ2OVNJ2XO' ;
            $client_secret = 'KTDIIJYRDVI5C0FCTN0VLOEP0JMASN0IUSWWJJSMPRWAF5LU' ;

            //Builds url Search Venue request to Foursquare
            $url = 'https://api.foursquare.com/v2/venues/search';  
            $url .= '?near='.urlencode($_GET['near']) ; 
            $url .= '&query='.urlencode($_GET['query']) ;  
            $url .= '&radius='.$_GET['radius'] ; 
            $url .= '&client_id='.$client_id ;
            $url .= '&client_secret='.$client_secret ;
                           
            $url .= '&v=20161010';      
            $url .= '&m=foursquare';                                

            $file = file_get_contents($url);
            $data = json_decode($file, true);
            $items= $data['response']['venues'];                      
            $size = count($items);


        
            // loop  through all the returned businesses
            echo "map.addMarker({\n";
            foreach ($items as $item)  {

              $name = filter_var($item['name'],FILTER_SANITIZE_STRING);
            
              echo "title:'".$name."',\n";
              echo "lat:".$item["location"]['lat'].",\n";
              echo "lng:".$item["location"]['lng'].",\n"; 
              
            }
            echo "});\n";

            //Prints Json structure for guidence
            print_r($data);
          }
?>
</script>


</head>
  <body>
    <form action="" method="GET">
    <br>Keyword:<input type="text" name="query"  style="width: 200px; height: 19px">
    <br>Near:<input type="text" name="near"  style="width: 200px; height: 19px">
    <br>Radius (<100,000 meters):<input type="text" name="radius"  style="width: 150px; height: 19px">
    <br><input type="submit" name="search" value="Search (Foursquare API)"  style="width: 246px; height: 40px" />
    </form>

    <div id="map" style="width: 1019px; height: 622px"></div>
      <form method="post" action= "<?php echo "http://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&sensor=false"?>">
      <br><br><input type="submit" value="Show detailed address" />
      </form>
  </body>
</html>
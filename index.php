<?php


   
?>


<!Doctype html>

<html>

<head>
    <title>firstTimeZoneProject</title>
    
    <style type="text/css">
        
        #container {
                    width: 500px;
                    height: 350px;
                    border: 3px black solid;
                    margin: 40px auto;
        }
        
        html {
              text-align: center;
        }
        
        #time {
               width: 350px;
               height: 80px;
               background-color: yellow;
               margin: 20px auto;
               padding: 20px 5px;
        }
        
        #submit:hover {
                       background-color: green;
        }
    
    
    
        </style>
</head>

<body>
    
    <div id='container'>
        
      <form method="Post">
    
        <h1>Please Select Your Timezone</h1>
         <label for="select">Timezones:</label>
            <select name="visitors_timezone" >  
             <?php
                
                $date = new DateTime('now');
                $tz = $date->gettimezone();
                $timezones = DateTimeZone::ListIdentifiers();
                $zone = $tz->getName();

                  foreach($timezones as $value){
                    $tz = new dateTimeZone($value);
                    $date->setTimezone($tz);
                    $offset = ($date->getoffset())/3600;
                    
                      if(isset($_POST["submitted"])){
                        $zone = $_POST["visitors_timezone"];
                        $tz = new dateTimeZone($zone);
                        $date->setTimezone($tz);
                      } else{
                          $tz = new dateTimeZone($zone);
                          $date->setTimezone($tz);
                        }  
                    echo "<option value=\"$value\"";
                  if($zone == $value){echo "selected";}
                   echo ">$value  (UTC/GMT $offset)</option>";
                  }
                
                $time = $date->format('h:i:s A');
                $offset = $date->getoffset();
                
             ?>   
            </select>
        
         <p><input type="submit" name="submitted" id="submit"></p>
          
    
      </form>
        
        <div id="time">
        
            <p>The time in your location is <?= $time ?></p>
            <p>Your locations offset from UTC is <?= $offset/3600 ?> hours</p>
        
        </div>
        
    </div>

    
</body>

</html>

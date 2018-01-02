<?php
    //this function converts the offset from seconds into hour and minutes
    function offset_in_time($offset){
        //gmp_div_qr() divides two numbers and returns the quotient and remainder as an array
        $time = gmp_div_qr($offset, 3600);
         $hours = $time[0];
         $mins = $time[1];
            
            //adds zero at the back +ve hours less than 10
            if ($hours >= 0 && $hours < 10){
                $hours = '+0'.$hours;
            }elseif($hours >= 0 || $mins > 0){
                $hours = '+'.$hours;
            }
            //adds zero at the back +ve hours greater than -10
            if ($hours < 0 && $hours > -10){
                $hours = (-1) * $hours;
                $hours = '-0'.$hours;
            }
            //coverts remainders that are still in seconds to minutes
            if (abs($mins) > 59){
                $minutes = gmp_div_qr($mins, 60);
                $mins = $minutes[0];
                  if($minutes[1] > 0){
                      $mins = $minutes[0].':'.$minutes[1];
                  }
            }
            //adds zero at the back of seconds less than 10
            if (abs($mins) > -1 && abs($mins) < 10){
                $mins = '0'.abs($mins);
            }
        
        return $hours.':'.$mins;
    }
   
?>


<!Doctype html>

<html>

<head>
    <title>Time Checker</title>
    
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
                
                //instantiate a dateTime object and get the current timeZone from the dateTime object
                $date = new DateTime('now');
                $tz = $date->gettimezone();
                
                //get an array of all php surpported timeZones and loop through them
                $timezones = DateTimeZone::ListIdentifiers();
                $zone = $tz->getName();

                  foreach($timezones as $value){
                    $tz = new dateTimeZone($value);
                    $date->setTimezone($tz);
                    $offset = $date->getoffset();
                    $offset_in_time = offset_in_time($offset);
                      
                      //on form submittion 
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
                   echo ">$value  (UTC/GMT $offset_in_time)</option>";
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

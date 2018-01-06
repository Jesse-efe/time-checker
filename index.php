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

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    
    <title>Time Checker</title>
    
    <style type="text/css">
        
        .container {
                    margin: 20px auto;
                    text-align: center;
        }
        
        html {
              background: url(background.jpg) no-repeat center center fixed; 
              -webkit-background-size: cover;
              -moz-background-size: cover;
              -o-background-size: cover;
              background-size: cover;
        }
        
        body {
              background: none;
        }
        
        #time {
               width: 500px;
               margin: 10px auto;
               text-align: center;
        }
        
        #button {
                       margin: 30px auto;
        }
        
        h1 {
            color: black;
            margin-top: 100px;
            text-align: center;
        }
        
        @media screen and (max-width: 600px) {
            #time {
                  width: 70%;
            }
        }
    
    
    
        </style>
</head>

<body>
    
    <h1>Please Select A Timezone</h1>
    
   <div class="container">
    
      <form method="Post">
    
        
        <div class="form-group">
            
            <label for="exampleFormControlSelect1"></label>
            <select class="form-control" id="exampleFormControlSelect1" name="visitors_timezone">
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
                
                //explode the users timezone to get the actual location which is the last element in the resulting array
                $location_array = explode("/", $zone);
                $location_size = count($location_array);
                $location_index = ($location_size - 1);
                
             ?>   
            </select>
        
          <button type="submit" name="submitted" class="btn btn-primary" id="button">Check Time</button>
            
        </div>
  
      </form>
        
    </div>
    
    <div id="time">
    
        <div class="alert alert-success" role="alert">

            <p><strong>The time in <?= $location_array[$location_index] ?> is <?= $time ?></strong></p>
            <!--<p>Your locations offset from UTC is <?= $offset/3600 ?> hours</p>-->

        </div>
    
    </div>
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
  

    
</body>

</html>

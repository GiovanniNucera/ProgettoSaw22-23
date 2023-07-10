<?php
ob_start();
ini_set('display_errors', false);
ini_set('error_log', '../log/crowdfunding.log');

session_start();

//rendo questo processo di donazione univoco
$rand = rand();
$_SESSION['thisdonation'] = $rand;

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Crowdfunding</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="../css/ourworks.css">
  <link rel="stylesheet" type="text/css" href="../css/clock.css" >
  <link rel="stylesheet" href="../css/stylehome.css">
  <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
  <script src="../js/navbar.js"></script>

<style>
    .row{
      padding: 14px 35px;
    }

</style>


<script>

var data = [];
var datenostart = [];
function cdtime(starttdate,targetdate,curr,idCrowdfunding)
{
      let form = document.getElementById("form"+curr);
      let trigger = 0;
      let endDate = new Date(targetdate);
      let startDate = new Date(starttdate);
      let timer = setInterval(function ()
        {
          let curDate = new Date();
          if(curDate<startDate)
          {
            let diff = startDate.getTime() - curDate.getTime();
            datenostart[curr] = diff;
            ms = datenostart[curr];

            let elements = document.getElementsByClassName('containercountdown');
            if(document.getElementById("form"+curr) != null)
            {
              let temp = form.elements;
              for (let i = 0; i < temp.length; i++)
              {
                 temp[i].remove();
              }
            }

            elements[curr].lastChild.innerHTML = "Start in: ";
            let days = Math.floor(ms / (24*60*60*1000));
            let daysms = ms % (24*60*60*1000);

            let hours = Math.floor(daysms / (60*60*1000));
            let hoursms = ms % (60*60*1000);

            let minutes = Math.floor(hoursms / (60*1000));
            let minutesms = ms % (60*1000);

            let seconds = Math.floor(minutesms / 1000);

            document.getElementById("days"+curr).innerHTML = days;
            document.getElementById("hours"+curr).innerHTML = hours;
            document.getElementById("minutes"+curr).innerHTML = minutes;
            document.getElementById("seconds"+curr).innerHTML = seconds;
            trigger++;
          }

          if(curDate>startDate)
          {
          if(trigger>0)
          {
            form.innerHTML= '<input type="hidden" id="idCrowdfunding" name="idCrowdfunding" value="'+idCrowdfunding+'"><input type="number" placeholder="Donation Amount" name="amount"><button type="submit">Donate</button>';
            trigger = -1;
          }
          let elements = document.getElementsByClassName('containercountdown');
          elements[curr].lastChild.innerHTML = "Time left: ";
          let diff = endDate.getTime() - curDate.getTime();
          data[curr]= diff;
          ms = data[curr];
          if(ms<=0)
          {
            elements[curr].removeChild(elements[curr].firstChild);
            elements[curr].firstChild.style.right = "-86px";
            elements[curr].firstChild.style.bottom = "-7px";
            elements[curr].firstChild.innerHTML = "Time left: EXPIRED";
            document.getElementById("form"+curr).remove();
            clearInterval(timer);
            return false;
          }
          let days = Math.floor(ms / (24*60*60*1000));
          let daysms = ms % (24*60*60*1000);

          let hours = Math.floor(daysms / (60*60*1000));
          let hoursms = ms % (60*60*1000);

          let minutes = Math.floor(hoursms / (60*1000));
          let minutesms = ms % (60*1000);

          let seconds = Math.floor(minutesms / 1000);

          document.getElementById("days"+curr).innerHTML = days;
          document.getElementById("hours"+curr).innerHTML = hours;
          document.getElementById("minutes"+curr).innerHTML = minutes;
          document.getElementById("seconds"+curr).innerHTML = seconds;
          }
        }, 1000);
  }
</script>

</head>

<body>

<nav class="navbar">
    <div class="logo"><img src="../images/LOGO.png" alt=""> </div>
    <div class="push-left">
      <button id="menu-toggler" data-class="menu-active" class="hamburger">
        <span class="hamburger-line hamburger-line-top"></span>
        <span class="hamburger-line hamburger-line-middle"></span>
        <span class="hamburger-line hamburger-line-bottom"></span>
      </button>


      <ul id="primary-menu" class="menu nav-menu">
        <?php
            echo'<li class="menu-item"> <div class="nav__link"> <input class="searchBar" type="text"  name="searchquery" placeholder="Search project..." id="searchBar" onkeyup="searchProduct()"> </div>';
            include("../navbar.php");
        ?>
      </ul>
    </div>
  </nav>



  <div class="home"><h1>CROWDFUNDING</h1></div>
      <div class="row" id="project">
              <ul>
                <?php
                include("../connection.php");
                $currdate = date('Y-m-d H:i:s');
                $curr=0;

                $query = "SELECT * FROM crowdfunding";
                $res = $conn->query($query);
                if (!$res) {
                    error_log("Query failed:" . $conn->error);
                    exit("Something went wrong, visit us later\n");
                }

                while($row = $res->fetch_assoc()){
                    $enddate = $row['enddate'];
                    $datetime = $row['datetime'];
                    $idCrowdfunding = $row['id'];
                    echo '<li title="' . $row['name'] . '">';
                    echo "<h3>Project ".$row['id'].": ".$row['name']."</h3>";
                    echo "<p>".$row['description']."</p>";

                    $query2 = "SELECT SUM(amount) AS donated FROM donation WHERE idCrowdfunding =".$row['id'];
                    $res2 = $conn->query($query2);
                    if (!$res2) {
                        error_log("Query failed:" . $conn->error);
                        exit("Something went wrong, visit us later\n");
                    }

                    $row2 = $res2->fetch_assoc();
                    $perc = $row2['donated']/$row['goal']*100;
                    $perc = round($perc, 2);
                    echo '<div class="containerclock">';
                    echo '<div class="containergoal" >Donated: $'.($row2['donated']+0)."/ Goal: $".$row['goal']."</div>";
                    echo '<div class="containercountdown">';
                    echo  '<ul>';
                    echo  '<li><div class="containertime" id="days'.$curr.'"></div><div>days</div></li>';
                    echo  '<li><div class="containertime" id="hours'.$curr.'"></div><div>hours</div></li>';
                    echo  '<li><div class="containertime" id="minutes'.$curr.'"></div><div>minutes</div></li>';
                    echo  '<li><div class="containertime" id="seconds'.$curr.'"></div><div>seconds</div></li>';
                    echo  '</ul>';
                    echo '<div>Time left:</div>';
                    echo  '</div>';
                    echo '<div class="progress">';
                    echo '<div class="progress-bar progress-bar-striped" role="progressbar" style="width: '.$perc.'%" aria-valuenow="'.$perc.'" aria-valuemin="0" aria-valuemax="100">'.$perc.'%</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '<form id="form'.$curr.'" action="donation.php" method="POST">
                            <input type="hidden" name="idCrowdfunding" value="'.$idCrowdfunding.'">
                            <input type="number" min="1" placeholder="Donation Amount" name="amount">
                            <input type="hidden"  name="uniqueDonation" value="'.$rand.'">
                            <button type="submit">Donate</button>
                            </form>';
                      echo "</li>";
                      echo '<script>';
                      echo 'cdtime("'.$datetime.'","'.$enddate.'"'.','.$curr.','.$idCrowdfunding.')';
                      echo '</script>';
                      $curr++;
                }
                $res2->free();
                $res->free();
                $conn->close();
                ?>
              </ul>
        </div>

<script>

    function searchProduct() {
      var input, filter, cont, li, i, txtValue;
      input = document.getElementById('searchBar');
      filter = input.value.toUpperCase();
      li =  document.querySelectorAll('#project>ul>li');


      for (i = 0; i < li.length; i++) {
          txtValue = li[i].title
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
          }else{
                li[i].style.display = "none";
          }
      }
    }
</script>
<?php  include("../footer.php"); ?>
</body>

</html>

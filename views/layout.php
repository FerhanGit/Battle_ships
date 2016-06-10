<!DOCTYPE html>
<html lang="bg">
<head>
<meta charset="utf-8" />
<meta name="description" content="Best BattleShips game ever!" />
<link href="../src/img/favicon.ico" rel="shortcut icon" /> 

<title>Ferhan BattleShips</title>
<link rel='stylesheet' type='text/css' media='all' href='../src/css/style.css' />
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<?php
    $shipsArray = json_encode($_SESSION['battleShips']['shipsArray']);
    $allPositions = json_encode($_SESSION['battleShips']['allPositions']);
    
?>
<script> 
$(document).ready(function() {
    
    var shipsArray = <?=$shipsArray?>;
    var allPositions = <?=$allPositions?>;
    var countPossibleHits = <?=count($_SESSION['battleShips']['shipsArray'])?>;
    var countCurrentHits = 0;
    var countShoots = 0;
    
    $(".cell").on("click", function() {
        
        countShoots++;
        var cellInfo = $(this).attr('id').split("cell_");
      
        if($.inArray(cellInfo[1], shipsArray) != -1){
            $(this).html('x');
            $("#msgDiv").html('Your shoot <span style="color:green; font-weight:bold;">HIT</span> the target.');
            $("#msgDiv").fadeTo('slow', 0.5).fadeTo('slow', 1.0).fadeTo('slow', 0);
            countCurrentHits++;
            if(countCurrentHits == countPossibleHits) {
                $("#board").hide('Slow');
                $("#show").hide('Slow');
                $("#inputForm").hide('Slow');
                if(countCurrentHits > (countPossibleHits * 3)) {
                    var msg = "<span style='color:orange; font-weight:bold;'>Well done!</span>";
                } else {
                    var msg = "<span style='color:green; font-weight:bold;'>Excellent!</span>";
                }
                $("#board").show('Slow');
                var backBtn = "<br /><input type='button' value='Back' id='back' name='back' onClick='window.location.reload()'><br />";
                $("#board").html('You have successfully finished the game with ' + countShoots + 'shoots! ' + msg + backBtn);
            }
        } else {
            $(this).html('0');
            $("#msgDiv").html('Your shoot <span style="color:red; font-weight:bold;">MISS</span> the target.');
            $("#msgDiv").fadeTo('slow', 0.5).fadeTo('slow', 1.0).fadeTo('slow', 0);
        }
    });
    
  
    $("#inputForm").on("submit", function() {
        if($.inArray($("#shootValue").val(), allPositions) != -1) {
            $("#cell_"+ $("#shootValue").val()).click();
        } else {
            alert('Type a correct value, please.');
        }
        $("#shootValue").val('');
        var input = document.getElementById("shootValue");
        input.focus();
        
        return false;        
    });
    
    $("#shootBtn").on("click", function() {
        if($.inArray($("#shootValue").val(), allPositions) != -1) {
            $("#cell_"+ $("#shootValue").val()).click();
        } else {
            alert('Type a correct value, please.');
        }
        $("#shootValue").val('');
        var input = document.getElementById("shootValue");
        input.focus();
        
        return false;        
    });
    
    
     $("#show").on("click", function() {
       $.each(shipsArray, function(index, value) {
            if($('#show').prop('value') == 'Show') {
               $("#cell_"+value).html('x');
            } else {
                $("#cell_"+value).html('.');
            }
        });
        if($('#show').prop('value') == 'Show') {
            $('#show').prop('value', 'Hide');
        } else {
            $('#show').prop('value', 'Show');
        }
        
    });
    
    
});
</script>
</head>
<body>

<?php 
foreach ($layoutParams['loadViews'] as $view) {
    ViewModel::LoadView($view, $layoutParams);
}
?>
    
</body>
</html>
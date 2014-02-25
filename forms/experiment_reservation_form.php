<?php
require_once ('../functions/system_function.php');
require_once (rootPath() . 'class/Objects.php');
require_once (rootPath() . 'module/assetModule.php');
session_start();
if (isset($_SESSION['approved']) && $_SESSION['approved'] == 1) {
    $object = $_SESSION['object'];
    ?>
    <!doctype html>
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <link rel="stylesheet" type="text/css" href="../css/form_style.css"/>
            <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
            <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
            <!--<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
            <script type="text/javascript" src="http://code.jquery.com/jquery-1.4.3.min.js"></script>
            <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>-->
            <style  type="text/css">
                body{
                    width: 960px;
                    margin: 0.5em auto;
                    margin-top: 1.5em;
                }
                #reservation_form{
                    width:800px;
                }
                select{
                    display:block;
                }
                #p_scents input,#asset_list input{
                    display: block;
                }
                #p_scents a,#asset_list a{                    
                    display:inline;
                }
            </style>
        </head>
        <header>
            <h1 id="site_logo"><a href="../">Laboratory asset tracking system</a></h1>
            <h2 id="page_name">Experiment reservation form</h2>
            <?php include rootPath() . "/common_content/login_panel_deep.php"; // div of login panel?>
        </header>
        <body>
            <form action="../functions/FormProcessor.php" method="post" id="reservation_form">
                <label for="project_title">Project title:</label>
                <input id="project_title" name="project_title" type="text" value="">
                <label for="professor_id">Professor ID:</label>
                <input id="professor_id" name="professor_id" type="text" value="">
                <!--<input id="student_name" name="student_name[]" type="hidden" value="<?php //echo $object->getUserName(); ?>">
                <input id="studID" name="studID[]" type="hidden" value="<?php //echo $object->getID(); ?>">-->
                <div id="p_scents">
                    <p><label for="student_name">Name of student &AMP; student ID:  <a href="#" id="addScnt">Add another student</a><input id="student_name" name="student_name[]" type="text" value="<?php echo $object->getUserName(); ?>" readonly><input id="studID" name="studID[]" type="text" value="<?php echo $object->getID(); ?>" readonly></label>
                        </p> 
                </div>

                <label for="course_code">Course code:</label>
                <input id="course_code" name="course_code" type="text" value="">
                <label for="bench">Select a bench</label>
                <select name="bench" id="bench">
                    <?php
                    $benches = getBenchList();
                    foreach ($benches as $b) {
                        echo "<option value='" . $b['asset_id'] . "'>" . $b['name'] . "</option>";
                    }
                    ?>
                </select>
                <div class="control-group">
                    <label class="control-label">Start time:</label>
                    <div class="controls input-append date form_datetime" data-date="" data-date-format="yyyy-mm-dd hh:ii:ss" data-link-field="dtp_input1">
                        <input size="16" type="text" value="" name="start_time" id="start_time" readonly>
                        <span class="add-on"><i class="icon-remove"></i></span>
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                    <input type="hidden" id="dtp_input1" value="" /><br/>
                </div>
                <div class="control-group">
                    <label class="control-label">End time:</label>
                    <div class="controls input-append date form_datetime" data-date="" data-date-format="yyyy-mm-dd hh:ii:ss" data-link-field="dtp_input1">
                        <input size="16" type="text" value="" name="end_time"  id="end_time" readonly onchange="checkTime()">
                        <span class="add-on"><i class="icon-remove"></i></span>
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                    <input type="hidden" id="dtp_input2" value="" /><br/>
                </div>
                <!--<label for="datepicker">Select the date</label>
                <input type="text" id="datepicker" name="datepicker">
                <label for="start_time">Start time</label>
                <select name="start_time" id="start_time">
                <?php /*
                  $timeslot = array("08:00","09:00","10:00","11:00","12:00","13:00","14:00","15:00","16:00","17:00","18:00","19:00");
                  foreach($timeslot as $x){
                  echo ("<option value='" . $x . "'>" . $x . "</option>");
                  } */
                ?>
                </select>
                <label for="end_time">End time</label>
                <select name="end_time" id="end_time">
                <?php /*
                  foreach($timeslot as $x){
                  echo ("<option value='" . $x . "'>" . $x . "</option>");
                  } */
                ?>
                </select>-->
                <div id="asset_list">
                    <p><label for="asset">Asset ID:  <a href="#" id="addAsset">Add another asset</a><input id="asset" name="asset[]" type="text" value=""></label></p>
                         
                </div>
                <input id="action" name="experiment_reservation" type="hidden" value="true">
                <input id="form_submit" type="submit" value="submit form">

            </form>
            <div>

            </div>
        </body>
        <script type="text/javascript" src="../javascript/jquery-1.8.3.min.js" charset="UTF-8"></script>
        <script type="text/javascript" src="../javascript/bootstrap.min.js"></script>
        <script type="text/javascript" src="../javascript/bootstrap-datetimepicker.js" charset="UTF-8"></script>
        <script>
            $(window).load(function() {
                $(function() {
                    var scntDiv = $('#p_scents');
                    var i = $('#p_scents p').size() + 1;

                    $('#addScnt').live('click', function() {
                        $('<p><label for="student_name"><a href="#" id="remScnt">Remove</a><input id="student_name" name="student_name[]" type="text" value="" placeholder="Name"/><input id="studID" name="studID[]" type="text" value="" placeholder="Student id"></label></p>').appendTo(scntDiv);
                        i++;
                        return false;
                    });

                    $('#remScnt').live('click', function() {
                        if (i > 2) {
                            $(this).parents('p').remove();
                            i--;
                        }
                        return false;
                    });
                });
            });
            $(window).load(function() {
                $(function() {
                    var scntDiv = $('#asset_list');
                    var i = $('#asset_list p').size() + 1;

                    $('#addAsset').live('click', function() {
                        $('<p><label for="asset"><a href="#" id="remAsset">Remove</a><input id="asset" name="asset[]" type="text" value="" placeholder="Name"/></label></p>').appendTo(scntDiv);
                        i++;
                        return false;
                    });

                    $('#remAsset').live('click', function() {
                        if (i > 2) {
                            $(this).parents('p').remove();
                            i--;
                        }
                        return false;
                    });
                });
            });

            $('.form_datetime').datetimepicker({
                //language:  'fr',
                weekStart: 1,
                //todayBtn: 1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                forceParse: 0,
                showMeridian: 1,
                minuteStep: 30,
                startDate: new Date()
            });
            /*$(function() {
             $("#datepicker").datepicker();
             });*/
             function checkTime(){
                var startTime= document.getElementById('start_time');
                var endTime = document.getElementById('end_time');
                var startT = new Date(startTime.value.split(' ').join('T')).getTime()/1000;
                var endT = new Date(endTime.value.split(' ').join('T')).getTime()/1000;
                if(endT <= startT)
                   $("#end_time").css({'background-color': 'red'});
             }
        </script>
    </script>
    </html>
    <?php
} else {
    echo "must login first";
    header('Refresh: 3;url=../index.php');
}
?>		
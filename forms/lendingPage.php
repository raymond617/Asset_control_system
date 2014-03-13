<?php
require_once ('../functions/system_function.php');
require_once (rootPath() . 'class/Objects.php');
require_once (rootPath() . 'module/assetModule.php');
session_start();
if (checkLogined() == true) {
    $Object = $_SESSION['object'];
    if ($Object->getUserLevel() == 3) {
        ?>
            <!doctype html>
            <html>
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
                    <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
                    <link rel="stylesheet" type="text/css" href="../css/form_style.css"/>
                    <style  type="text/css">
                        select,label{
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
                <body>
                    <header class="row">
                    <h1 id="site_logo"><a href="../index.php">Laboratory asset tracking system</a></h1>
                    <h2 id="page_name">Form Management</h2>
                    <?php include rootPath() . "common_content/login_panel.php"; // div of login panel?>
                </header>
                    <article>
<?php                    if (isset($_GET['form_id'])) {
            $currentFormID = $_GET['form_id'];
            $formInfo = $_SESSION['object']->getFormInfo($currentFormID);
            ?>
                    <form action="../functions/FormProcessor.php" method="post" id="lend">
                        <label for="formID">Form ID:</label>
                        <input id="formID" name="formID" type="text" value="<?php echo $formInfo['form_id'] ?>" readonly>
                        <label for="studID">Student IDs:</label>
                        <?php foreach ($formInfo['user_array'] as $value) { ?>
                            <input id="studID" name="studID[]" type="text" value="<?php echo $value['id'] ?>" readonly>
                        <?php } ?>
                        <label for="project_title">Project title:</label>
                        <input id="project_title" name="project_title" type="text" value="<?php echo $formInfo['project_title']; ?>">
                        <label for="appl_time">Apply Time:</label>
                        <input id="appl_time" name="appl_time" type="text" value="<?php echo $formInfo['apply_timestamp']; ?>" readonly>
                        <label for="course_code">Course code:</label>
                        <input id="course_code" name="course_code" type="text" value="<?php echo $formInfo['course_code'] ?>">
                        <label for="professor">Professor:</label>
                        <input id="professor_id" name="professor_id" type="hidden" value="<?php echo $formInfo['prof_id']; ?>" >
                        <input id="professor" name="professor" type="text" value="<?php echo $_SESSION['object']->getProfessorName($formInfo['prof_id'])[0][0]; ?>" disabled="disabled">
                        <label for="bench">Bench:</label>
                        <input id="bench" name="bench" value="<?php echo $formInfo['bench'][0]['asset_id'] ?>" type="hidden">
                        <input id="bench" name="bench" value="<?php echo $formInfo['bench'][0]['name'] ?>" disabled type="text">
                        <div class="control-group">
                            <label for="start_time">Start time:</label>
                            <input size="16" type="text" value="<?php echo $formInfo['bench'][0]['start_time'] ?>" name="start_time" id="start_time" readonly>
                        </div>
                        <div class="control-group">
                            <label for="end_time">End time:</label>
                            <input size="16" type="text" value="<?php echo $formInfo['bench'][0]['end_time'] ?>" name="end_time"  id="end_time" readonly>
                        </div>

                        <label>Assets Type , Name , ID:</label>
                        <?php
                        $i = 1;
                        foreach ($formInfo['asset_array'] as $value) {
                            ?>
                            <label><?php echo $i; ?></label>
                            <input type="text" value="<?php echo $value['type']; ?>" readonly>
                            <input type="text" value="<?php echo $value['name'] ?>" readonly>
                            <input type="text" name="asset[]" value="<?php echo $value['asset_id'] ?>" >
                            <?php
                            $i++;
                        }
                        ?>
                        <label for="status">Status:</label>
            <?php $status = $formInfo['status']; ?>
                        <select name="status" form="lend" id="status">
                            <option value="4">Lent</option>
                        </select> 
                        <input id="action" name="lent" type="hidden" value="true">
                        <input id="submit" type="submit" value="Submit Form">
                    </form>
                    <?php } else {
                ?>
                <p>Search form</p>
                <form id="search_form" action="../functions/searchProcessor.php" method="get">
                    <label for="search_type">Search by:</label>
                    <select name="search_type" form="search_form" id="search_type">
                        <option value="form_id">Form ID</option>
                        <option value="id">Student ID</option>
                    </select>
                    <label for="input">ID:</label>
                    <input type="text" placeholder="" name="input" id="input">
                    <input type="submit" value="Submit">
                </form>
                
                <?php
            }?>
                </article>
                </body>
                <script type="text/javascript" src="../javascript/jquery-1.8.3.min.js" charset="UTF-8"></script>
                <script type="text/javascript" src="../javascript/bootstrap.min.js"></script>
                <script type="text/javascript" src="../javascript/bootstrap-datetimepicker.js" charset="UTF-8"></script>
                <script type="text/javascript">
                    var text1 = "<?php echo $status; ?>";
                    $("select option").filter(function() {
                        //may want to use $.trim in here
                        return $(this).attr("value") === text1;
                    }).prop('selected', true);

                    function placeTheType(typeSelectID, type) {
                        $("select#" + typeSelectID + " option").each(function() {
                            this.selected = (this.text === type);
                        });
                        //$("#"+typeSelectID+" option[text=" +type+"]").attr("selected","selected") ;
                        //$("#"+assetSelectID+" option[text=" +asset+"]").attr("selected","selected") ;
                    }

                </script>

<?php                
        } else {
            echo "You have no authorize\n redirect in 3 seconds";
            header('Refresh: 3;url=index.php');
        }
    } else {
        echo "You need login as an admin.";
        header('Refresh: 3;url=index.php');
    }

<?php
require_once ('../functions/system_function.php');
require_once (rootPath() . 'class/Objects.php');
session_start();
if (checkLogined() == true) {
    $adminObject = $_SESSION['object'];
    if ($adminObject->getUserLevel() == 3) {
        $currentFormID = $_GET['form_id'];
        $formInfo = $_SESSION['object']->getFormInfo($currentFormID);
        ?>
        <!doctype html>
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <link rel="stylesheet" type="text/css" href="../css/form_style.css"/>
                <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
                <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
            </head>
            <body>
                <form action="../functions/FormProcessor.php" method="post" id="edit_appl_form">
                    <label for="formID">Form ID:</label>
                    <input id="formID" name="formID" type="text" value="<?php echo $formInfo['form_id'] ?>" readonly>
                    <label for="project_title">Project title:</label>
                    <input id="project_title" name="project_title" type="text" value="<?php echo $formInfo['project_title']; ?>">
                    <label for="appl_time">Apply Time:</label>
                    <input id="appl_time" name="appl_time" type="text" value="<?php echo $formInfo['apply_timestamp']; ?>" readonly>
                    <label for="course_code">Course code:</label>
                    <input id="course_code" name="course_code" type="text" value="<?php echo $formInfo['course_code'] ?>">
                    <label for="professor">Professor:</label>
                    <input id="professor" name="professor" type="text" value="<?php echo $_SESSION['object']->getProfessorName($formInfo['prof_id'])[0][0]; ?>">
                    <label for="assets">Assets:</label>
                    <?php foreach($formInfo['asset_array'] as $value){ ?>
                    <input id="assets" name="asset_array[]" type="text" value="<?php echo $value['asset_id']?>">
                    <?php }?>
                    <label for="status">Status:</label>
                    <?php $status = $formInfo['status']; ?>
                    <select name="status" form="edit_form">
                        <option value="1">Wait for professor's approval</option>
                        <option value="2">Wait for technician's approval</option>
                        <option value="3">Approved</option>
                    </select> 

                    <input id="action" name="edit_appl_form" type="hidden" value="true">

                    <input id="submit" type="submit" value="Edit Form">
                </form>
            </body>
            <script type="text/javascript" src="../javascript/jquery-1.8.3.min.js" charset="UTF-8"></script>
            <script>
                var text1 = "<?php echo $status;?>";
                $("select option").filter(function() {
                    //may want to use $.trim in here
                    return $(this).attr("value") == text1;
                }).prop('selected', true);
            </script>
        </html>
        <?php
    } else {
        echo "You have no authorize\n redirect in 3 seconds";
        header('Refresh: 3;url=index.php');
    }
} else {
    echo "You need login as an admin.";
    header('Refresh: 3;url=index.php');
}
?>	

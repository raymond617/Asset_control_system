<?php
require_once ('../functions/system_function.php');
require_once (rootPath() . 'class/Objects.php');
session_start();
if (isset($_SESSION['approved']) && $_SESSION['approved'] == 1) {
    $object = $_SESSION['object'];
    ?>
    <!doctype html>
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <link rel="stylesheet" type="text/css" href="../css/form_style.css"/>
            <script type="text/javascript" src="http://code.jquery.com/jquery-1.4.3.min.js"></script>
            <style  type="text/css">
                
            </style>
        </head>
        <header>
            <h1 id="site_logo">Admin page</h1>
            <?php include rootPath() . "/common_content/login_panel.php"; // div of login panel?>
        </header>
        <body>

            <form action="../functions/FormProcessor.php" method="post">
                <label for="project_title">Project title:</label>
                <input id="project_title" name="project_title" type="text" value="">
                <div id="p_scents">
                    <p><label for="current_student_name">Name of student &AMP; student ID:<input id="current_student_name" name="current_student_name" type="text" value="<?php echo $object->getUserName(); ?>" disabled><input id="current_studID" name="current_studID" type="text" value="<?php echo $object->getID(); ?>" disabled></label>
                    <a href="#" id="addScnt">Add another student</a></p> 
                </div>
                
                <label for="course_code">Course code:</label>
                <input id="course_code" name="course_code" type="text" value="">
                <label for="bench">Select a bench</label>
                <select name="bench" id="bench">
                    <option value=""></option>
                </select>
                <input id="updateSubmit" type="submit" value="Update Information">
                
            </form>
            <div>

            </div>
        </body>
        <script>
            $(window).load(function() {
                $(function() {
                    var scntDiv = $('#p_scents');
                    var i = $('#p_scents p').size() + 1;

                    $('#addScnt').live('click', function() {
                        $('<p><label for="student_name' + i + '"><input id="student_name' + i + '" name="student_name' + i + '" type="text" value="" /><input id="studID' + i + '" name="studID' + i + '" type="text" value=""></label><a href="#" id="remScnt">Remove</a></p>').appendTo(scntDiv);
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
        </script>
    </html>
    <?php
}
?>		
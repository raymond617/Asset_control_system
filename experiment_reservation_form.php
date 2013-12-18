<?php
	require_once 'functions/Objects.php';
	session_start();
	if (isset($_SESSION['approved']) && $_SESSION['approved']==1){
		$object = $_SESSION['object'];
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href=""/>
<style  type="text/css">
#loginOut{
	float:right;
}
</style>
</head>

<body>
<?php include dirname(__FILE__)."/common_content/login_panel.php";	// div of login panel?>
<form action="functions/FormProcessor.php" method="post">
	<label for="project_title">Project title:</label>
	<input id="project_title" name="project_title" type="text" value="">
	<label for="current_student_name">Name of student:</label>
	<input id="current_student_name" name="current_student_name" type="text" value="<?php echo $object->getUserName();?>" disabled>
	<input id="student_name2" name="student_name2" type="text" value="" >
	<label for="current_studID">Student ID:</label>
	<input id="current_studID" name="current_studID" type="text" value="<?php echo $object->getID();?>" disabled>
	<input id="studID2" name="studID2" type="text" value="">
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
	$(function (){
		// sets the click function to everything with a class of add-field, this is useful if you want multiple add buttons such as plus signs
		$(".add-field").click(function(){
			// selects everything with a value of foo for the name attribute and adds the input after that selection		   
			$("input[name='foo']").after('<br /><input name="foo" type="text" />'); 
			return false;
		});
	});
</script>
</html>
<?php 
	}
?>		
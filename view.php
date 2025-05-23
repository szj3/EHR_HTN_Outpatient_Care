<?php
/*
 * Form view.php
 *
 * @package   OpenEMR
 * @link      http://www.open-emr.org
 * @author    Nikolai Vitsyn
 * @author    Brady Miller <brady.g.miller@gmail.com>
 * @copyright Copyright (c) 2004-2005 Nikolai Vitsyn
 * @copyright Copyright (c) 2019 Brady Miller <brady.g.miller@gmail.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */



require_once("../../globals.php");
require_once("$srcdir/api.inc");

use OpenEMR\Common\Csrf\CsrfUtils;

formHeader("Form: Blank Form");
$returnurl = 'encounter_top.php';
$provider_results = sqlQuery("select fname, lname from users where username=?", array($_SESSION["authUser"]));

/* name of this form */
$form_name = "hypertension_risk_assessment";

// get the record from the database
if ($_GET['id'] != "") {
    $obj = formFetch("form_".$form_name, $_GET["id"]);
}

/* remove the time-of-day from the date fields */
if ($obj['date_of_signature'] != "") {
    $dateparts = explode(" ", $obj['date_of_signature']);
    $obj['date_of_signature'] = $dateparts[0];
}
?>
<html><head>

<link rel="stylesheet" href="<?php echo $css_header;?>" type="text/css">
<link rel="stylesheet" href="<?php echo $GLOBALS['assets_static_relative']; ?>/jquery-datetimepicker/build/jquery.datetimepicker.min.css">

<!-- supporting javascript code -->
<script type="text/javascript" src="<?php echo $GLOBALS['assets_static_relative']; ?>/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/textformat.js?v=<?php echo $v_js_includes; ?>"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['assets_static_relative']; ?>/jquery-datetimepicker/build/jquery.datetimepicker.full.min.js"></script>

<script language="JavaScript">
// required for textbox date verification
var mypcc = <?php echo js_escape($GLOBALS['phone_country_code']); ?>;

function PrintForm() {
    newwin = window.open(<?php echo js_escape($rootdir."/forms/".$form_name."/print.php?id=".urlencode($_GET["id"])); ?>,"mywin");
}

</script>

</head>
<body class="body_top">

<form method=post action="<?php echo $rootdir."/forms/".$form_name."/save.php?mode=update&id=".attr_url($_GET["id"]);?>" name="my_form" id="my_form"> <!-- name and id must be "my_form" -->
<input type="hidden" name="csrf_token_form" value="<?php echo attr(CsrfUtils::collectCsrfToken()); ?>" />

<span class="title"><?php echo xlt('My New Form in view'); ?></span><br></br>


<br></br><br></br>
Please check the box if the question is relevant to you. Leave it blank if it does not apply.:<br></br>
Question 1. <label for="was_diastolic_over_85_this_past_week">Was your diastolic pressure over 85 this past week?</label>
	<input type='checkbox' id='was_diastolic_over_85_this_past_week' name='was_diastolic_over_85_this_past_week' 
	<?php echo ($obj['was_diastolic_over_85_this_past_week']==1 ? 'checked' : '');?> /><br /><br />
Question 2. <label for="was_systolic_over_130_this_past_week">Was your systolic pressure over 130 this past week?</label> 
	<input type='checkbox' id='was_systolic_over_130_this_past_week' name='was_systolic_over_130_this_past_week'
	<?php echo ($obj['was_systolic_over_130_this_past_week']==1 ? 'checked' : '');?> /><br /><br />
Question 3. <label for="are_you_smoker">Are you a current smoker?</label>
	<input type='checkbox' id='are_you_smoker' name='are_you_smoker'
	<?php echo ($obj['are_you_smoker']==1 ? 'checked' : '');?> /><br /><br />
Question 4. <label for="family_history_of_htn_chf_diabetes">Does your family have a history of hypertension, diabetes, and/or CHF?</label>
	<input type='checkbox' id='family_history_of_htn_chf_diabetes' name='family_history_of_htn_chf_diabetes'
	<?php echo ($obj['family_history_of_htn_chf_diabetes']==1 ? 'checked' : '');?> /><br /><br />
Question 5. <label for="exercise_this_week">Did you exercise for under 2 hours this week?</label>
	<input type='checkbox' id='exercise_this_week' name='exercise_this_week'
	<?php echo ($obj['exercise_this_week']==1 ? 'checked' : '');?> /><br /><br />
Total Score: <input type='text' id='total_score' name='total_score' value='<?php echo attr($obj["total_score"]);?>' readonly /><br /><br />
** If the total score is greater than or equal to 3, then you are at HIGH risk for hypertension<br></br>

<table>
<tr><td>
<span class=text><?php echo xlt('Doctor:'); ?> </span><input type=entry name="doctor" value="<?php echo attr($obj["doctor"]);?>">
</td><td>
<span class="text"><?php echo xlt('Date'); ?></span>
   <input type='text' size='10' class='datepicker' name='date_of_signature' id='date_of_signature'
    value='<?php echo attr($obj['date_of_signature']); ?>'
    title='<?php echo xla('yyyy-mm-dd'); ?>' />
</td></tr>
</table>

<div style="margin: 10px;">
<input type="button" class="save" value="    <?php echo xla('Save'); ?>    "> &nbsp;
<input type="button" class="dontsave" value="<?php echo xla('Don\'t Save'); ?>"> &nbsp;
<input type="button" class="printform" value="<?php echo xla('View Printable Version'); ?>"> &nbsp;
</div>

</form>

</body>

<script language="javascript">

// jQuery stuff to make the page a little easier to use

$(function(){
    $(".save").click(function() { top.restoreSession(); $("#my_form").submit(); });
    $(".dontsave").click(function() { parent.closeTab(window.name, false); });
    $(".printform").click(function() { PrintForm(); });

    // disable the Print ability if the form has changed
    // this forces the user to save their changes prior to printing
    $("#img_date_of_signature").click(function() { $(".printform").attr("disabled","disabled"); });
    $("input").keydown(function() { $(".printform").attr("disabled","disabled"); });
    $("select").change(function() { $(".printform").attr("disabled","disabled"); });
    $("textarea").keydown(function() { $(".printform").attr("disabled","disabled"); });

    $('.datepicker').datetimepicker({
        <?php $datetimepicker_timepicker = false; ?>
        <?php $datetimepicker_showseconds = false; ?>
        <?php $datetimepicker_formatInput = false; ?>
        <?php require($GLOBALS['srcdir'] . '/js/xl/jquery-datetimepicker-2-5-4.js.php'); ?>
        <?php // can add any additional javascript settings to datetimepicker here; need to prepend first setting with a comma ?>
    });
});

</script>

</html>

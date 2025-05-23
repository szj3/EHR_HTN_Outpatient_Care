<?php
/*
 * Form print.php
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

use OpenEMR\Core\Header;

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
<title><?php echo "Form: new_form"?></title>

<?php Header::setupHeader(['no_bootstrap', 'no_fontawesome', 'no_textformat', 'no_dialog']); ?>

</head>
<body class="body_top">

<form method=post action="">
<span class="title"><?php echo xlt('My New Form in print'); ?></span><br></br>
<?php echo xlt('Printed'); ?> <?php echo text(dateformat()); ?>
<br><br>

Custom Info:<br></br>
<?php echo text($obj["custom"]);?><br></br>
field 1: <?php echo attr($obj["fld1"]);?><br /><br />
field 2: <?php echo attr($obj["was_diastolic_over_85_this_past_week"]);?><br /><br /> 
field 3: <?php echo attr($obj["was_systolic_over_130_this_past_week"]);?><br /><br /> 
field 4: <?php echo attr($obj["are_you_smoker"]);?><br /><br /> 
field 5: <?php echo attr($obj["family_history_of_htn_chf_diabetes"]);?><br /><br /> 
field 6: <?php echo attr($obj["exercise_this_week"]);?><br /><br />
field 7: <?php echo htmlspecialchars($obj["total_score"]); ?><br /><br />


<table>
<tr><td>
<span class=text><?php echo xlt('Doctor:'); ?> </span><input type=text name="doctor" value="<?php echo attr($obj["doctor"]);?>">
</td><td>
<span class="text"><?php echo xlt('Date'); ?></span>
   <input type='text' size='10' name='date_of_signature' id='date_of_signature'
    value='<?php echo attr($obj['date_of_signature']); ?>'
    />
</td></tr>
</table>

</form>

</body>

<script language="javascript">
// jQuery stuff to make the page a little easier to use

$(function(){
    var win = top.printLogPrint ? top : opener.top;
    win.printLogPrint(window);
});

</script>

</html>

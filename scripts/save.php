<?php
/*
 * Form save.php
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
require_once("$srcdir/forms.inc");

use OpenEMR\Common\Csrf\CsrfUtils;

if (!CsrfUtils::verifyCsrfToken($_POST["csrf_token_form"])) {
    CsrfUtils::csrfNotVerified();
}

/*
 * name of the database table associated with this form
 */
$table_name = "form_hypertension_risk_assessment";

if ($encounter == "") {
    $encounter = date("Ymd");
}
error_log('in save');
if ($_GET["mode"] == "new") {
    $newid = formSubmit($table_name, $_POST, $_GET["id"], $userauthorized);
    addForm($encounter, "Hypertension Risk Assessment", $newid, "hypertension_risk_assessment", $pid, $userauthorized);
} elseif ($_GET["mode"] == "update") {
    $success = formUpdate($table_name, $_POST, $_GET["id"], $userauthorized);
}
error_log('done save');
$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();

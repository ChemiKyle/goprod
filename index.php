<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/17/17
 * Time: 12:45 AM
 */
// large proj for testing 5749 , PID 9748 5292
// Call the REDCap Connect file in the main "redcap" directory

namespace Stanford\GoProd;

//require_once \ExternalModules\ExternalModules::getProjectHeaderPath();
/** @var \Stanford\GoProd\GoProd $module */



include_once APP_PATH_DOCROOT . "ProjectGeneral/header.php";

//$module = new GoProd();


//$test=$module->getSystemSetting("enabled");
//$test=$module->getConfig();
//print_dump($test);
//$enabled_rules = $module->getProjectSetting('enabled_rules')

/*global $rc_autoload_function;

require_once dirname(__FILE__) . "/Classes/Twilio.php";
// Reset the class autoload function because Twilio's classes changed it
spl_autoload_register($rc_autoload_function);
*/


if (!isset($project_id)) {
       die('Project ID is a required field');
    }

 //$temp_name = USERID;
// $users = \REDCap::getUsers();
/* if (!in_array($temp_name, $users)) {
       print "User does NOT have access to this project.";

 }*/

require_once 'classes/messages.php';
require_once 'classes/utilities.php';


// Check if user can create new records, if not Exit.
 //IsProjectAdmin();




//echo $_SERVER['DOCUMENT_ROOT'];
//echo APP_PATH_WEBROOT;
//echo redcap_info();

// Warning if project is in production mode
if ($status == 1) {
    echo lang('PRODUCTION_WARNING');
}
//REDCap Version Warning
if (\REDCap::versionCompare(REDCAP_VERSION, '7.3.0') < 0) {
    echo lang('VERSION_INFO');
}

?>

<link rel="stylesheet" href="<?php echo $module->getUrl("styles/go_prod_styles.css");?>">
    <div class="projhdr"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> <?php echo lang('TITLE'); ?> </div>
    <div id="main-container">
        <div> <span><?php echo lang('MAIN_TEXT');?></span> </div>
            <p></p>
        <button id="go_prod_go_btn" class="btn btn-md btn-primary btn-block">
            <span id="gp-run" ><?php echo lang('RUN');?></span>
            <span id="loader-count"></span>
            <span id="gp-extra-time" style="display: none" ><?php echo lang('LOADING_EXTRA_TIME');?> </span>
            <span id="gp-starting" style="display: none" ><?php echo lang('STARTING');?></span>
        </button>
        <div class="progress skill-bar ">
            <div class="progress-bar progress-bar-warning progress-bar-striped "  role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <table  id="go_prod_table" style="display: none"  class="table table-striped" >
                <thead id="go_prod_thead">
                    <tr>
                        <th>
                        </th>
                        <th>
                            <h4 class="projhdr"><?php echo lang('VALIDATION');?></h4>
                        </th>
                        <th width="100">
                            <h4 class="projhdr center"><?php echo lang('RESULT');?></h4>
                        </th>
                        <th width="100">
                            <h4 class="projhdr center"><?php echo lang('OPTIONS');?></h4>
                        </th>
                    </tr>
                </thead>
                 <!--RESULTS ARE LOADED HERE-->
                <tbody id="go_prod_tbody">
                </tbody>
        </table>
        <div id="gp-loader"  style="display: none"  >
            <div  class="loader"></div>
        </div>

    </div>

    <!--REUSABLE MODAL -->
    <div id="ResultsModal" class="modal fade">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <p><?php echo lang('LOADING');?></p>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!--Ajax calls -->
    <script>
      //psssing php variables
        var project_id=<?php echo $_GET['pid']; ?>;
        var geturl_ajax="<?php echo $module->getUrl('ajax_handler.php'); ?>";
    </script>
    <script type="text/javascript" src="<?php echo $module->getUrl("js/ajax_calls.js");?>"> </script>

<?php

/*Remove the go to production button if the project is already in production mode*/
if($status == 2 or USERID == 'alvaro1'){ //USERID == 'alvaro1' and

?>
    <div id='final-info' style="display: none">
        <br>
        <h4 class="projhdr"><?php echo lang('NOTICE');?></h4>
    <hr>
    <ul class="list-group col-md-6 col-sm-6 col-xs-12">
        <li class="list-group-item">
            <h4 class="list-group-item-heading"><?php echo lang('INFO_WHAT_NETX');?></h4>
            <p class="list-group-item-text"> <?php echo lang('INFO_WHAT_NETX_BODY');?></p>
            <br>
        </li>
        <br>
        <li class="list-group-item">
            <p class="list-group-item-text"><?php echo lang('INFO_WHAT_NETX_BODY_2');?></p>
        </li>
    </ul>
    <ul class="list-group col-md-6 col-sm-6 col-xs-12">
        <li class="list-group-item">
            <h4 class="list-group-item-heading"><?php echo lang('INFO_CITATION');?></h4>
            <p class="list-group-item-text"><?php echo lang('INFO_CITATION_BODY');?>  </p>
        </li>
        <br>
        <li class="list-group-item">
            <h4 class="list-group-item-heading"><?php echo lang('INFO_STATISTICIAN_REVIEW');?>  </h4>
            <p class="list-group-item-text"> <?php echo lang('INFO_STATISTICIAN_REVIEW_BODY');?> </p>
        </li>
    </ul>
    <div class="col-md-12 col-sm-6 col-xs-12 col-lg-12 text-center well" >
        <h4>
            <?php echo lang('I_AGREE_BODY');?>
        </h4> <br><button id="go_prod_accept_all" class=" btn btn-md btn-success text-center "> <?php echo lang('I_AGREE');?> </button>
    </div>
    </div>
    <script type="text/javascript">
        /*Auto Run the report if the  URL  variable is to_prod_plugin=2 */
        $( document ).ready(function() {

            ready_to_prod = <?php echo json_encode($_GET["to_prod_plugin"])?>;

            if (ready_to_prod === '2'){
                $('button[id="go_prod_go_btn"]').click();
            }
        });
    </script>
    <script type="text/javascript">

        document.getElementById("go_prod_accept_all").onclick = function () {
            production = <?php  echo json_encode(APP_PATH_WEBROOT.'ProjectSetup/index.php?pid='.$_GET['pid'].'&to_prod_plugin=1')?>;
            location.href = production;
        };
    </script>
    <?php
}
<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/14/17
 * Time: 12:23 PM
 */
// Call the REDCap Connect file in the main "redcap" directory
//require_once "../../../redcap_connect.php";

/*include_once "../../../external_modules/classes/ExternalModules.php";
include_once "../GoProd.php";

$goprod = new \Stanford\GoProd\GoProd();
$url = $goprod->getUrl("classes/");
require  $url.'messages.php';*/

  //echo '<pre>' . print_r($_SESSION["BranchingLogicErrors"], TRUE) . '</pre>';
namespace Stanford\GoProd;
?>

<!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>-->




<div class="panel panel-default" width="50%">
    <!-- Default panel contents -->
    <div class="panel-heading"><div class="projhdr"> <?php echo lang('BRANCHING_LOGIC_TITLE')?> </div>
    </div>
    <div class="panel-body">
    </div>
    <div >
        <table id="presence_of_branching_logic_data_table" class=" display " width="100%" cellspacing="0"></table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('CLOSE')?></button>
    </div>
</div>

<script>
    var result = sessionStorage.getItem("BranchingLogicErrors");
    dataSet =jQuery.parseJSON(result);
    cols =[
        { title: "Instrument" },
        { title: "Variable / Field Name" },
        { title: "Field Label" },
        { title: "Missing Variable" },
        { title: "Edit" }
    ];
    defs= [
        { "visible": false, "targets": 0 },
        {"className": "dt-center", "targets": 2},
        {"className": "dt-center", "targets": 3},
        { "width": "25px", "targets": 3}
    ];

    $(document).ready(function() {

        var table =  $('#presence_of_branching_logic_data_table').DataTable({

            "paging":         false,
            "searching": false,

            data: dataSet,
            columns:cols ,

            "columnDefs": defs,
            "order": [[ 0, 'asc' ]],
            "displayLength": 15,
            "drawCallback": function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;

                api.column(0, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="group"><td colspan="4"><h5><strong>Instrument: <u>'+group+'</u></strong></h5></td></tr>'

                        );

                        last = group;
                    }
                } );
            }
        } );


        // Order by the grouping
        $('#presence_of_branching_logic_data_table tbody').on( 'click', 'tr.group', function () {
                var currentOrder = table.order()[0];
                if ( currentOrder[0] === 0 && currentOrder[1] === 'asc' ) {
                    table.order( [ 0, 'desc' ] ).draw();
                }
                else {
                    table.order( [ 0, 'asc' ] ).draw();
                }
            }
        );
    } );

</script>


<?php

defined('BASEPATH') or exit('No direct script access allowed');

$dimensions = $pdf->getPageDimensions();

$info_right_column = '';
$info_left_column  = '';

$info_right_column .= '<span style="font-weight:bold;font-size:27px;">' . _l('scorecard_pdf_heading') . '</span><br />';
$info_right_column .= '<b style="color:#4e4e4e;"># ' . $scorecard_number . '</b>';

// Add logo
$info_left_column .= pdf_logo_url();
// Write top left logo and right column info/text
pdf_multi_row($info_left_column, $info_right_column, $pdf, ($dimensions['wk'] / 2) - $dimensions['lm']);

$pdf->ln(4);


foreach($staffs as $staff){
    // create some HTML content
    $pdf->ln(2);
    $html = "<h1>$staff->staff_name</h1>";

    // output the HTML content
    $pdf->writeHTML($html, true, 0, true, 0);

    $scorecard_staffs = $scorecard;
    $staff_data = [];
    $i = 1;
    $html_table = "";
    $rows = "";

        $tbl_po = '
            <table style="border: solid 1px #555; width: 100%;">
                <tr style="border: solid 1px #555; background-color:#0b1861;color:#f3f3f3;">
                    <th style="width:300";>Customer</th>
                    <th>Equipment</th>
                    <th style="width:50";>Task</th>
                    <th style="width:50";>R</th>
                    <th style="width:50";>L</th>
                    <th style="width:50";>P</th>
                    <th style="width:50";>C</th>
                </tr>';
                foreach($scorecard_staffs as $scorecard_staff){

                    if($scorecard_staff->staff_name == $staff->staff_name){
                        $rows = $scorecard_staff;

                        $pdf->writeHTML($html_table, true, 0, true, 0);

                        $tbl_po .= '<tr style="border: solid 1px #555;"><td style="border: solid 1px #555;">'. $scorecard_staff->company .'<div class="">'. $scorecard_staff->project_name. '</div>'. $scorecard_staff->start_date.'</td><td style="border: solid 1px #555;">'. $scorecard_staff->tag_name .'</td><td style="border: solid 1px #555;">'. $scorecard_staff->task .'</td><td style="border: solid 1px #555;">'. $scorecard_staff->task_status_4 .'</td><td style="border: solid 1px #555;">'. $scorecard_staff->task_status_3 .'</td><td style="border: solid 1px #555;">'. $scorecard_staff->task_status_2 .'</td><td style="border: solid 1px #555;">'. $scorecard_staff->task_status_5 .'</td></tr>';
                    }

                    $i++;

                }

        $tbl_po .= '</table>';
        
        $pdf->writeHTML($tbl_po, true, false, false, false, "");
}


$pdf->ln(4);

ob_end_clean();
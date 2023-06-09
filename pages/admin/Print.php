
<?php
require_once('../db/connect_db.php');
$id = $_GET['id'];
$Details = $store->get_Details($id);
$DateRelease = $store->getDateReleaseprint($id);


// $userdetails = $store->get_userdata();

// if(isset($userdetails)){
//   if($userdetails['access'] !="COE"){
//         header("Location: ../login.php");
//     }
// }else{
//     header("Location: ../login.php");
// }

$datenow = date('jS');
$datenow2 = date('F Y');

                $con = mysqli_connect('localhost','root','123456','coe_database');

                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

      $profile_id = $id;
      $date = date('Y-m-d');
      $datefor_rono = date('ymd');
      
        $sql = $con ->query("SELECT * FROM ro_no WHERE requestor_id = '$profile_id' ORDER BY id DESC");
        $row = $sql->fetch_array();

        $fullno = $row['no'];
        $no_assigned = $row['assigned_no'];

      ?>

<title>Print of Eligibility</title>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:288.0pt;line-height:12.0pt;font-size:15px;font-family:"Calibri",sans-serif;text-align:justify;text-indent:36.0pt;'><span style='font-size:12px;font-family:"Arial",sans-serif;'>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<strong>RO-<?php echo $fullno."-".$no_assigned;?></strong></span></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:288.0pt;line-height:12.0pt;font-size:15px;font-family:"Calibri",sans-serif;text-align:justify;text-indent:36.0pt;'><span style='font-size:12px;font-family:"Arial",sans-serif;'>&nbsp;</span></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:12.0pt;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>Republic of the Philippines</span></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:12.0pt;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>Civil Service Commission</span></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:12.0pt;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>Quezon City</span></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:12.0pt;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>&nbsp;</span></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:12.0pt;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><strong><span style='font-size:20px;font-family:"Times New Roman",serif;'>Certification of Eligibility</span></strong></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:11.0pt;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>This is to certify that</span></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:11.0pt;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>&nbsp;</span></p>
<table style="border-collapse:collapse;border:none;">
    <tbody>
        <tr>
            <td style="width: 512.5pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:11.0pt;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><strong><u><span style='font-size:16px;font-family:"Times New Roman",serif;'><?php echo strtoupper($Details['fname']." ".$Details['minitial']." ".$Details['lname']." ".$Details['suffix']);?></span></u></strong></p>
            </td>
        </tr>
        <tr>
            <td style="width: 512.5pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:11.0pt;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>&nbsp;</span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 512.5pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:12.0pt;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>has been granted<strong>&nbsp;</strong>a Civil Service Eligibility for passing/qualifying in the</span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 512.5pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:12.0pt;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><strong><u><span style='font-size:16px;font-family:"Times New Roman",serif;'><?php if($Details['type'] == NULL){echo "--";}else{echo $Details['type'];}?></span></u></strong></p>
            </td>
        </tr>
        <tr>
            <td style="width: 512.5pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:11.0pt;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>with a rating of&nbsp;</span><strong><u><span style='font-size:13px;font-family:"Times New Roman",serif;'><?php if($Details['rating'] == NULL){echo "--";}else{echo $Details['rating']."%";}?></span></u></strong><span style='font-size:13px;font-family:"Times New Roman",serif;'>&nbsp;</span><span style='font-size:13px;font-family:  "Arial",sans-serif;'>conducted by the Civil Service Commission</span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 512.5pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:11.0pt;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:12px;font-family:"Arial",sans-serif;'>in</span><strong><span style='font-size:13px;font-family:  "Times New Roman",serif;'>&nbsp;</span></strong><strong><u><span style='font-size:16px;font-family:"Times New Roman",serif;'><?php if($Details['place'] == NULL){echo "--";}else{echo $Details['place'];}?></span></u></strong><span style='font-size:16px;font-family:"Arial",sans-serif;'>&nbsp;</span><span style='font-size:12px;font-family:  "Arial",sans-serif;'>on&nbsp;</span><strong><u><span style='font-size:16px;font-family:"Times New Roman",serif;'><?php 
                if(isset($Details['date_exam']) && $Details['date_exam'] !="")
                {
                    $date_exam = date("F j,", strtotime($Details['date_exam']));
                }
                else {
                    $date_exam = "--";
                }
                echo $date_exam ; ?>&nbsp;</span></u></strong><strong><u><span style='font-size:16px;font-family:"Times New Roman",serif;'><?php 
                if(isset($Details['date_exam']) && $Details['date_exam'] !="")
                {
                    $date_exam = date("Y", strtotime($Details['date_exam']));
                }
                else {
                    $date_exam = "--";
                }
                echo $date_exam ; ?></span></u></strong><strong><span style='font-size:13px;font-family:  "Arial",sans-serif;'>.</span></strong></p>
            </td>
        </tr>
        <tr>
            <td style="width: 512.5pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:11.0pt;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:12px;font-family:"Arial",sans-serif;'>&nbsp;</span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 512.5pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:12.0pt;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>Issued upon the request of&nbsp;</span><strong><span style='font-size:13px;font-family:"Times New Roman",serif;'><?php if($Details['gender'] == 'Female'){echo "Ms.";}elseif($Details['gender']== 'Male'){echo "Mr.";}?></span></strong><strong><span style='font-size:13px;font-family:"Arial",sans-serif;'>&nbsp;</span></strong><strong><span style='font-size:13px;font-family:  "Times New Roman",serif;'><?php echo strtoupper($Details['lname']); ?>&nbsp;</span></strong><span style='font-size:13px;font-family:"Arial",sans-serif;'>this&nbsp;</span><strong><span style='font-size:13px;font-family:"Times New Roman",serif;'><?php echo $datenow ?></span></strong><strong><span style='font-size:13px;font-family:"Arial",sans-serif;'>&nbsp;</span></strong><span style='font-size:13px;font-family:"Arial",sans-serif;'>day<strong>&nbsp;</strong>of&nbsp;</span><strong><span style='font-size:13px;font-family:  "Times New Roman",serif;'><?php echo $datenow2."." ?></span></strong></p>
            </td>
        </tr>
    </tbody>
</table>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:7.0pt;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;'>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span></p>

<p style='margin-top:0cm;margin-right:12cm;margin-bottom:.0001pt;margin-left:0cm;line-height:12.0pt;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>&nbsp;</span></p>
<table style="float: left;border-collapse:collapse;border:none;margin-left:70pt;margin-right:6.75pt;">
    <tbody>
        <tr>
            <td style="width: 70.65pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style="font-size:12px;">Date of Birth</span></p>
            </td>
            <td style="width: 106.55pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri",sans-serif;'><strong><span style='font-size:12px;font-family:"Times New Roman",serif;'><?php 
                if(isset($Details['birth_date']) && $Details['birth_date'] !="")
                {
                    $birth_date = date("F j, Y", strtotime($Details['birth_date']));
                }
                else {
                    $birth_date = "--";
                }
                echo $birth_date ; ?></span></strong></p>
            </td>
        </tr>
        <tr>
            <td style="width: 70.65pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style="font-size:12px;">Place of Birth</span></p>
            </td>
            <td style="width: 106.55pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri",sans-serif;'><strong><span style='font-size:11px;font-family:  "Times New Roman",serif;'><?php if($Details['place'] == NULL){echo "--";}else{echo $Details['place'];}?></span></strong></p>
            </td>
        </tr>
        <tr>
            <td style="width: 70.65pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style="font-size:12px;">Book Number</span></p>
            </td>
            <td style="width: 106.55pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri",sans-serif;'><strong><span style='font-size:12px;font-family:"Times New Roman",serif;'><?php if($Details['book_no'] == NULL){echo "--";}else{echo $Details['book_no'];}?></span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 70.65pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style="font-size:12px;">Page Number</span></p>
            </td>
            <td style="width: 106.55pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri",sans-serif;'><strong><span style='font-size:12px;font-family:"Times New Roman",serif;'><?php if($Details['page_no'] == NULL){echo "--";}else{echo $Details['page_no'];}?></span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 70.65pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style="font-size:12px;">SN/LN</span></p>
            </td>
            <td style="width: 106.55pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri",sans-serif;'><strong><span style='font-size:12px;font-family:"Times New Roman",serif;'><?php if($Details['sn_ln'] == NULL){echo "--";}else{echo $Details['sn_ln'];}?></span></strong></p>
            </td>
        </tr>
        <tr>
            <td style="width: 70.65pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style="font-size:12px;">EN/CN</span></p>
            </td>
            <td style="width: 106.55pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri",sans-serif;'><strong><span style='font-size:12px;font-family:"Times New Roman",serif;'><?php if($Details['en_cn'] == NULL){echo "--";}else{echo $Details['en_cn'];}?></span></strong></p>
            </td>
        </tr>
        <tr>
            <td style="width: 90pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style="font-size:12px;">Date of Released/Issued</span></p>
            </td>
            <td style="width: 106.55pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  12.0pt;font-size:15px;font-family:"Calibri",sans-serif;'><strong><span style='font-size:12px;font-family:"Times New Roman",serif;'><?php 
                if(isset($DateRelease['date_release']) && $DateRelease['date_release'] !="")
                {
                    $date_release = date("F j, Y", strtotime($DateRelease['date_release']));
                }
                else {
                    $date_release = "--";
                }
                echo $date_release ; ?></span></strong></p>
            </td>
        </tr>
    </tbody>
</table>
<table style="float: left;border-collapse:collapse;border:none;margin-left:6.75pt;margin-right:6.75pt;">
    <tbody>
        <tr>
            <td style="width: 162.8pt;padding: 0cm 5.4pt;height: 14.05pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:12.0pt;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'>By Authority of the Commission</p>
            </td>
        </tr>
        <tr>
            <td style="width: 162.8pt;padding: 0cm 5.4pt;height: 13.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  12.0pt;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>&nbsp;</span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 162.8pt;padding: 0cm 5.4pt;height: 14.05pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  12.0pt;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:13px;font-family:"Arial",sans-serif;'>&nbsp;</span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 162.8pt;padding: 0cm 5.4pt;height: 14.05pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:12.0pt;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><strong><span style='font-family:"Times New Roman",serif;'><?php echo strtoupper($Details['heads']) ?></span></strong></p>
            </td>
        </tr>
        <tr>
            <td style="width: 162.8pt;padding: 0cm 5.4pt;height: 13.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:12.0pt;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-family:  "Times New Roman",serif;'><?php echo $Details['position'] ?></span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 162.8pt;padding: 0cm 5.4pt;height: 14.05pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:12.0pt;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-family:  "Times New Roman",serif;'>CSC for BARMM</span></p>
            </td>
        </tr>
    </tbody>
</table>
<table style="float: left;border-collapse:collapse;border:none;margin-left:50pt;margin-right:6.75pt;">
    <tbody>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td><br></td>
            <td bgcolor="white" style="border:.75pt solid white;vertical-align:top;background:white;">&nbsp;<table style="width: 100%">
                    <tbody>
                        <tr>
                            <td>
                                <div style="padding:4.35pt 7.95pt 4.35pt 7.95pt;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><strong><span style='font-size:11px;line-height:107%;font-family:"Times New Roman",serif;'>WARNING&nbsp;</span></strong><strong><span style='font-size:9px;line-height:107%;font-family:"Times New Roman",serif;'>:</span></strong><em><span style='font-size:9px;line-height:20%;font-family:"Times New Roman",serif;'>&nbsp; &nbsp; &nbsp; Illegal use of this certification shall subject the owner and/or perpetrator to administrative sanction and/or criminal prosecution &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span></em></p>
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:10;font-size:15px;font-family:"Calibri",sans-serif;'><em><span style='font-size:9px;line-height:107%;font-family:"Times New Roman",serif;'>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; under RA 9416. Any alteration, erasure, or absence of the official dry seal of the Commission shall invalidate this certification.&nbsp;</span></em></p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>&nbsp;&nbsp;</td>
        </tr>
    </tbody>
</table>
<p>&nbsp;</p>
<p><br></p>
<p><br></p>

<script>
  window.addEventListener("load", window.print());

</script>
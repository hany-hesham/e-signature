<?php
		function getbyroom($rn, $hid){
			if ($hid  == 3){
				$server = "172.50.10.230";
			}elseif ($hid  == 2){
				$server = "172.50.10.231";
			}elseif ($hid  == 1){
				$server = "172.50.10.232";
			}elseif ($hid  == 6){
				$server = "192.168.1.230";
			}elseif ($hid  == 4){
				$server = "196.168.2.18";
			}elseif ($hid  == 8){
				$server = "192.168.236.230";
			}elseif ($hid  == 11){
				$server = "10.15.15.18";
			}elseif ($hid  == 10){
				$server = "192.168.50.18";
			}elseif ($hid  == 12){
				$server = "10.15.15.20";
			}elseif ($hid  == 5){
				$server = "10.20.20.18";
			}elseif ($hid  == 7){
				$server = "192.168.210.230";
			}elseif ($hid  == 42){
				$server = "172.50.200.10";
			}
            $dbuser = "v8live";
            $dbpass = "live";
            $dbs = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = ".$server.")(PORT = 1521)))(CONNECT_DATA=(SID=v8)))";
            $connect = oci_connect ($dbuser, $dbpass, $dbs,'UTF8',OCI_DEFAULT );
            $sql = "SELECT V8_MAILING_CUSTOMERS_COMM.TELEPHONE, V8_MAILING_CUSTOMERS_COMM.EMAIL, ACT_REP_YRES_INFOS.YDET_ADULTNO, ACT_REP_YRES_INFOS.TOTALKIDS_G1, ACT_REP_YRES_INFOS.TOTALKIDS_G2, ACT_REP_YRES_INFOS.TOTALKIDS_G3, ACT_REP_YRES_INFOS.TRAVELAGENT_NAME, ACT_REP_YRES_INFOS.COMPANY_NAME, ACT_REP_YRES_INFOS.GUEST_NAME, ACT_REP_YRES_INFOS.CHECKED_IN, ACT_REP_YRES_INFOS.CHECKED_OUT, ACT_REP_YRES_INFOS.YRMS_SHORTDESC, ACT_REP_YRES_INFOS.YRES_ACTARRTIME, ACT_REP_YRES_INFOS.YRES_EXPDEPTIME, ACT_REP_YRES_INFOS.XCOU_LONGDESC FROM ACT_REP_YRES_INFOS JOIN V8_MAILING_CUSTOMERS_COMM on ACT_REP_YRES_INFOS.YRES_XCMS_ID = V8_MAILING_CUSTOMERS_COMM.XCMS_ID  WHERE /*ACT_REP_YRES_INFOS.CHECKED_IN ='1' AND ACT_REP_YRES_INFOS.CHECKED_OUT = '0' AND*/ ACT_REP_YRES_INFOS.YRMS_SHORTDESC=".$rn;
            $querys = oci_parse($connect,$sql);
            oci_execute($querys);
            // $num_rows = oci_fetch_assoc($querys);
            while (false !== ($row = oci_fetch_assoc($querys))) {
            $output_array[] = array('room' => $row['YRMS_SHORTDESC'], 'CHECKED_IN' => $row['CHECKED_IN'], 'CHECKED_OUT' => $row['CHECKED_OUT'],  'email' => $row['EMAIL'], 'tel' => $row['TELEPHONE'], 'agent' => $row['TRAVELAGENT_NAME'], 'company' => $row['COMPANY_NAME'], 'arriv' => $row['YRES_ACTARRTIME'], 'depart' => $row['YRES_EXPDEPTIME'], 'nation' => $row['XCOU_LONGDESC'], 'guest_name' => $row['GUEST_NAME'], 'no_pax' => $row['YDET_ADULTNO'], 'no_child1' => $row['TOTALKIDS_G1'], 'no_child2' => $row['TOTALKIDS_G2'], 'no_child3' => $row['TOTALKIDS_G3']);
            }
            // die(print_r($output_array));
            oci_free_statement($querys);
            oci_close($connect);
            return $output_array;
    	}
    ?>
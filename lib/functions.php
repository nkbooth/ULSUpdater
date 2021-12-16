<?php

function extractZip($filename) {
    $names = array('counts', 'AM.dat', 'CO.dat', 'EN.dat', 'HD.dat', 'HS.dat', 'LA.dat', 'SC.dat', 'SF.dat');
    $basename = explode('.', $filename);
    $basename = $basename[0];

    $zip = new ZipArchive();
    $res = $zip->open($filename);

    if ($res === TRUE) {
        foreach ($names as $name) {
            if ($zip->locateName($name, ZipArchive::FL_NOCASE) !== false) {
                echo ('Writing file ' . $name . "\n");
                $zip->extractTo('./', $name);
                if (rename($name, $basename . '-' . $name)) {
                    echo('-Renamed ' . $name . ' to ' . $basename . '-' . $name . "\n");
                } else {
                    echo('Failed to rename files, exiting.');
                    exit();
                }
            }
            else {
                echo('Unable to find ' . $name . ', continuing...' . "\n");
            }
        }
        $zip->close();
        echo('Extraction of ' . $basename . ' successful.' . "\n");
    } else {
        echo('Could not extract ' . $basename . '.  Stopping process.');
        exit();
    }
}

function processFiles($base, $licenseDB, $applicationDB) {
    $names = array('AM', 'CO', 'EN', 'HD', 'HS', 'LA', 'SC', 'SF');
    
    if($base == 'l_amat' || $base == 'l_am_mon' || $base == 'l_am_tue' || $base == 'l_am_wed' || $base == 'l_am_thu' || $base == 'l_am_fri' || $base == 'l_am_sat') {
        $db = $licenseDB;
    } elseif ($base == 'a_amat' || $base == 'a_am_mon' || $base == 'a_am_tue' || $base == 'a_am_wed' || $base == 'a_am_thu' || $base == 'a_am_fri' || $base == 'a_am_sat') {
       $db = $applicationDB;
    }

    $inquiries = new sqlInquiries;
    $inquiries->createAMTemp($db);
    $inquiries->createCOTemp($db);
    $inquiries->createENTemp($db);
    $inquiries->createHDTemp($db);
    $inquiries->createHSTemp($db);
    $inquiries->createLATemp($db);
    $inquiries->createSCTemp($db);
    $inquiries->createSFTemp($db);    

    $insertAMSQL = $db->prepare($inquiries->amTempInserter);
    $insertCOSQL = $db->prepare($inquiries->coTempInserter);
    $insertENSQL = $db->prepare($inquiries->enTempInserter);
    $insertHDSQL = $db->prepare($inquiries->hdTempInserter);
    $insertHSSQL = $db->prepare($inquiries->hsTempInserter);
    $insertLASQL = $db->prepare($inquiries->laTempInserter);
    $insertSCSQL = $db->prepare($inquiries->scTempInserter);
    $insertSFSQL = $db->prepare($inquiries->sfTempInserter);


    foreach ($names as $name){

        if(file_exists($base.'-'.$name.'.dat')) {
            echo ('- Processing ' . $name . '.dat.' . "\n");
            $fhorig = fopen($base . '-' . $name . '.dat', 'r');
            $count = 1;
            while ($line = fgets($fhorig)) {
                $importer = explode("|", $line);
                switch ($name) {
                    case "AM":
                        if(count($importer) == 18) {
                            $insertAMSQL->bind_param("sisssssissssssssss", ...$importer);                    
                            $insertAMSQL->execute();
                            if($db->error){
                                error_log("Error inserting row $count to AM temp: ".$db->error);
                            }
                        } else {
                            error_log("Error inserting row $count to AM temp table - incorrect number of fields detected");
                        }
                        $count++;
                        break;

                    case "CO":
                        if(count($importer)==8){
                            $insertCOSQL->bind_param("ssssssss", ...$importer);
                            $insertCOSQL->execute();
    
                            if($db->error !== ""){
                                error_log("Error inserting row $count to CO temp: ".$db->error);
                            }
                        } else {
                            error_log("Error inserting row $count into CO table - incorrect number of fields detected.");
                        }
                        $count++;
                        break;
                    case "EN":
                        if(count($importer) == 30){
                            $insertENSQL->bind_param("sissssssssssssssssssssssssssis", ...$importer);
                            $insertENSQL->execute();
                            if($db->error){
                                error_log("Error importing line $count to EN staging database: ".$db->error);
                            }
                        } else {
                            error_log("Error importing line $count to EN database - incorrect number of fields detected.");
                        }
                        $count++;
                        break;
                    case "HD":
                        if(count($importer) == 59){
                            $insertHDSQL->bind_param("sissssssssssssssssssssssssssssssssssssssssssissssssssssssss", ...$importer);
                            $insertHDSQL->execute();
                            if($db->error){
                                error_log("Error importing line $count to HD staging database: ".$db->error);
                            }
                        } else {
                            error_log("Error importing row $count into HD table - incorrect number of fields detected.");
                        }
                        $count++;
                        break;
                    case "HS":
                        if(count($importer) == 6){
                            $insertHSSQL->bind_param("sissss", ...$importer);
                            $insertHSSQL->execute();
                            if($db->error){
                                error_log("Error importing line $count to HS staging database: ".$db->error);
                            }
                        } else {
                            error_log("Error importing line $count into HS temporary table - incorrect number of fields detected.");
                        }
                        $count++;
                        break;
                    case "LA":
                        if(count($importer) == 8){
                            $insertLASQL->bind_param("sissssss", ...$importer);
                            $insertLASQL->execute();
                            if($db->error){
                                error_log("Error importing line $count to LA staging database: ".$db->error);
                            }
                        } else {
                            error_log("Error importing line $count into LA temporary table - incorrect number of fields detected.");
                        }
                        $count++;
                        break;
                    case "SC":
                        if(count($importer) == 9){
                            $insertSCSQL->bind_param("sisssssss", ...$importer);
                            $insertSCSQL->execute();
                            if($db->error){
                                error_log("Error importing line $count to SC staging database: ".$db->error);
                            }
                        } else {
                            error_log("Error inserting line $count into SC temporary table - incorrect number of fields detected.");
                        }
                        $count++;
                        break;
                    case "SF":
                        if (count($importer) == 11){
                            $insertSFSQL->bind_param("sissssiisss", ...$importer);
                            $insertSFSQL->execute();
                            if($db->error){
                                error_log("Error importing line $count to SF staging database: ".$db->error);
                            }
                        } else {
                            error_log("Error importing line $count into SF temporary table - incorrect number of fields detected.");
                        }
                        $count++;
                        break;
                }
            }
            fclose($fhorig);
            
            switch($name){
                case "AM":
                    $insertAMSQL->close();
                    mysqli_query($db, $inquiries->amUpdater);
                    if(!$db->error){
                        echo "- Imported AM table: ".$db->info.PHP_EOL;
                    } else {
                        error_log("Error importing AM table: ".$db->error,0);
                    }
                    break;
                case "CO":
                    $insertCOSQL->close();
                    $inquiries->COCleanup($db);
                    mysqli_query($db, $inquiries->coUpdater);
                    if($db->error){
                        error_log("Error storing CO table: ".$db->error);
                    }
                    else {
                        echo "- Imported CO table: ".$db->info.PHP_EOL;
                    }
                    break;
                case "EN":
                    $insertENSQL->close();
                    $inquiries->enInsert($db);
                    if($db->error){
                        error_log("Error storing EN table: ".$db->error);
                    }
                    else {
                        echo "- Imported EN table: ".$db->info.PHP_EOL;
                    }
                    break;
                case "HD":
                    $insertHDSQL->close();
                    $inquiries->hdInsert($db); 
                    break;
                case "HS":
                    $insertHSSQL->close();
                    $inquiries->hsInsert($db);
                    break;
                case "LA":
                    $insertLASQL->close();
                    $inquiries->laInsert($db);
                    break;
                case "SC":
                    $insertSCSQL->close();
                    $inquiries->scInsert($db);                     
                    break;
                case "SF":
                    $insertSFSQL->close();
                    $inquiries->sfInsert($db);
                    break;
            }
        }
    }
}


function downloadFile($url) {
    $filename = explode("/", $url);
    $filename = array_pop($filename);

    // Let's check to see what the filesize is, if not different, we won't re-download
    if (file_exists($filename)) {
        echo 'Checking local file ' . $filename . "\n";
        $cur_file = stat($filename);
        $head = array_change_key_case(get_headers($url, TRUE));
        $filesize = $head['content-length'];

        if ($filesize == $cur_file["size"]) {
            echo 'Local file is same as remote file, not downloading again.' . "\n";
            return;
        }
    }

    echo "Downloading " . $filename . "\n";

    $ctx = stream_context_create();
    stream_context_set_params($ctx, array("notification" => "stream_notification_callback"));

    $fp = fopen($url, "r", false, $ctx);
    if (is_resource($fp) && file_put_contents($filename, $fp)) {
        echo " Done!\n";
    }
}


function stream_notification_callback($notification_code, $severity, $message, $message_code, $bytes_transferred, $bytes_max) {
    static $filesize = null;

    switch ($notification_code) {
        case STREAM_NOTIFY_RESOLVE :
        case STREAM_NOTIFY_AUTH_REQUIRED :
        case STREAM_NOTIFY_COMPLETED :
        case STREAM_NOTIFY_FAILURE :
        case STREAM_NOTIFY_AUTH_RESULT :
        case STREAM_NOTIFY_MIME_TYPE_IS :
        case STREAM_NOTIFY_CONNECT:
            /* Ignore */
            break;

        case STREAM_NOTIFY_REDIRECTED :
            echo "Being redirected to: ", $message, "\n";
            break;

        case STREAM_NOTIFY_FILE_SIZE_IS :
            $filesize = $bytes_max;
            echo "Filesize: ", $filesize, "\n";
            break;

        case STREAM_NOTIFY_PROGRESS :
            if ($bytes_transferred > 0) {
                if (!isset($filesize)) {
                    printf("\rUnknown filesize.. %2d kb done..", $bytes_transferred / 1024);
                } else {
                    $length = (int) (($bytes_transferred / $filesize) * 100);
                    printf("\r[%-100s] %d%% (%2d/%2d kb)", str_repeat("=", $length) . ">", $length, ($bytes_transferred / 1024), $filesize / 1024);
                }
            }
            break;
    }
}

function getFileContents($base, $name) {
    $data = file_get_contents($base.'-'.$name.'-new.dat');
        $fp = fopen("php://temp",'r+');
        fputs($fp, $data);
        rewind($fp);
        $importer = [];
        while (($csv = fgetcsv($fp,0,"|")) !== FALSE) {
            $importer[] = $csv;
        }
        fclose($fp);

        return $importer;
}

function cleanupFiles($baseFileName){
    unlink($baseFileName.'.zip');
    unlink($baseFileName.'-counts');

    $names = array('AM', 'CO', 'EN', 'HD', 'HS', 'LA', 'SC', 'SF');
    foreach($names as $fileName){
        if(file_exists($baseFileName.'-'.$fileName.'.dat')){
            unlink($baseFileName.'-'.$fileName.'.dat');
            echo "Removed $baseFileName-$fileName.dat\n";
        }
        if(file_exists($baseFileName.'-'.$fileName.'-new.dat')){
            unlink($baseFileName.'-'.$fileName.'-new.dat');
            echo "Removed $baseFileName-$fileName-new.dat\n";
        }
    }
}

class sqlInquiries {
    public $amTempInserter = "INSERT INTO AM_TEMP (record_type, unique_system_identifier, uls_file_num, ebf_number, callsign, operator_class, group_code, region_code, trustee_callsign, trustee_indicator, physician_certification, ve_signature, systematic_callsign_change, vanity_callsign_change, vanity_relationship, previous_callsign, previous_operator_class, trustee_name) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
    public $amUpdater = "REPLACE INTO PUBACC_AM (record_type, unique_system_identifier, uls_file_num, ebf_number, callsign, operator_class, group_code, region_code, trustee_callsign, trustee_indicator, physician_certification, ve_signature, systematic_callsign_change, vanity_callsign_change, vanity_relationship, previous_callsign, previous_operator_class, trustee_name) SELECT * FROM AM_TEMP;";
    public $coTempInserter = "INSERT INTO CO_TEMP (record_type, unique_system_identifier, uls_file_num, callsign, comment_date, description, status_code, status_date) VALUES (?,?,?,?,?,?,?,?);";
    public $coUpdater = "REPLACE INTO PUBACC_CO (record_type, unique_system_identifier, uls_file_num, callsign, comment_date, description, status_code, status_date) SELECT record_type, unique_system_identifier, uls_file_num, callsign, STR_TO_DATE(comment_date, '%m/%e/%Y'), description, status_code, STR_TO_DATE(status_date, '%m/%e/%Y') FROM CO_TEMP;";
    public $enTempInserter = "INSERT INTO EN_TEMP (record_type,unique_system_identifier,uls_file_number,ebf_number,call_sign,entity_type,licensee_id,entity_name,first_name,mi,last_name,suffix,phone,fax,email,street_address,city,state,zip_code,po_box,attention_line,sgin,frn,applicant_type_code,applicant_type_other,status_code,status_date,lic_category_code,linked_license_id,linked_callsign) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
    public $hdTempInserter = "INSERT INTO HD_TEMP (record_type, unique_system_identifier, uls_file_number, ebf_number, call_sign , license_status, radio_service_code, grant_date, expired_date, cancellation_date, eligibility_rule_num, applicant_type_code_reserved, alien, alien_government, alien_corporation, alien_officer, alien_control, revoked, convicted, adjudged, involved_reserved, common_carrier, non_common_carrier, private_comm, fixed, mobile, radiolocation, satellite, developmental_or_sta, interconnected_service, certifier_first_name, certifier_mi, certifier_last_name, certifier_suffix, certifier_title, gender, african_american, native_american, hawaiian, asian, white, ethnicity, effective_date, last_action_date, auction_id, reg_stat_broad_serv, band_manager, type_serv_broad_serv, alien_ruling, licensee_name_change, whitespace_ind, additional_cert_choice, additional_cert_answer, discontinuation_ind, regulatory_compliance_ind, eligibility_cert_900, transition_plan_cert_900, return_spectrum_cert_900, payment_cert_900) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    public $hsTempInserter = "INSERT INTO HS_TEMP (record_type, unique_system_identifier, uls_file_number, callsign, log_date, code) VALUES (?,?,?,?,?,?);";
    public $laTempInserter = "INSERT INTO LA_TEMP (record_type, unique_system_identifier, callsign, attachment_code, attachment_desc, attachment_date, attachment_filename, action_performed) VALUES (?,?,?,?,?,?,?,?);";
    public $scTempInserter = "INSERT INTO SC_TEMP (record_type, unique_system_identifier, uls_file_number, ebf_number, callsign, special_condition_type, special_condition_code, status_code, status_date) VALUES (?,?,?,?,?,?,?,?,?);";
    public $sfTempInserter = "INSERT INTO SF_TEMP (record_type, unique_system_identifier, uls_file_number, ebf_number, callsign, lic_freeform_cond_type, unique_lic_freeform_id, sequence_number, lic_freeform_condition, status_code, status_date) VALUES (?,?,?,?,?,?,?,?,?,?,?);";

    function createAMTemp($con){
        mysqli_query($con, "CREATE TEMPORARY TABLE AM_TEMP LIKE PUBACC_AM;");
    }
    function createCOTemp($con){
        mysqli_query($con, "CREATE TEMPORARY TABLE CO_TEMP (record_type varchar(2), unique_system_identifier varchar(9), uls_file_num varchar(14), callsign varchar(12), comment_date varchar(10), description varchar(512), status_code varchar(2), status_date varchar(10));");
        if ($con->error){
            error_log("Error creating CO temporary table: ".$con->error,0);
        }
    }
    function COCleanup($con){
        mysqli_query($con, "DELETE FROM CO_TEMP WHERE unique_system_identifier = ''");
    }

    function enInsert($con){
        mysqli_query($con, "REPLACE INTO PUBACC_EN (record_type, unique_system_identifier, uls_file_number, ebf_number, call_sign, entity_type, licensee_id, entity_name, first_name, mi, last_name, suffix, phone, fax, email, street_address, city, state, zip_code, po_box, attention_line, sgin, frn, applicant_type_code, applicant_type_other, status_code, status_date, lic_category_code, linked_license_id, linked_callsign) SELECT record_type, unique_system_identifier, uls_file_number, ebf_number, call_sign, entity_type, licensee_id, entity_name, first_name, mi, last_name, suffix, phone, fax, email, street_address, city, state, zip_code, po_box, attention_line, sgin, frn, applicant_type_code, applicant_type_other, status_code, STR_TO_DATE(status_date, '%m/%e/%Y'), lic_category_code, linked_license_id, linked_callsign FROM EN_TEMP;");
    }

    

    function createENTemp($con){
        mysqli_query($con, "CREATE TEMPORARY TABLE EN_TEMP (record_type varchar(255),unique_system_identifier int, uls_file_number varchar(50), ebf_number varchar(50), call_sign varchar(15), entity_type varchar(10), licensee_id varchar(15), entity_name varchar(255), first_name varchar(50), mi varchar(10),last_name varchar(255), suffix varchar(255), phone varchar(15), fax varchar(15), email varchar(50), street_address varchar(255), city varchar(255), state varchar(10), zip_code varchar(20), po_box varchar(20), attention_line varchar(50), sgin varchar(5), frn varchar(15), applicant_type_code char(1), applicant_type_other varchar(50), status_code char(1), status_date varchar(15), lic_category_code char(1),linked_license_id int,linked_callsign varchar(15));");
        if($con->error){
            error_log("Error creating EN temporary table: ".$con->error);
        }
    }

    function createHDTemp($con){
        mysqli_query($con, "CREATE TEMPORARY TABLE HD_TEMP (record_type varchar(5), unique_system_identifier int, uls_file_number varchar(50), ebf_number varchar(50), call_sign varchar(15), license_status varchar(5), radio_service_code varchar(5), grant_date varchar(15), expired_date varchar(15), cancellation_date varchar(15), eligibility_rule_num varchar(15), applicant_type_code_reserved varchar(5), alien varchar(5), alien_government varchar(5), alien_corporation varchar(5), alien_officer varchar(5), alien_control varchar(5), revoked varchar(5), convicted varchar(5), adjudged varchar(5), involved_reserved varchar(5), common_carrier varchar(5), non_common_carrier varchar(5), private_comm varchar(5), fixed varchar(5), mobile varchar(5), radiolocation varchar(5), satellite varchar(5), developmental_or_sta varchar(5), interconnected_service varchar(5), certifier_first_name varchar(255), certifier_mi varchar(5), certifier_last_name varchar(255), certifier_suffix varchar(10), certifier_title varchar(50), gender varchar(5), african_american varchar(5), native_american varchar(5), hawaiian varchar(5), asian varchar(5), white varchar(5), ethnicity varchar(5), effective_date varchar(15), last_action_date varchar(15), auction_id int, reg_stat_broad_serv varchar(5), band_manager varchar(5), type_serv_broad_serv varchar(5), alien_ruling varchar(5), licensee_name_change varchar(5), whitespace_ind varchar(5), additional_cert_choice varchar(5), additional_cert_answer varchar(5), discontinuation_ind varchar(5), regulatory_compliance_ind varchar(5), eligibility_cert_900 varchar(5), transition_plan_cert_900 varchar(5), return_spectrum_cert_900 varchar(5), payment_cert_900 varchar(5));");
        if($con->error){
            error_log("Error creating HD temporary table: ".$con->error);
        }
    }

    function hdInsert($con){
        mysqli_query($con, "REPLACE INTO PUBACC_HD (record_type, unique_system_identifier, uls_file_number, ebf_number, call_sign , license_status, radio_service_code, grant_date, expired_date, cancellation_date, eligibility_rule_num, applicant_type_code_reserved, alien, alien_government, alien_corporation, alien_officer, alien_control, revoked, convicted, adjudged, involved_reserved, common_carrier, non_common_carrier, private_comm, fixed, mobile, radiolocation, satellite, developmental_or_sta, interconnected_service, certifier_first_name, certifier_mi, certifier_last_name, certifier_suffix, certifier_title, gender, african_american, native_american, hawaiian, asian, white, ethnicity, effective_date, last_action_date, auction_id, reg_stat_broad_serv, band_manager, type_serv_broad_serv, alien_ruling, licensee_name_change, whitespace_ind, additional_cert_choice, additional_cert_answer, discontinuation_ind, regulatory_compliance_ind, eligibility_cert_900, transition_plan_cert_900, return_spectrum_cert_900, payment_cert_900) SELECT record_type, unique_system_identifier, uls_file_number, ebf_number, call_sign , license_status, radio_service_code, STR_TO_DATE(grant_date, '%m/%e/%Y'), STR_TO_DATE(expired_date, '%m/%e/%Y'), STR_TO_DATE(cancellation_date, '%m/%e/%Y'), eligibility_rule_num, applicant_type_code_reserved, alien, alien_government, alien_corporation, alien_officer, alien_control, revoked, convicted, adjudged, involved_reserved, common_carrier, non_common_carrier, private_comm, fixed, mobile, radiolocation, satellite, developmental_or_sta, interconnected_service, certifier_first_name, certifier_mi, certifier_last_name, certifier_suffix, certifier_title, gender, african_american, native_american, hawaiian, asian, white, ethnicity, STR_TO_DATE(effective_date, '%m/%e/%Y'), STR_TO_DATE(last_action_date, '%m/%e/%Y'), auction_id, reg_stat_broad_serv, band_manager, type_serv_broad_serv, alien_ruling, licensee_name_change, whitespace_ind, additional_cert_choice, additional_cert_answer, discontinuation_ind, regulatory_compliance_ind, eligibility_cert_900, transition_plan_cert_900, return_spectrum_cert_900, payment_cert_900 FROM HD_TEMP;");
        if($con->error){
            error_log("Error updating HD table: ".$con->error);
        }
    }

    function createHSTemp($con) {
        mysqli_query($con, "CREATE TEMPORARY TABLE HS_TEMP (record_type varchar(10), unique_system_identifier int, uls_file_number varchar(255), callsign varchar(255), log_date varchar(255), code varchar(255));");
        if($con->error){
            error_log("Error creating HS temporary table: ".$con->error);
        }
    }

    function hsInsert($con){
        mysqli_query($con, "REPLACE INTO PUBACC_HS (record_type, unique_system_identifier, uls_file_number, callsign, log_date, code) SELECT record_type, unique_system_identifier, uls_file_number, callsign, STR_TO_DATE(log_date, '%m/%e/%Y'), code FROM HS_TEMP");
        if($con->error){
            error_log("Error storing HS table: ".$con->error);
        }
        else {
            echo "- Imported HS table: ".$con->info.PHP_EOL;
        }
    }

    function createLATemp($con) {
        mysqli_query($con, "CREATE TEMPORARY TABLE LA_TEMP (record_type varchar(5), unique_system_identifier int, callsign varchar(15), attachment_code varchar(5), attachment_desc varchar(512), attachment_date varchar(512), attachment_filename varchar(512), action_performed varchar(512));");
        if($con->error){
            error_log("Error creating LA temporary table: ".$con->error);
        }
    }

    function laInsert($con){
        mysqli_query($con, "REPLACE INTO PUBACC_LA (record_type, unique_system_identifier, callsign, attachment_code, attachment_desc, attachment_date, attachment_filename, action_performed) SELECT record_type, unique_system_identifier, callsign, attachment_code, attachment_desc, STR_TO_DATE(attachment_date, '%m/%e/%Y'), attachment_filename, action_performed from LA_TEMP;");
        if($con->error){
            error_log("Error storing LA table: ".$con->error);
        }
        else {
            echo "- Imported LA table: ".$con->info.PHP_EOL;
        }
    }

    function createSCTemp($con){
        mysqli_query($con, "CREATE TEMPORARY TABLE SC_TEMP (record_type varchar(5), unique_system_identifier int, uls_file_number varchar(15), ebf_number varchar(255), callsign varchar(255), special_condition_type varchar(255), special_condition_code varchar(255), status_code varchar(255), status_date varchar(255));");
        if($con->error){
            error_log("Error creating SC temporary table: ".$con->error);
        }
    }

    function scInsert($con){
        mysqli_query($con, "REPLACE INTO PUBACC_SC (record_type, unique_system_identifier, uls_file_number, ebf_number, callsign, special_condition_type, special_condition_code, status_code, status_date) SELECT record_type, unique_system_identifier, uls_file_number, ebf_number, callsign, special_condition_type, special_condition_code, status_code, STR_TO_DATE(status_date, '%e/%m/%Y') FROM SC_TEMP;");
        if($con->error){
            error_log("Error storing SC table: ".$con->error);
        }
        else {
            echo "- Imported SC table: ".$con->info.PHP_EOL;
        }
    }

    function createSFTemp($con){
        mysqli_query($con, "CREATE TEMPORARY TABLE SF_TEMP (record_type varchar(5), unique_system_identifier int, uls_file_number varchar(255), ebf_number varchar(255), callsign varchar(255), lic_freeform_cond_type varchar(5), unique_lic_freeform_id int, sequence_number int, lic_freeform_condition varchar(255), status_code varchar(255), status_date varchar(255));");
        if($con->error){
            error_log("Error creating SF table: ".$con->error);
        }
    }

    function sfInsert($con){
        mysqli_query($con, "REPLACE INTO PUBACC_SF (record_type, unique_system_identifier, uls_file_number, ebf_number, callsign, lic_freeform_cond_type, unique_lic_freeform_id, sequence_number, lic_freeform_condition, status_code, status_date) SELECT record_type, unique_system_identifier, uls_file_number, ebf_number, callsign, lic_freeform_cond_type, unique_lic_freeform_id, sequence_number, lic_freeform_condition, status_code, STR_TO_DATE(status_date, '%e/%m/%Y') FROM SF_TEMP;");
        if($con->error){
            error_log("Error storing SF table: ".$con->error);
        }
        else {
            echo "- Imported SF table: ".$con->info.PHP_EOL;
        }
    }
}


<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
require_once ("../shared/common.php");
$tab = "cataloging";
$nav = "upload_picture";

require_once ("../classes/Biblio.php");
require_once ("../classes/BiblioField.php");
require_once ("../classes/BiblioQuery.php");

require_once ("../functions/fileIOFuncs.php");
require_once ("../shared/logincheck.php");
require_once ("../classes/Localize.php");

$loc = new Localize(OBIB_LOCALE, $tab);

if (! isset($_REQUEST['posted'])) {
    require_once ("../shared/logincheck.php");
    # if (!isset($_REQUEST['bibid'])) {
    # header("Location: ../catalog/index.php");
    # exit();
    # }
} else {
    exit();
}

if (count($_FILES) == 0) {
    header("Location: upload_picture_form.php");
    exit();
}

include ("../shared/header.php");

# ****************************************************************************
# * Retrieving get var
# ****************************************************************************
$bibid = $_GET["bibid"];
if (isset($_GET["msg"])) {
    $msg = "<font class=\"error\">" . H($_GET["msg"]) . "</font><br><br>";
} else {
    $msg = "";
}

# ****************************************************************************
# * Search database
# ****************************************************************************
$biblioQ = new BiblioQuery();
$biblioQ->connect_e();
if ($biblioQ->errorOccurred()) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
}
if (! $biblio = $biblioQ->doQuery($bibid, $tab)) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
}
$biblioFlds = $biblio->getBiblioFields();

?>
<h1>
 <?php
if (isset($biblioFlds["245a"]))
    echo H($biblioFlds["245a"]->getFieldData());
?>
 </h1>
<?php

$uploaddir = '../pictures/';
$dateiname = basename($_FILES['picture_data']['name']);
$tmpname = basename($_FILES['picture_data']['tmp_name']);
$uploadfile = $uploaddir . $dateiname;

$validpic = true;
$mimetype = $_FILES['picture_data']['type'];
$validpic = $mimetype == "image/jpeg" || $mimetype == "image/gif" || $mimetype == "image/png";

if ($dateiname != "") {
    if ($tmpname != "") {

        // Überprüfung der Dateigröße
        $max_size = 500 * 1024; // 500 KB
        if ($_FILES['picture_data']['size'] > $max_size) {
            echo $loc->getText("PicUploadSize500"); // "Bitte keine Dateien größer 500kb hochladen. ";
            $validpic = false;
        }

        if (function_exists('exif_imagetype')) { // Die exif_imagetype-Funktion erfordert die exif-Erweiterung auf dem Server
            $allowed_types = array(
                IMAGETYPE_PNG,
                IMAGETYPE_JPEG,
                IMAGETYPE_GIF
            );
            $detected_type = exif_imagetype($_FILES['picture_data']['tmp_name']);
            if (! in_array($detected_type, $allowed_types)) {
                echo $loc->getText("PicUploadExifType"); // "Falscher Exif-Type!";
                $validpic = false;
            }
        } else {
            echo $loc->getText("PicUploadNoExif"); // "PHP-Exif-Erweiterung fehlt";
            $validpic = false;
        }

        if (! is_dir($uploaddir)) {
            echo $loc->getText("PicUploadNoDir"); // "Verzeichnis existiert nicht!";
            $validpic = false;
        }

        if ($validpic) {

            try {
                if (move_uploaded_file($_FILES['picture_data']['tmp_name'], $uploadfile)) {
                    echo $loc->getText("PicUploadPictureUploaded"); // "Datei ist valide und wurde erfolgreich hochgeladen.<br><br>";
                    ?>
<table class="primary">
	<tr>
		<td valign="top" class="primary"><img
			src="../pictures/<?php echo $dateiname;?>" width="150"></td>
	</tr>
</table>
<?php

                    # altes bild löschen
                    if (isset($biblioFlds["902a"])) {
                        $oldPic = $biblioFlds["902a"]->getFieldData();
                        if (file_exists("../pictures/" . $oldPic)) {
                            unlink("../pictures/" . $oldPic);
                        }
                        # jetzt dem Eintrag zuordnen
                        $biblioFlds["902a"]->setFieldData($dateiname);
                    } else {
                        # neuen Eintrag erzeugen
                        $biblioFld = new BiblioField();
                        $biblioFld->setBibid($bibid);
                        $biblioFld->setTag("902");
                        $biblioFld->setSubfieldCd("a");
                        $biblioFld->setFieldData($dateiname);
                        $biblio->addBiblioField("902a", $biblioFld);
                    }

                    if (! $biblioQ->update($biblio)) {
                        $biblioQ->close();
                        displayErrorPage($biblioQ);
                    }
                    $biblioQ->close();
                    ?>
<br>
<a href="../shared/biblio_view.php?bibid=<?php echo HURL($bibid);?>">
      <?php echo $loc->getText("PicUploadInfoMedium"); ?></a>
<br />
<?php
                } else {
                    echo $loc->getText("PicUploadAttack"); // "Möglicherweise eine Dateiupload-Attacke!\n";
                }
            } catch (RuntimeException $e) {
                echo $loc->getText("PicUploadFailed");
            }
        } else
            echo $loc->getText("PicUploadNoValidPicture"); // "Datei enthält kein gültiges Bild!\n";
    } else {
        echo $loc->getText("PicUploadNoTmp"); // Dateiname da, aber keine temporäre Datei
    }
} else {
    echo $loc->getText("PicUploadNoFile"); // "Keine Datei ausgewählt!";
}

include ("../shared/footer.php");
?>
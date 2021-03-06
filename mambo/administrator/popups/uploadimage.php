<?php
/**
* @version $Id: uploadimage.php,v 1.2 2004/10/11 03:36:33 dappa Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** Set flag that this is a parent file */
define( "_VALID_MOS", 1 );
/** security check */
require( "../includes/auth.php" );
include_once ( $mosConfig_absolute_path . '/language/' . $mosConfig_lang . '.php' );

$directory = mosGetParam( $_REQUEST, 'directory', '');

$userfile2=(isset($_FILES['userfile']['tmp_name']) ? $_FILES['userfile']['tmp_name'] : "");
$userfile_name=(isset($_FILES['userfile']['name']) ? $_FILES['userfile']['name'] : "");

if (isset($_FILES['userfile'])) {
	if ($directory!="banners") {
		$base_Dir = "../../images/stories/";
	} else {
		$base_Dir = "../../images/banners/";
	}
	if (empty($userfile_name)) {
		echo "<script>alert('".$adminLanguage->A_ALERT_IMAGE_UPLOAD."'); document.location.href='uploadimage.php';</script>";
	}

	$filename = split("\.", $userfile_name);

	if (eregi("[^0-9a-zA-Z_]", $filename[0])) {
		echo "<script> alert('".$adminLanguage->A_ALERT_ALPHA."'); window.history.go(-1);</script>\n";
		exit();
	}

	if (file_exists($base_Dir.$userfile_name)) {
		echo "<script> alert('".$adminLanguage->A_ALERT_IMAGE_EXISTS."'); window.history.go(-1);</script>\n";
		exit();
	}

	if ((strcasecmp(substr($userfile_name,-4),".gif")) && (strcasecmp(substr($userfile_name,-4),".jpg")) && (strcasecmp(substr($userfile_name,-4),".png")) && (strcasecmp(substr($userfile_name,-4),".bmp")) &&(strcasecmp(substr($userfile_name,-4),".doc")) && (strcasecmp(substr($userfile_name,-4),".xls")) && (strcasecmp(substr($userfile_name,-4),".ppt")) && (strcasecmp(substr($userfile_name,-4),".swf")) && (strcasecmp(substr($userfile_name,-4),".pdf"))) {
		echo "<script>alert('".$adminLanguage->A_ALERT_IMAGE_FILENAME."'); window.history.go(-1);</script>\n";
		exit();
	}


	if (eregi(".pdf", $userfile_name) || eregi(".doc", $userfile_name) || eregi(".xls", $userfile_name) || eregi(".ppt", $userfile_name)) {
		if (!move_uploaded_file ($_FILES['userfile']['tmp_name'],$media_path.$_FILES['userfile']['name']) || !chmod($media_path.$_FILES['userfile']['name'],0777)) {
			echo "<script>alert('".$adminLanguage->A_ALERT_UPLOAD_FAILED."'); window.history.go(-1);</script>\n";
			exit();
		}
		else {
			echo "<script>alert('".$adminLanguage->A_ALERT_UPLOAD_SUC."'); window.history.go(-1);</script>\n";
			exit();
		}
	} elseif (!move_uploaded_file ($_FILES['userfile']['tmp_name'],$base_Dir.$_FILES['userfile']['name']) || !chmod($base_Dir.$_FILES['userfile']['name'],0777)) {
		echo "<script>alert('".$adminLanguage->A_ALERT_UPLOAD_FAILED."'); window.history.go(-1);</script>\n";
		exit();
	}
	else {
		echo "<script>alert('".$adminLanguage->A_ALERT_UPLOAD_SUC2."'); window.history.go(-1);</script>\n";
		exit();
	}


}

$iso = split( '=', _ISO );
// xml prolog
echo '<?xml version="1.0" encoding="'. $iso[1] .'"?' .'>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $adminLanguage->A_TITLE_UPLOAD;?></title>
</head>
<body>
<?php
$css = mosGetParam($_REQUEST,"t","");
?>
<link rel="stylesheet" href="../templates/<?php echo $css.(!$adminLanguage->RTLsupport ? '/css/template_css.css' : '/css/template_css_rtl.css'); ?>" type="text/css" /> <!-- rtl change -->
<table class="adminform">
  <form method="post" action="uploadimage.php" enctype="multipart/form-data" name="filename">
    <tr>
      <th class="title"> <?php echo $adminLanguage->A_FILE_UPLOAD;?> : <?php echo $directory; ?></th>
    </tr>
    <tr>
      <td align="center">
        <input class="inputbox" name="userfile" type="file" />
      </td>
    </tr>
    <tr>
      <td>
        <input class="button" type="submit" value="<?php echo $adminLanguage->A_UPLOAD;?>" name="fileupload" />
      </td>
    <tr>
      <td>
        <input type="hidden" name="directory" value="<?php echo $directory;?>" />
      </td>
    </tr>
  </form>
</table>
</body>
</html>
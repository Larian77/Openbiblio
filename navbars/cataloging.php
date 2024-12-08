<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../classes/Localize.php");
  $navLoc = new Localize(OBIB_LOCALE,"navbars");

?>
<input type="button" onClick="self.location='../shared/logout.php'" value="<?php echo $navLoc->getText("logout");?>" class="navbutton"><br />
<br />

<?php if ($nav == "searchform") { ?>
 &raquo; <?php echo $navLoc->getText("catalogSearch");?><br>
<?php } else { ?>
 <a href="../catalog/index.php" class="alt1"><?php echo $navLoc->getText("catalogSearch");?></a><br>
<?php } ?>

<?php if ($nav == "search") { ?>
 &nbsp; &raquo; <?php echo $navLoc->getText("catalogResults");?><br>
<?php } ?>

<?php if ($nav == "view") { ?>
 &nbsp; &raquo; <?php echo $navLoc->getText("catalogBibInfo");?><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_edit.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEdit");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_marc_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEditMarc");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/upload_picture_form.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogUploadPicture");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_history.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("History");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_copy_new_form.php?bibid=<?php echo HURL($bibid);?>&reset=Y" class="alt1"><?php echo $navLoc->getText("catalogCopyNew");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_hold_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogHolds");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_del_confirm.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogDelete");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_new_like.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibNewLike");?></a><br>
<?php } ?>

<?php if ($nav == "newcopy") { ?>
 &nbsp; <a href="../shared/biblio_view.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibInfo");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_edit.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEdit");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_marc_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEditMarc");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/upload_picture_form.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogUploadPicture");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_history.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("History");?></a><br>
 &nbsp; &nbsp; &raquo; <?php echo $navLoc->getText("catalogCopyNew");?><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_hold_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogHolds");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_del_confirm.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogDelete");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_new_like.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibNewLike");?></a><br>
<?php } ?>

<?php if ($nav == "editcopy") { ?>
 &nbsp; <a href="../shared/biblio_view.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibInfo");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_edit.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEdit");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_marc_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEditMarc");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/upload_picture_form.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogUploadPicture");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_history.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("History");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_copy_new_form.php?bibid=<?php echo HURL($bibid);?>&reset=Y" class="alt1"><?php echo $navLoc->getText("catalogCopyNew");?></a><br>
 &nbsp; &nbsp; &raquo; <?php echo $navLoc->getText("catalogCopyEdit");?><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_hold_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogHolds");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_del_confirm.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogDelete");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_new_like.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibNewLike");?></a><br>
<?php } ?>

<?php if ($nav == "edit") { ?>
 &nbsp; <a href="../shared/biblio_view.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibInfo");?></a><br>
 &nbsp; &nbsp; &raquo; <?php echo $navLoc->getText("catalogBibEdit");?><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_marc_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEditMarc");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/upload_picture_form.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogUploadPicture");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_history.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("History");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_copy_new_form.php?bibid=<?php echo HURL($bibid);?>&reset=Y" class="alt1"><?php echo $navLoc->getText("catalogCopyNew");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_hold_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogHolds");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_del_confirm.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogDelete");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_new_like.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibNewLike");?></a><br>
<?php } ?>

<?php if ($nav == "editmarc") { ?>
 &nbsp; <a href="../shared/biblio_view.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibInfo");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_edit.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEdit");?></a><br>
 &nbsp; &nbsp;  &raquo; <?php echo $navLoc->getText("catalogBibEditMarc");?><br>
 &nbsp; &nbsp; &nbsp; <a href="../catalog/biblio_marc_new_form.php?bibid=<?php echo HURL($bibid);?>&reset=Y')"><?php echo $navLoc->getText("catalogBibMarcNewFld");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/upload_picture_form.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogUploadPicture");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_history.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("History");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_copy_new_form.php?bibid=<?php echo HURL($bibid);?>&reset=Y" class="alt1"><?php echo $navLoc->getText("catalogCopyNew");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_hold_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogHolds");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_del_confirm.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogDelete");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_new_like.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibNewLike");?></a><br>
<?php } ?>

<?php if ($nav == "newmarc") { ?>
 &nbsp; <a href="../shared/biblio_view.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibInfo");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_edit.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEdit");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_marc_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEditMarc");?></a><br>
 &nbsp; &nbsp; &nbsp; &raquo; <?php echo $navLoc->getText("catalogBibMarcNewFldShrt");?><br>
 &nbsp; &nbsp; <a href="../catalog/upload_picture_form.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogUploadPicture");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_history.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("History");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_copy_new_form.php?bibid=<?php echo HURL($bibid);?>&reset=Y" class="alt1"><?php echo $navLoc->getText("catalogCopyNew");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_hold_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogHolds");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_del_confirm.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogDelete");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_new_like.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibNewLike");?></a><br>
<?php } ?>

<?php if ($nav == "editmarcfield") { ?>
 &nbsp; <a href="../shared/biblio_view.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibInfo");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_edit.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEdit");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_marc_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEditMarc");?></a><br>
 &nbsp; &nbsp; &nbsp; &raquo; <?php echo $navLoc->getText("catalogBibMarcEditFld");?><br>
 &nbsp; &nbsp; <a href="../catalog/upload_picture_form.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogUploadPicture");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_history.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("History");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_copy_new_form.php?bibid=<?php echo HURL($bibid);?>&reset=Y" class="alt1"><?php echo $navLoc->getText("catalogCopyNew");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_hold_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogHolds");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_del_confirm.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogDelete");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_new_like.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibNewLike");?></a><br>
<?php } ?>

<?php if ($nav == "upload_picture") { ?>
 &nbsp; <a href="../shared/biblio_view.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibInfo");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_edit.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEdit");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_marc_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEditMarc");?></a><br>
 &nbsp; &nbsp; &raquo; <?php echo $navLoc->getText("catalogUploadPicture");?><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_history.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("History");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_copy_new_form.php?bibid=<?php echo HURL($bibid);?>&reset=Y" class="alt1"><?php echo $navLoc->getText("catalogCopyNew");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_hold_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogHolds");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_del_confirm.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogDelete");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_new_like.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibNewLike");?></a><br>
<?php } ?>

<?php if ($nav == "history") { ?>
 &nbsp; <a href="../shared/biblio_view.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibInfo");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_edit.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEdit");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_marc_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEditMarc");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/upload_picture_form.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogUploadPicture");?></a><br>
 &nbsp; &nbsp; &raquo; <?php echo $navLoc->getText("History");?><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_copy_new_form.php?bibid=<?php echo HURL($bibid);?>&reset=Y" class="alt1"><?php echo $navLoc->getText("catalogCopyNew");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_hold_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogHolds");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_del_confirm.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogDelete");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_new_like.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibNewLike");?></a><br>
<?php } ?>

<?php if ($nav == "holds") { ?>
 &nbsp; <a href="../shared/biblio_view.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibInfo");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_edit.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEdit");?></a><br>
 
 &nbsp; &nbsp; <a href="../catalog/biblio_marc_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEditMarc");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_history.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("History");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_copy_new_form.php?bibid=<?php echo HURL($bibid);?>&reset=Y" class="alt1"><?php echo $navLoc->getText("catalogCopyNew");?></a><br>
 &nbsp; &nbsp; &raquo; <?php echo $navLoc->getText("catalogHolds");?><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_del_confirm.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogDelete");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_new_like.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibNewLike");?></a><br>
<?php } ?>

<?php if ($nav == "delete") { ?>
 &nbsp; <a href="../shared/biblio_view.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibInfo");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_edit.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEdit");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_marc_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEditMarc");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/upload_picture_form.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogUploadPicture");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_history.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("History");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_copy_new_form.php?bibid=<?php echo HURL($bibid);?>&reset=Y" class="alt1"><?php echo $navLoc->getText("catalogCopyNew");?></a><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_hold_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogHolds");?></a><br>
 &nbsp; &nbsp; &raquo; <?php echo $navLoc->getText("catalogDelete");?><br>
 &nbsp; &nbsp; <a href="../catalog/biblio_new_like.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibNewLike");?></a><br>
<?php } ?>

<?php if ($nav == "new") { ?>
 &raquo; <?php echo $navLoc->getText("catalogBibNew");?><br>
<?php } else { ?>
 <a href="../catalog/biblio_new.php" class="alt1"><?php echo $navLoc->getText("catalogBibNew");?></a><br>
<?php } ?>

<?php if ($nav == "upload_usmarc") { ?>
 &raquo; <?php echo $navLoc->getText("Upload Marc Data");?><br>
<?php } else { ?>
 <a href="../catalog/upload_usmarc_form.php" class="alt1"><?php echo $navLoc->getText("Upload Marc Data");?></a><br>
<?php } ?>

<a href="javascript:popSecondary('../shared/help.php<?php if (isset($helpPage)) echo "?page=".H(addslashes(U($helpPage))); ?>')"><?php echo $navLoc->getText("help");?></a>

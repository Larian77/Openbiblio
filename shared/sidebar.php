<?php 

if (isset($_SESSION["firstName"])) {
    $sess_firstName = $_SESSION["firstName"];
} else {
    $sess_firstName = "";
}
if (isset($_SESSION["lastName"])) {
    $sess_lastName = $_SESSION["lastName"];
} else {
    $sess_lastName = "";
}

$loc2 = new Localize(OBIB_LOCALE,$tab); // for sidebar menu purposes, named loc2 so as not to conflict with $loc
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo H(OBIB_OPAC_URL); ?>" class="brand-link">
        <?php 

        if (OBIB_LIBRARY_IMAGE_URL != "") {
            echo '<img src="' . H(OBIB_LIBRARY_IMAGE_URL) . '" alt="'.OBIB_LIBRARY_NAME.'" class="brand-image img-circle elevation-3" style="opacity: .8">';
        }

        ?>
      <span class="brand-text font-weight-light"><?php // echo OBIB_LIBRARY_NAME ?>&nbsp;</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../lib/AdminLTE/dist/img/neutral3.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $sess_firstName . ' ' . $sess_lastName; ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
	  <nav class="mt-2">
<?php
// Menu configuration array

// icon conventions
// Level 1: custom
// Level 2: fas fa-circle (solid circle)
// Level 3: far fa-circle (regular/outlined circle)
// Level 4: far fa-dot-circle (solid dot inside circle)
// Level 5: fas fa-dot-circle (solid thick dot inside circle)
// Level 6: fas fa-circle-notch (circle with a gap/notch)

$menu_items = [
    [
        'title' => $headerLoc->getText("headerHome"), // home
        // 'url' => $tab == 'home' ? '' : '../home/index.php',
        'url' => '../home/index.php',
        'icon' => 'fas fa-home',
        'children' => [
            [
                'title' => $navLoc->getText("homeHomeLink"),
                'url' => $nav == 'home' ? '' : '../home/index.php',
                'icon' => 'fas fa-circle'
            ],
            $nav == 'pwdforget' ? [
                'title' => $navLoc->getText("PwdNewSet"),
                'url' => '',
                'icon' => 'fas fa-circle'
            ] : null,
            [
                'title' => $navLoc->getText("homeLicenseLink"),
                'url' => $nav == 'license' ? '' : '../home/license.php',
                'icon' => 'fas fa-circle'
            ],
        ]
    ],
    [
        'title' => $headerLoc->getText("headerCirculation"), // circulation
        // 'url' => $tab == 'circulation' ? '' : '../circ/index.php',
        'url' => '../circ/index.php',
        'icon' => 'fas fa-users',
        'children' => [
            [
                'title' => $navLoc->getText("memberSearch"),
                'url' => $tab == 'circulation' && $nav == 'searchform' ? '' : '../circ/index.php',
                'icon' => 'fas fa-circle',
                'children' => [
                    $tab == 'circulation' && $nav == 'search' ? [
                        'title' => $navLoc->getText("catalogResults"),
                        'url' => '',
                        'icon' => 'far fa-circle' 
                    ] : null,
                    ($tab == 'circulation' && in_array($nav, array('view', 'edit', 'PwdReset', 'delete', 'account', 'hist')) && !empty($mbrid)) ? [
                        'title' => $navLoc->getText("memberInfo"),
                        'url' => '../circ/mbr_view.php?mbrid='.HURL($mbrid),
                        'icon' => 'far fa-circle',
                    ] : null,
                    ($tab == 'circulation' && in_array($nav, array('view', 'edit', 'PwdReset', 'delete', 'account', 'hist')) && !empty($mbrid)) ? [
                        'title' => $navLoc->getText("editInfo"),
                        'url' => '../circ/mbr_edit_form.php?mbrid='.HURL($mbrid).'&FileSource=mbr_edit_form',
                        'icon' => 'far fa-circle',
                    ] : null,
                    ($tab == 'circulation' && in_array($nav, array('view', 'edit', 'PwdReset', 'delete', 'account', 'hist')) && !empty($mbrid)) && OBIB_MBR_ACCOUNT_ONLINE == 1 && isset($mbr) ? [
                        'title' => $mbr->getPwd() == "" 
                            ? $navLoc->getText("PwdCreate") 
                            : $navLoc->getText("PwdReset"),
                        'url' => '../circ/mbr_pwd_reset_form.php?mbrid=' . HURL($mbrid),
                        'icon' => 'far fa-circle',
                    ] : null,
                    ($tab == 'circulation' && in_array($nav, array('view', 'edit', 'PwdReset', 'delete', 'account', 'hist')) && !empty($mbrid)) ? [
                        'title' => $navLoc->getText("catalogDelete"),
                        'url' => '../circ/mbr_del_confirm.php?mbrid='.HURL($mbrid),
                        'icon' => 'far fa-circle',
                    ] : null,
                    ($tab == 'circulation' && in_array($nav, array('view', 'edit', 'PwdReset', 'delete', 'account', 'hist')) && !empty($mbrid)) ? [
                        'title' => $navLoc->getText("account"),
                        'url' => '../circ/mbr_account.php?mbrid='.HURL($mbrid).'&reset=Y',
                        'icon' => 'far fa-circle',
                        'children' => [
                            ($tab == 'circulation' && $nav == 'account' && !empty($mbrid) && !empty($transid)) ? [
                                'title' => $loc2->getText("mbrAccountDel"),
                                'url' => '../circ/mbr_transaction_del_confirm.php?mbrid='.HURL($mbrid).'&transid='.HURL($transid),
                                'icon' => 'far fa-dot-circle',
                            ] : null,
                        ]
                    ] : null,
                    ($tab == 'circulation' && in_array($nav, array('view', 'edit', 'PwdReset', 'delete', 'account', 'hist')) && !empty($mbrid)) ? [
                        'title' => $navLoc->getText("checkoutHistory"),
                        'url' => '../circ/mbr_history.php?mbrid='.HURL($mbrid),
                        'icon' => 'far fa-circle',
                    ] : null,
                ]
            ],
            [
                'title' => $navLoc->getText("newMember"),
                'url' => $tab == 'circulation' && $nav == 'new' ? '' : '../circ/mbr_new_form.php?reset=Y&FileSource=mbr_new_form',
                'icon' => 'fas fa-circle'
            ],
            [
                'title' => $navLoc->getText("checkIn"),
                'url' => $tab == 'circulation' && $nav == 'checkin' ? '' : '../circ/checkin_form.php?reset=Y',
                'icon' => 'fas fa-circle'
            ],
            [
                'title' => $navLoc->getText("Offline Circulation"),
                'url' => $tab == 'circulation' && $nav == 'offline' ? '' : '../circ/offline.php',
                'icon' => 'fas fa-circle'
            ],
        ]
    ],
    [
        'title' => $headerLoc->getText("headerCataloging"), // cataloging
        // 'url' => $tab == 'cataloging' ? '' : '../catalog/index.php',
        'url' => '../catalog/index.php',
        'icon' => 'fas fa-book',
        'children' => [
            [
                'title' => $navLoc->getText("catalogSearch"),
                'url' => $tab == 'cataloging' && $nav == 'searchform' ? '' : '../catalog/index.php',
                'icon' => 'fas fa-circle',
				'children' => [
                    $tab == 'cataloging' && $nav == 'search' ? [
                        'title' => $navLoc->getText("catalogResults"),
                        'url' => '',
                        'icon' => 'far fa-circle' 
                    ] : null,
                    ($tab == 'cataloging' && in_array($nav, array('view', 'newcopy', 'editcopy', 'edit', 'editmarc', 'newmarc', 'editmarcfield', 'upload_picture', 'history', 'holds', 'delete', 'editcopy')) && !empty($bibid)) ? [
                        'title' => $navLoc->getText("catalogBibInfo"),
                        'url' => '../shared/biblio_view.php?bibid='.HURL($bibid),
                        'icon' => 'far fa-circle'
                    ] : null,
                    ($tab == 'cataloging' && in_array($nav, array('view', 'newcopy', 'editcopy', 'edit', 'editmarc', 'newmarc', 'editmarcfield', 'upload_picture', 'history', 'holds', 'delete', 'editcopy')) && !empty($bibid)) ? [
                        'title' => $navLoc->getText("catalogBibEdit"),
                        'url' => '../catalog/biblio_edit.php?bibid='.HURL($bibid),
                        'icon' => 'far fa-circle'
                    ] : null,
                    ($tab == 'cataloging' && in_array($nav, array('view', 'newcopy', 'editcopy', 'edit', 'editmarc', 'newmarc', 'editmarcfield', 'upload_picture', 'history', 'holds', 'delete', 'editcopy')) && !empty($bibid)) ? [
                        'title' => $navLoc->getText("catalogBibEditMarc"),
                        'url' => '../catalog/biblio_marc_list.php?bibid='.HURL($bibid),
                        'icon' => 'far fa-circle',
                        'children' => [
                            in_array($nav, array('editmarc', 'newmarc')) ? [
                            'title' => $navLoc->getText("catalogBibMarcNewFld"),
                            'url' => '../catalog/biblio_marc_new_form.php?bibid='.HURL($bibid).'&reset=Y',
                            'icon' => 'far fa-dot-circle'
                            ] : null,
                            in_array($nav, array('editmarcfield')) ? [
                            'title' => $navLoc->getText("catalogBibMarcEditFld"),
                            'url' => '../catalog/biblio_marc_edit_form.php?bibid='.HURL($bibid).'&fieldid='.HURL($fieldid),
                            'icon' => 'far fa-dot-circle'
                            ] : null,
                            in_array($nav, array('editmarc')) && !empty($bibid) && !empty($fieldid) && !empty($tag) && !empty($subfieldCd) ? [
                            'title' => $navLoc->getText("catalogBibMarcDeleteFld"),
                            'url' => '../catalog/biblio_marc_del_confirm.php?bibid='.HURL($bibid).'&fieldid='.HURL($fieldid).'&tag='.HURL($tag).'&subfieldCd='.HURL($subfieldCd),
                            'icon' => 'far fa-dot-circle'
                            ] : null,
                        ]
                    ] : null,
                    ($tab == 'cataloging' && in_array($nav, array('view', 'newcopy', 'editcopy', 'edit', 'editmarc', 'newmarc', 'editmarcfield', 'upload_picture', 'history', 'holds', 'delete', 'editcopy')) && !empty($bibid)) ? [
                        'title' => $navLoc->getText("catalogUploadPicture"),
                        'url' => '../catalog/upload_picture_form.php?bibid='.HURL($bibid),
                        'icon' => 'far fa-circle'
                    ] : null,
                    ($tab == 'cataloging' && in_array($nav, array('view', 'newcopy', 'editcopy', 'edit', 'editmarc', 'newmarc', 'editmarcfield', 'upload_picture', 'history', 'holds', 'delete', 'editcopy')) && !empty($bibid)) ? [
                        'title' => $navLoc->getText("History"),
                        'url' => '../catalog/biblio_history.php?bibid='.HURL($bibid),
                        'icon' => 'far fa-circle'
                    ] : null,
                    ($tab == 'cataloging' && in_array($nav, array('view', 'newcopy', 'editcopy', 'edit', 'editmarc', 'newmarc', 'editmarcfield', 'upload_picture', 'history', 'holds', 'delete', 'editcopy')) && !empty($bibid)) ? [
                        'title' => $navLoc->getText("catalogCopyNew"),
                        'url' => '../catalog/biblio_copy_new_form.php?bibid='.HURL($bibid),
                        'icon' => 'far fa-circle'
                    ] : null,
                    ($tab == 'cataloging' && $nav == 'editcopy' && !empty($bibid) && !empty($copyid)) ? [
                        'title' => $navLoc->getText("catalogCopyEdit"),
                        'url' => '../catalog/biblio_copy_edit_form.php?bibid='.HURL($bibid).'&copyid='.HURL($copyid),
                        'icon' => 'far fa-circle'
                    ] : null,
                    ($tab == 'cataloging' && $nav == 'view' && !empty($bibid) && !empty($copyid)) ? [
                        'title' => $navLoc->getText("catalogCopyDelete"),
                        'url' => '../catalog/biblio_copy_del_confirm.php?bibid='.HURL($bibid).'&copyid='.HURL($copyid),
                        'icon' => 'far fa-circle'
                    ] : null,
                    ($tab == 'cataloging' && in_array($nav, array('view', 'newcopy', 'editcopy', 'edit', 'editmarc', 'newmarc', 'editmarcfield', 'upload_picture', 'history', 'holds', 'delete', 'editcopy')) && !empty($bibid)) ? [
                        'title' => $navLoc->getText("catalogHolds"),
                        'url' => '../catalog/biblio_hold_list.php?bibid='.HURL($bibid),
                        'icon' => 'far fa-circle'
                    ] : null,
                    ($tab == 'cataloging' && in_array($nav, array('view', 'newcopy', 'editcopy', 'edit', 'editmarc', 'newmarc', 'editmarcfield', 'upload_picture', 'history', 'holds', 'delete', 'editcopy')) && !empty($bibid)) ? [
                        'title' => $navLoc->getText("catalogDelete"),
                        'url' => '../catalog/biblio_del_confirm.php?bibid='.HURL($bibid),
                        'icon' => 'far fa-circle'
                    ] : null,
                    ($tab == 'cataloging' && in_array($nav, array('view', 'newcopy', 'editcopy', 'edit', 'editmarc', 'newmarc', 'editmarcfield', 'upload_picture', 'history', 'holds', 'delete', 'editcopy')) && !empty($bibid)) ? [
                        'title' => $navLoc->getText("catalogBibNewLike"),
                        'url' => '../catalog/biblio_new_like.php?bibid='.HURL($bibid),
                        'icon' => 'far fa-circle'
                    ] : null
                ]
            ],
            [
                'title' => $navLoc->getText("catalogBibNew"),
                'url' => '../catalog/biblio_type_select.php',
                'icon' => 'fas fa-circle'
            ],
            [
                'title' => $navLoc->getText("Upload Marc Data"),
                'url' => '../catalog/upload_usmarc_form.php',
                'icon' => 'fas fa-circle'
            ],
        ]
    ],
    [
        'title' => $headerLoc->getText("headerAdmin"), // admin
        // 'url' => $tab == 'admin' ? '' : '../admin/index.php',
        'url' => '../admin/index.php',
        'icon' => 'fas fa-user-shield',
        'children' => [
            [
                'title' => $navLoc->getText("adminSummary"),
                'url' => '../admin/index.php',
                'icon' => 'fas fa-circle'
            ],
            [
                'title' => $navLoc->getText("adminStaff"),
                'url' => '../admin/staff_list.php',
                'icon' => 'fas fa-circle',
                'children' => [
                    $tab == 'admin' && $nav == 'staff' && isset($focus_form_name) && $focus_form_name == "newstaffform" && !empty($_GET['reset']) ? [
                        'title' => $loc2->getText("adminStaff_list_formHeader"),
                        'url' => '../admin/staff_new_form.php?reset=Y',
                        'icon' => 'far fa-circle',
                    ] : null,
                    $tab == 'admin' && $nav == 'staff' && isset($focus_form_name) && $focus_form_name == "editstaffform" && !empty($_GET['UID']) ? [
                        'title' => $loc2->getText("edit"),
                        'url' => '../admin/staff_edit_form.php?UID='.HURL($_GET['UID']),
                        'icon' => 'far fa-circle',
                    ] : null,
                    $tab == 'admin' && $nav == 'staff' && isset($focus_form_name) && $focus_form_name == "pwdresetform" && !empty($_GET['UID']) ? [
                        'title' => $loc2->getText("adminStaff_list_Pwd"),
                        'url' => '../admin/staff_pwd_reset_form.php?UID='.HURL($_GET['UID']),
                        'icon' => 'far fa-circle',
                    ] : null,
                    $tab == 'admin' && $nav == 'staff' && !empty($uid) && !empty($last_name) && !empty($first_name) ? [
                        'title' => $loc2->getText("adminStaff_list_Del"),
                        'url' => '../admin/staff_del_confirm.php?UID='.HURL($uid),
                        'icon' => 'far fa-circle',
                    ] : null,
                ]
            ],
            [
                'title' => $navLoc->getText("Member Types"),
                'url' => '../admin/mbr_classify_list.php',
                'icon' => 'fas fa-circle',
                'children' => [
                    $tab == 'admin' && $nav == 'classifications' && isset($focus_form_name) && $focus_form_name == "newclassificationform" && !empty($_GET['reset']) ? [
                        'title' => $loc2->getText("Add new member classification"),
                        'url' => '../admin/mbr_classify_new_form.php?reset=Y',
                        'icon' => 'far fa-circle',
                    ] : null,
                    $tab == 'admin' && $nav == 'classifications' && isset($focus_form_name) && $focus_form_name == "editclassificationform" && !empty($_GET['code']) ? [
                        'title' => $loc2->getText("edit"),
                        'url' => '../admin/mbr_classify_edit_form.php?code='.HURL($_GET['code']),
                        'icon' => 'far fa-circle',
                    ] : null,
                    $tab == 'admin' && $nav == 'classifications' && !empty($code) && !empty($description) ? [
                        'title' => $loc2->getText("del"),
                        'url' => '../admin/mbr_classify_del_confirm.php?code='.HURL($code).'&desc='.HURL($description),
                        'icon' => 'far fa-circle',
                    ] : null,
                ]
            ],
            [
                'title' => $navLoc->getText("Member Fields"),
                'url' => '../admin/member_fields_list.php',
                'icon' => 'fas fa-circle',
                'children' => [
                    $tab == 'admin' && $nav == 'member_fields' && isset($focus_form_name) && $focus_form_name == "newfieldform" && !empty($_GET['reset']) ? [
                        'title' => $loc2->getText("Add new custom field"),
                        'url' => '../admin/member_fields_new_form.php?reset=Y',
                        'icon' => 'far fa-circle',
                    ] : null,
                    $tab == 'admin' && $nav == 'member_fields' && isset($focus_form_name) && $focus_form_name == "editfieldform" && !empty($_GET['code']) ? [
                        'title' => $loc2->getText("edit"),
                        'url' => '../admin/member_fields_edit_form.php?code='.HURL($_GET['code']),
                        'icon' => 'far fa-circle',
                    ] : null,
                    $tab == 'admin' && $nav == 'member_fields' && !empty($code) && !empty($description) ? [
                        'title' => $loc2->getText("del"),
                        'url' => '../admin/member_fields_del_confirm.php?code='.HURL($code).'&desc='.HURL($description),
                        'icon' => 'far fa-circle',
                    ] : null,
                ]
            ],
            [
                'title' => $navLoc->getText("Copy Fields"),
                'url' => '../admin/copy_fields_list.php',
                'icon' => 'fas fa-circle',
                'children' => [
                    $tab == 'admin' && $nav == 'copy_fields' && isset($focus_form_name) && $focus_form_name == "newfieldform" && !empty($_GET['reset']) ? [
                        'title' => $loc2->getText("Add new custom field"),
                        'url' => '../admin/copy_fields_new_form.php?reset=Y',
                        'icon' => 'far fa-circle',
                    ] : null,
                    $tab == 'admin' && $nav == 'copy_fields' && isset($focus_form_name) && $focus_form_name == "editfieldform" && !empty($_GET['code']) ? [
                        'title' => $loc2->getText("edit"),
                        'url' => '../admin/copy_fields_edit_form.php?code='.HURL($_GET['code']),
                        'icon' => 'far fa-circle',
                    ] : null,
                    $tab == 'admin' && $nav == 'copy_fields' && !empty($code) && !empty($description) ? [
                        'title' => $loc2->getText("del"),
                        'url' => '../admin/copy_fields_del_confirm.php?code='.HURL($code).'&desc='.HURL($description),
                        'icon' => 'far fa-circle',
                    ] : null,
                ]
            ],
            [
                'title' => $navLoc->getText("adminMaterialTypes"),
                'url' => '../admin/materials_list.php',
                'icon' => 'fas fa-circle',
                'children' => [
                    $tab == 'admin' && $nav == 'materials' && isset($focus_form_name) && $focus_form_name == "newmaterialform" && !empty($_GET['reset']) ? [
                        'title' => $loc2->getText("admin_materials_listAddmaterialtypes"),
                        'url' => '../admin/materials_new_form.php?reset=Y',
                        'icon' => 'far fa-circle',
                    ] : null,
                    $tab == 'admin' && $nav == 'materials' && isset($focus_form_name) && $focus_form_name == "editmaterialform" && !empty($_GET['code']) ? [
                        'title' => $loc2->getText("edit"),
                        'url' => '../admin/materials_edit_form.php?code='.HURL($_GET['code']),
                        'icon' => 'far fa-circle',
                    ] : null,
                    $tab == 'admin' && $nav == 'materials' && !empty($code) && !empty($description) ? [
                        'title' => $loc2->getText("del"),
                        'url' => '../admin/materials_del_confirm.php?code='.HURL($code).'&desc='.HURL($description),
                        'icon' => 'far fa-circle',
                    ] : null,
                    $tab == 'admin' && $nav == 'new' && !empty($materialCd) ? [
                        'title' => $loc2->getText("MARC Fields"),
                        'url' => '../admin/custom_marc_view.php?materialCd='.HURL($materialCd),
                        'icon' => 'far fa-circle',
                        'children' => [
                            $tab == 'admin' && $nav == 'new' && isset($focus_form_name) && $focus_form_name == "custommarcform" && !empty($materialCd) ? [
                                'title' => $loc2->getText("Add MARC Field"), //new
                                'url' => '../admin/custom_marc_add_form.php?materialCd='.HURL($materialCd),
                                'icon' => 'far fa-dot-circle',
                            ] : null,
                            $tab == 'admin' && $nav == 'new' && isset($focus_form_name) && $focus_form_name == "custommarceditform" && !empty($materialCd) ? [
                                'title' => $loc2->getText("edit"),
                                'url' => '../admin/custom_marc_edit_form.php?xref_id='.HURL($_GET['xref_id']).'&materialCd='.HURL($materialCd).'&reset=Y',
                                'icon' => 'far fa-dot-circle',
                            ] : null,
                        ]
                    ] : null
                ]
            ],
            [
                'title' => $navLoc->getText("adminCollections"),
                'url' => '../admin/collections_list.php',
                'icon' => 'fas fa-circle',
                'children' => [
                    $tab == 'admin' && $nav == 'collections' && isset($focus_form_name) && $focus_form_name == "newcollectionform" && !empty($_GET['reset']) ? [
                        'title' => $loc2->getText("adminCollections_listAddNewCollection"),
                        'url' => '../admin/collections_new_form.php?reset=Y',
                        'icon' => 'far fa-circle',
                    ] : null,
                    $tab == 'admin' && $nav == 'collections' && isset($focus_form_name) && $focus_form_name == "editcollectionform" && !empty($_GET['code']) ? [
                        'title' => $loc2->getText("edit"),
                        'url' => '../admin/collections_edit_form.php?code='.HURL($_GET['code']),
                        'icon' => 'far fa-circle',
                    ] : null,
                    $tab == 'admin' && $nav == 'collections' && !empty($code) && !empty($description) ? [
                        'title' => $loc2->getText("del"),
                        'url' => '../admin/collections_del_confirm.php?code='.HURL($code).'&desc='.HURL($description),
                        'icon' => 'far fa-circle',
                    ] : null,
                ]
            ],
            [
                'title' => $navLoc->getText("Checkout Privs"),
                'url' => '../admin/checkout_privs_list.php',
                'icon' => 'fas fa-circle',
                'children' => [
                    $tab == 'admin' && $nav == 'checkout_privs' && isset($focus_form_name) && $focus_form_name == "editprivsform" && !empty($material_cd) && !empty($classification) ? [
                        'title' => $loc2->getText("edit"),
                        'url' => '../admin/checkout_privs_edit_form.php?material_cd='.HURL($material_cd).'&classification='.HURL($classification),
                        'icon' => 'far fa-circle',
                    ] : null,
                ]
            ],
            [
                'title' => $navLoc->getText("adminSettings"),
                'url' => '../admin/settings_edit_form.php?reset=Y',
                'icon' => 'fas fa-circle'
            ],
            [
                'title' => $navLoc->getText("adminMailSettings"),
                'url' => '../admin/email_settings_edit_form.php?reset=Y',
                'icon' => 'fas fa-circle'
            ],
            [
                'title' => $navLoc->getText("adminMailMessages"),
                'url' => '../admin/email_messages_list.php',
                'icon' => 'fas fa-circle',
                'children' => [
                    $tab == 'admin' && $nav == 'mail_messages' && isset($focus_form_name) && $focus_form_name == "editMessagesForm" && !empty($_GET['id']) ? [
                        'title' => $loc2->getText("edit"),
                        'url' => '../admin/email_messages_edit_form.php?id='.HURL($_GET['id']),
                        'icon' => 'far fa-circle',
                    ] : null,
                ]
            ],
            [
                'title' => $navLoc->getText("adminThemes"),
                'url' => '../admin/theme_list.php',
                'icon' => 'fas fa-circle',
                'children' => [
                    $tab == 'admin' && $nav == 'themes' && isset($focus_form_name) && $focus_form_name == "newthemeform" && !empty($_GET['reset']) ? [
                        'title' => $loc2->getText("adminTheme_Addnew"),
                        'url' => '../admin/theme_new_form.php?reset=Y',
                        'icon' => 'far fa-circle',
                    ] : null,
                    $tab == 'admin' && $nav == 'themes' && isset($focus_form_name) && $focus_form_name == "editthemeform" && !empty($_GET['themeid']) ? [
                        'title' => $loc2->getText("edit"),
                        'url' => '../admin/theme_edit_form.php?themeid='.HURL($_GET['themeid']),
                        'icon' => 'far fa-circle',
                    ] : null,
                    $tab == 'admin' && $nav == 'themes' && isset($focus_form_name) && $focus_form_name == "newthemeform" && !empty($_GET['themeid']) ? [
                        'title' => $loc2->getText("adminTheme_Copy"),
                        'url' => '../admin/theme_new_form.php?themeid='.HURL($_GET['themeid']),
                        'icon' => 'far fa-circle',
                    ] : null,
                    $tab == 'admin' && $nav == 'themes' && !empty($themeid) && !empty($name) ? [
                        'title' => $loc2->getText("adminTheme_Del"),
                        'url' => '../admin/theme_del_confirm.php?themeid='.HURL($themeid).'&name='.HURL($name),
                        'icon' => 'far fa-circle',
                    ] : null,
                ]
            ],
        ]
    ],
    [
        'title' => $headerLoc->getText("headerReports"), // reports
        // 'url' => $tab == 'reports' ? '' : '../reports/index.php',
        'url' => '../reports/index.php',
        'icon' => 'fas fa-file-alt',
        'children' => [
            $tab == 'reports' && ($nav == 'results' || $nav == "reportcriteria") ? [
                'title' => $navLoc->getText("Report Criteria"),
                'url' => '../reports/report_criteria.php?type=' . U($rpt->type()),
                'icon' => 'fas fa-circle' 
            ] : null,
            [
                'title' => $navLoc->getText("Report List"),
                'url' => '../reports/index.php',
                'icon' => 'fas fa-circle' 
            ],
            $tab == 'reports' && isset($_SESSION['rpt_Report']) ? [
                'title' => $navLoc->getText("Report Results"),
                'url' => $nav == "reportlist" ? '../reports/run_report.php?type=previous' : '../reports/run_report.php',
                'icon' => 'fas fa-circle',
                'children' => (function() use ($tab, $nav, $rpt, $navLoc, $loc2) {
                    $children = [];
                    if ($tab == 'reports' && $nav == 'results') {
                        foreach ($rpt->layouts() as $l) {
                            if ($l['title']) {
                                $title = $l['title'];
                            } else {
                                $title = $l['name'];
                            }
                            $children[] = [
                                'title' => $loc2->getText($title),
                                'url' => '../shared/layout.php?rpt=Report&name=' . U($l['name']),
                                'icon' => 'far fa-circle'
                            ];
                        }
                    }
                    $children[] = $tab == 'reports' && $nav == 'results' ? [
                        'title' => $navLoc->getText("Print list"),
                        'url' => '../shared/layout.php?rpt=Report&name=list',
                        'icon' => 'far fa-circle'
                    ] : null;
                    return $children;
                })()
            ] : null,
        ]
    ]
];

require_once('sidebar_functions.php');

// echo renderSidebarMenu($menu_items);
// echo renderSidebarMenuWithActive($menu_items);
echo renderSidebarMenuWithActiveClickableParents($menu_items);
?>

      </nav>
	  <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

/*********************************************************
 *  Body Style
 *********************************************************/
body {
  height: 100vh;
  background-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  margin: 0;
}

/*********************************************************
 *  Font Styles
 *********************************************************/
font.primary {
  color: <?php echo H(OBIB_PRIMARY_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_PRIMARY_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_PRIMARY_FONT_FACE);?>;
}
font.alt1 {
  color: <?php echo H(OBIB_ALT1_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_ALT1_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_ALT1_FONT_FACE);?>;
}
font.alt1tab {
  color: <?php echo H(OBIB_ALT1_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_ALT2_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_ALT2_FONT_FACE);?>;
<?php if (OBIB_ALT2_FONT_BOLD) { ?>
  font-weight: bold;
<?php } else { ?>
  font-weight: normal;
<?php } ?>
}
font.alt2 {
  color: <?php echo H(OBIB_ALT2_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_ALT2_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_ALT2_FONT_FACE);?>;
<?php if (OBIB_ALT2_FONT_BOLD) { ?>
  font-weight: bold;
<?php } else { ?>
  font-weight: normal;
<?php } ?>
}
font.error {
  color: <?php echo H(OBIB_PRIMARY_ERROR_COLOR);?>;
  font-size: <?php echo H(OBIB_PRIMARY_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_PRIMARY_FONT_FACE);?>;
  font-weight: bold;
}
font.small {
  font-size: 10px;
  font-family: <?php echo H(OBIB_PRIMARY_FONT_FACE);?>;
}
a.nav {
  color: <?php echo H(OBIB_ALT1_FONT_COLOR);?>;
  font-size: 10px;
  font-family: <?php echo H(OBIB_ALT1_FONT_FACE);?>;
  text-decoration: none;
  background-color: <?php echo H(OBIB_ALT1_BG);?>;
  border-style: solid;
  border-color: <?php echo H(OBIB_BORDER_COLOR);?>;
  border-width: <?php echo H(OBIB_BORDER_WIDTH) . "px";?>
}
h1 {
  font-size: 16px;
  font-family: <?php echo H(OBIB_PRIMARY_FONT_FACE);?>;
  font-weight: normal;
}
.notice {
    color: #1a62ac;
}

/*********************************************************
 *  Link Styles
 *********************************************************/
a:link {
  color: <?php echo H(OBIB_PRIMARY_LINK_COLOR);?>;
}
a:visited {
  color: <?php echo H(OBIB_PRIMARY_LINK_COLOR);?>;
}
a.primary:link {
  color: <?php echo H(OBIB_PRIMARY_LINK_COLOR);?>;
}
a.primary:visited {
  color: <?php echo H(OBIB_PRIMARY_LINK_COLOR);?>;
}
a.alt1:link {
  color: <?php echo H(OBIB_ALT1_LINK_COLOR);?>;
}
a.alt1:visited {
  color: <?php echo H(OBIB_ALT1_LINK_COLOR);?>;
}
a.alt2:link {
  color: <?php echo H(OBIB_ALT2_LINK_COLOR);?>;
}
a.alt2:visited {
  color: <?php echo H(OBIB_ALT2_LINK_COLOR);?>;
}
a.tab:link {
  color: <?php echo H(OBIB_ALT2_LINK_COLOR);?>;
  font-size: <?php echo H(OBIB_ALT2_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_ALT2_FONT_FACE);?>;
<?php if (OBIB_ALT2_FONT_BOLD) { ?>
  font-weight: bold;
<?php } else { ?>
  font-weight: normal;
<?php } ?>
  text-decoration: none
}
a.tab:visited {
  color: <?php echo H(OBIB_ALT2_LINK_COLOR);?>;
  font-size: <?php echo H(OBIB_ALT2_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_ALT2_FONT_FACE);?>;
<?php if (OBIB_ALT2_FONT_BOLD) { ?>
  font-weight: bold;
<?php } else { ?>
  font-weight: normal;
<?php } ?>
  text-decoration: none
}
a.tab:hover {text-decoration: underline}

/*********************************************************
 *  Table Styles
 *********************************************************/
table.primary {
  border-collapse: collapse;
}
table.border {
  border-style: solid;
  border-color: <?php echo H(OBIB_BORDER_COLOR);?>;
}
th {
  background-color: <?php echo H(OBIB_ALT2_BG);?>;
  color: <?php echo H(OBIB_ALT2_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_ALT2_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_ALT2_FONT_FACE);?>;
  padding: <?php echo H(OBIB_PADDING);?>;
  border-style: solid;
  border-width: <?php echo H(OBIB_BORDER_WIDTH) . "px";?>;
<?php if (OBIB_ALT2_FONT_BOLD) { ?>
  font-weight: bold;
<?php } else { ?>
  font-weight: normal;
<?php } ?>
  border-color: <?php echo H(OBIB_BORDER_COLOR);?>;
  height: 1
}
th.rpt {
  background-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  color: <?php echo H(OBIB_PRIMARY_FONT_COLOR);?>;
  font-size: <?php echo (OBIB_PRIMARY_FONT_SIZE - 2);?>px;
  font-family: Arial;
  font-weight: bold;
  padding: <?php echo H(OBIB_PADDING);?>;
  border-style: solid;
  border-color: <?php echo H(OBIB_BORDER_COLOR);?>;
  border-width: 1;
  text-align: left;
  vertical-align: bottom;
}
td.primary {
  background-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  color: <?php echo H(OBIB_PRIMARY_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_PRIMARY_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_PRIMARY_FONT_FACE);?>;
  padding: <?php echo H(OBIB_PADDING);?>;
  border-style: solid;
  border-color: <?php echo H(OBIB_BORDER_COLOR);?>;
  border-width: <?php echo H(OBIB_BORDER_WIDTH) . "px";?>
}
td.borderless {
  background-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  color: <?php echo H(OBIB_PRIMARY_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_PRIMARY_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_PRIMARY_FONT_FACE);?>;
  padding: <?php echo H(OBIB_PADDING);?>;
}
td.rpt {
  background-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  color: <?php echo H(OBIB_PRIMARY_FONT_COLOR);?>;
  font-size: <?php echo (OBIB_PRIMARY_FONT_SIZE - 2);?>px;
  font-family: Arial;
  padding: <?php echo H(OBIB_PADDING);?>;
  border-top-style: none;
  border-bottom-style: none;
  border-left-style: solid;
  border-left-color: <?php echo H(OBIB_BORDER_COLOR);?>;
  border-left-width: 1;
  border-right-style: solid;
  border-right-color: <?php echo H(OBIB_BORDER_COLOR);?>;
  border-right-width: 1;
  text-align: left;
  vertical-align: top;
}
td.primaryNoWrap {
  background-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  color: <?php echo H(OBIB_PRIMARY_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_PRIMARY_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_PRIMARY_FONT_FACE);?>;
  padding: <?php echo H(OBIB_PADDING);?>;
  border-style: solid;
  border-color: <?php echo H(OBIB_BORDER_COLOR);?>;
  border-width: <?php echo H(OBIB_BORDER_WIDTH) . "px";?>;
  white-space: nowrap
}

td.title, div.title {
  background-color: <?php echo H(OBIB_TITLE_BG);?>;
  color: <?php echo H(OBIB_TITLE_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_TITLE_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_TITLE_FONT_FACE);?>;
  padding: <?php echo H(OBIB_PADDING);?>;
  margin-bottom: 1px;
<?php if (OBIB_TITLE_FONT_BOLD) { ?>
  font-weight: bold;
<?php } else { ?>
  font-weight: normal;
<?php } ?>
  border-color: <?php echo H(OBIB_BORDER_COLOR);?>;
  border-width: <?php echo H(OBIB_BORDER_WIDTH) . "px";?>;
  text-align: <?php echo H(OBIB_TITLE_ALIGN);?>;
}
td.alt1 {
  background-color: <?php echo H(OBIB_ALT1_BG);?>;
  color: <?php echo H(OBIB_ALT1_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_ALT1_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_ALT1_FONT_FACE);?>;
  padding: <?php echo H(OBIB_PADDING);?>;
  border-style: solid;
  border-color: <?php echo H(OBIB_BORDER_COLOR);?>;
  border-width: <?php echo H(OBIB_BORDER_WIDTH) . "px";?>
}
td.tab1, div.tab1 {
  background-color: <?php echo H(OBIB_ALT1_BG);?>;
  color: <?php echo H(OBIB_ALT1_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_ALT1_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_ALT2_FONT_FACE);?>;
<?php if (OBIB_ALT2_FONT_BOLD) { ?>
  font-weight: bold;
<?php } else { ?>
  font-weight: normal;
<?php } ?>
  padding: <?php echo H(OBIB_PADDING);?>;
  border-width: <?php echo H(OBIB_BORDER_WIDTH) . "px";?>
}
td.tab2, div.tab2 {
  background-color: <?php echo H(OBIB_ALT2_BG);?>;
  color: <?php echo H(OBIB_ALT2_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_ALT2_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_ALT2_FONT_FACE);?>;
<?php if (OBIB_ALT2_FONT_BOLD) { ?>
  font-weight: bold;
<?php } else { ?>
  font-weight: normal;
<?php } ?>
  padding: <?php echo H(OBIB_PADDING);?>;
  border-width: <?php echo H(OBIB_BORDER_WIDTH) . "px";?>
}
td.noborder {
  background-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  color: <?php echo H(OBIB_PRIMARY_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_PRIMARY_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_PRIMARY_FONT_FACE);?>;
  padding: <?php echo H(OBIB_PADDING);?>;
}

table.form { margin-bottom: 1em }
table.form th.title {
  background-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  color: <?php echo H(OBIB_PRIMARY_FONT_COLOR);?>;
  text-align: left;
  font-weight: bold;
  font-size: 18px;
  border: none;
  border-bottom: solid <?php echo H(OBIB_ALT2_BG);?> 2px;
}
table.form th {
  text-align: right;
  vertical-align: top;
  background-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  color: <?php echo H(OBIB_PRIMARY_FONT_COLOR);?>;
  border: none;
}
table.form .error { font-weight: bold; color: red }
table.form .error { font-weight: bold; color: red }

/*********************************************************
 *  Member View Styles 
 *********************************************************/
#LendingStatus {
   margin-top: 16px;
}
th.LendingHeads {
   color: #000000;
   background-color: #ffffff;
}

/*********************************************************
 *  Form Styles
 *********************************************************/
input.button {
  background-color: <?php echo H(OBIB_ALT1_BG);?>;
  border-color: <?php echo H(OBIB_ALT1_BG);?>;
  border-left-color: <?php echo H(OBIB_ALT1_BG);?>;
  border-top-color: <?php echo H(OBIB_ALT1_BG);?>;
  border-bottom-color: <?php echo H(OBIB_ALT1_BG);?>;
  border-right-color: <?php echo H(OBIB_ALT1_BG);?>;
  padding: <?php echo H(OBIB_PADDING);?>;
  font-family: <?php echo H(OBIB_PRIMARY_FONT_FACE);?>;
  color: <?php echo H(OBIB_ALT1_FONT_COLOR);?>;
}
input.navbutton {
  background-color: <?php echo H(OBIB_ALT2_BG);?>;
  border-color: <?php echo H(OBIB_ALT2_BG);?>;
  border-left-color: <?php echo H(OBIB_ALT2_BG);?>;
  border-top-color: <?php echo H(OBIB_ALT2_BG);?>;
  border-bottom-color: <?php echo H(OBIB_ALT2_BG);?>;
  border-right-color: <?php echo H(OBIB_ALT2_BG);?>;
  padding: <?php echo H(OBIB_PADDING);?>;
  font-family: <?php echo H(OBIB_PRIMARY_FONT_FACE);?>;
  color: <?php echo H(OBIB_ALT2_FONT_COLOR);?>;
}
input {
  background-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-left-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-top-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-bottom-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-right-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  padding: 0 2px 0 2px;
  scrollbar-base-color: <?php echo H(OBIB_ALT1_BG);?>;
  font-family: <?php echo H(OBIB_PRIMARY_FONT_FACE);?>;
  color: <?php echo H(OBIB_PRIMARY_FONT_COLOR);?>;
}
textarea {
  background-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-left-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-top-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-bottom-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-right-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  padding: 0px;
  scrollbar-base-color: <?php echo H(OBIB_ALT1_BG);?>;
  font-family: <?php echo H(OBIB_PRIMARY_FONT_FACE);?>;
  color: <?php echo H(OBIB_PRIMARY_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_PRIMARY_FONT_SIZE);?>px;
}
select {
  background-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-left-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-top-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-bottom-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-right-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  padding: 0 2px 0 2px;
  scrollbar-base-color: <?php echo H(OBIB_ALT1_BG);?>;
  font-family: <?php echo H(OBIB_PRIMARY_FONT_FACE);?>;
  color: <?php echo H(OBIB_PRIMARY_FONT_COLOR);?>;
}

ul.nav_main { list-style-type: none; padding-left: 0; margin-left: 0; }
li.nav_selected:before { white-space: pre-wrap; content: "\bb  " }
ul.nav_main li.nav_selected { font-weight: bold }
ul.nav_sub li.nav_selected { font-weight: bold }
ul.nav_main li { font-weight: normal }
ul.nav_sub li { font-weight: normal }

li.report_category { margin-bottom: 1em }

table.results {
  width: 100%;
  border-collapse: collapse;
}
table.resultshead {
  width: 100%;
  border-collapse: separate;
  border-top: solid <?php echo OBIB_ALT2_BG;?> 3px;
  border-bottom: solid <?php echo OBIB_ALT2_BG;?> 3px;
  clear: both;
}
table.resultshead th {
  text-align: left;
  color: <?php echo OBIB_PRIMARY_FONT_COLOR;?>;
  border: none;
  background: <?php echo OBIB_PRIMARY_BG;?>;
  font-size: 16px;
  font-weight: bold;
  vertical-align: middle;
  padding: 2px;
}
table.resultshead td {
  text-align: right;
}
table.results td.primary { border-top: none; }

table.buttons {
  margin: 0 0 0 auto;
  padding: 0;
  border-collapse: separate;
  background: white;
}
table.buttons td {
  background-color: <?php echo OBIB_ALT2_BG;?>;
  /* Hide from IE5/Mac \*/
  border-color: <?php echo OBIB_ALT2_BG;?>;
  border-style: outset;
  border-width: 1px;
  /* End hiding */
  padding: 4px;
  font-weight: bold;
  font-size: 12px;
  text-align: center;
  vertical-align: middle;
}
table.buttons input {
  border: none;
  color: <?php echo OBIB_ALT2_FONT_COLOR;?>;
  background: <?php echo OBIB_ALT2_BG;?>;
  padding: 0;
  margin: 0;
  font-weight: bold;
  white-space: normal;
}
table.buttons input:hover { text-decoration: underline; }
table.buttons a {
  color: <?php echo OBIB_ALT2_FONT_COLOR;?>;
  text-decoration: none;
}
table.buttons a:hover { text-decoration: underline; }
table.buttons a:visited { color: <?php echo OBIB_ALT2_FONT_COLOR;?>; }

div.errorbox {
  border-style: solid;
  border-color: <?php echo H(OBIB_BORDER_COLOR);?>;
  border-width: <?php echo H(OBIB_BORDER_WIDTH) . "px";?>;
  max-width: 500px;
  margin: 10px;
  padding: 5px;
  background-color: <?php echo H(OBIB_ALT1_BG);?>;
}
div.errorbox .errorhdr { font-size: large; font-weight: bold }
div.errorbox ul { margin-left: 0; padding-left: 1.5em }
div.errorbox li { margin-left: 0 }

#pwdForgottenLink {
    font-size: 13px;
    font-family: verdana, arial, helvetica;
}

.pwdCss {
    color: #1a62ac;
}

/*********************************************************
 *  div - Header
 *********************************************************/
 .headertop {
    width: 100%;
    height: 93px;
    border: none;
    border-spacing: 0;
    background-color: <?php echo H(OBIB_TITLE_BG);?>;
 }
 /* Logo */
 #logo {
    float: left;
    padding-right: 10px;
 }
 #imglogo {
    border: 0;
 }
 .headerBiblioInfo {
    padding: 5px 5px 0 0;
    float: right;
    background-color: <?php echo H(OBIB_TITLE_BG);?>;
 }
 .title.headerBiblioSingleInfo {
    font-size: 12px;
 }

 @media only screen and (min-width: 320px) {
    #headertitle {
    padding: 20px 0;

    }
 }
 @media only screen and (min-width: 970px) {
    #headertitle {
        font-size: 1.0em;
    }
 }
 
 /*********************************************************
 *  div - Top-Navigation
 *********************************************************/
 .navigationTop {
    background-color: <?php echo H(OBIB_TITLE_BG);?>;
    position: absolute;
    padding-top: 1px;
 }
 .tab1.tabnew, .tab2.tabnew {
    float: left;
    border: 1px solid;
    border-bottom: none;
    border-radius: 5px 5px 0 0;
    padding: 2px 3px;
 }
 
 /*********************************************************
 *  div - Top-Navigation
 *********************************************************/
 .navigationLeft {
    padding-left: 10px;
    width: 140px;
    height: 100%;
    overflow: hidden;
    display: inline-block;
    white-space: nowrap;
 }
 
 /*********************************************************
 *  Content Body
 *********************************************************/
 .ContentBody {
    padding-left: 10px;
 }
 
/*********************************************************
 *  div - Container Styles
 *********************************************************/
 .header1 {
    background-color: <?php echo H(OBIB_ALT2_BG);?>;
    color: <?php echo H(OBIB_ALT2_FONT_COLOR);?>;
    font-size: <?php echo H(OBIB_ALT2_FONT_SIZE);?>px;
    font-family: <?php echo H(OBIB_ALT2_FONT_FACE);?>;
    padding: <?php echo H(OBIB_PADDING);?>px;
<?php if (OBIB_ALT2_FONT_BOLD) { ?>
        font-weight: bold;
<?php } else { ?>
        font-weight: normal;
<?php } ?>
  border-bottom: 1px <?php echo H(OBIB_BORDER_COLOR);?> solid;
  border-width: <?php echo H(OBIB_BORDER_WIDTH) . "px";?>;
}
.header2 {
    padding-left: 10px;
}

/*********************************************************
 *  InputFields with div container
 *********************************************************/
.formular {
    border: 1px solid;
    width: 99%;
 }
 .middle {
    margin: auto;
    width: 50%
 }
 .info {
    padding: 0 5px;
 }
 .form {
    width: 100%;
 }
 .descriptionField {
    width: 30%;
    float: left;
    text-align: right;
    padding: 12px 10px 5px 0;
 }
 .inputField {
    text-align: left;
    padding: 15px 0 15px 0;
 }
 .inputField.hidden {
  padding: 0 0;
 }
 .helpInfo {
    padding-left: 5px;
    width: 70%;
    margin: auto;
 }
 .buttonarea {
    padding: 10px 0 10px;
 }
 .submit {
    padding: 2px 0 5px;
    margin-left: 31%;
 }
 .errorInfo {
   padding: 5px 5px;
   text-align: center;
 }
 .choice {
    text-align: center;
    font-weight: bold;
 }
 /*********************************************************
 *  Lists with div container
 *********************************************************/
 .messagesList {
   width: 70%;
 }
 .list {
  border-bottom: 1px solid;
 }
 .function {
  width: 20%;
  float: left;
  padding: 5px 2px 5px 2px;
}
.descriptionList {
  padding: 5px 2px 5px 2px;
}
.straightRow {
  background-color: <?php echo H(OBIB_ALT1_BG);?>;
}

/*********************************************************
 *  Footer
 *********************************************************/
.footer {
    text-align: center;
    line-height: normal;
}

/*********************************************************
 *  Phones/Tables Header with div container
 *********************************************************/
 @media only screen and (max-width: 950px) {
    .headerBiblioInfo {
       display: none;
    }

 }
 
 @media only screen and (max-width: 320px) {
    .navigationTop {
       position: inherit;
       padding-top: 7px;
    }
 }

 /*********************************************************
 *  Phones/Tables InputFields/Lists with div container
 *********************************************************/
 @media only screen and (max-width: 900px) {
    .formular {
        width: 100%;    
    }
    .form {
        padding-left: 5px;
    }
    .descriptionField {
        text-align: left; 
        width: 100%;
        margin: auto;
        padding: 5px 0;
    }
    .function {
        width: 99.4%;
    }
    .descriptionList {
        width: 99.4%;
    }
    .helpInfo {
        width: 100%;
        padding-left: 0;
    }
    .submit {
        margin-left: 0;
    }
    .errorInfo {
        text-aling: left;
        width: 95%;
        padding: 5px 5px;
    }
    .choice {
        text-align: left;
    }
 }

 /*********************************************************
 *  TinyMCE
 *********************************************************/
 .tox-tinymce {
  width: 68%;
 }
 /*********************************************************
 *  Phones/Tables Header with TinyMCE
 *********************************************************/
 @media only screen and (max-width: 900px) {
    .tox-tinymce {
       width: 98%;
    }
 }
 
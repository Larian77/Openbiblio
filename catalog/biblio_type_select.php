<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
require_once("../shared/common.php");
$tab = "cataloging";
$nav = "new";

require_once("../shared/logincheck.php");
require_once("../classes/DmQuery.php");
require_once("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, $tab);

$dmQ = new DmQuery();
$dmQ->connect_e();
$types = $dmQ->get("material_type_dm");
$dmQ->close();

include("../shared/header.php");
?>

<div class="container-fluid mt-3">
  <h4><?php echo $loc->getText("biblioTypeSelectHeading"); ?></h4>
  <div class="row mt-3">
<?php foreach ($types as $type): ?>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-3">
      <a href="../catalog/biblio_new.php?materialCd=<?php echo U($type->getCode()); ?>"
         class="text-decoration-none">
        <div class="card h-100 text-center shadow-sm biblio-type-card">
          <div class="card-body d-flex flex-column align-items-center justify-content-center">
            <img src="../images/<?php echo H($type->getImageFile()); ?>"
                 alt="<?php echo H($type->getDescription()); ?>"
                 style="max-height:48px; max-width:48px; margin-bottom:.5rem;">
            <div class="font-weight-bold"><?php echo H($type->getDescription()); ?></div>
          </div>
        </div>
      </a>
    </div>
<?php endforeach; ?>
  </div>
</div>

<style>
  .biblio-type-card {
    cursor: pointer;
    transition: transform .1s, box-shadow .1s;
    border: 2px solid transparent;
  }
  .biblio-type-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15) !important;
    border-color: #007bff;
  }
</style>

<?php include("../shared/footer.php"); ?>

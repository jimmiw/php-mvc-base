<?php if(getFlash('success') != "") { ?>
  <div class="success">
    <?=getFlash('success');?>
  </div>
<?php } ?>

<?php if(getFlash('error') != "") { ?>
  <div class="error">
    <?=getFlash('error');?>
  </div>
<?php } ?>

<?php if(getFlash('info') != "") { ?>
  <div class="info">
    <?=getFlash('info');?>
  </div>
<?php } ?>
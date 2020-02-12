<?php
$menu = new Menu(); ?>
<div class="menu"> <?php
    if (isset($project)) { ?>
        <div class="head-up-display-bar">
            <span><?php echo $project::getHeadUp(); ?></span>
        </div> <?php
    } ?>
</div>
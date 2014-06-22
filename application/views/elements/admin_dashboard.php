    <!-- Table -->
    <div class="row-fluid">
        <div class="span12">
            <div class="box" id="box-0">
                <h4 class="box-header round-top"><?php echo tr($dashboard['title']); ?></h4>         
                <div class="box-container-toggle">
                    <div class="box-content">
                        <div class="other">
                            <ul id="dashboard-buttons">
<?php
                                foreach ($dashboard['li'] as $lis)
                                {
?>
                                <li>
                                        <a href="<?php echo $lis['href'];?>">
                                                <div><?php echo tr($lis['text']); ?></div>
                                                <img src="<?php echo ICONS_PATH;?>admin/dashboard/<?php echo $lis['dash_img'];?>.png" />
                                        </a>
                                </li>
<?php
                                }
?>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                </div>
            </div><!--/span-->
        </div>
    </div>
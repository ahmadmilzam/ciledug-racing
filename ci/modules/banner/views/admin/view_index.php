<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12 ">
        <div class="btn-group margin-bottom">
            <!-- Button Color Classes: [secondary alert success] -->
            <?php echo anchor('admin/banner/form/', 'Create New Banner <i class="fa fa-plus-circle"></i>', array('class'=>'btn btn-default btn-lg'))?>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Enable On</th>
                        <th>Disable On</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
            <?php if(count($banners) && is_array($banners)):foreach($banners as $banner): ?>
                    <tr>
                        <td><?php echo $banner->title; ?></td>
                        <td><?php echo date('d M Y', strtotime($banner->enable_on)); ?></td>
                        <td><?php echo date('d M Y', strtotime($banner->disable_on)); ?></td>
                        <td class="text-right">
                            <?php echo button_edit('admin/banner/form/'.$banner->id_banner); ?>
                            <?php echo button_delete('admin/banner/delete/'.$banner->id_banner); ?>
                        </td>
                    </tr>
            <?php endforeach; ?>
            <?php else: ?>
                    <tr>
                        <td colspan="4">We could not find any banners</td>
                    </tr>
            <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12 ">
        <?php echo $pagination; ?>
    </div>
</div>
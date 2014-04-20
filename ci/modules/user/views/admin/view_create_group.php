<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12 ">
        <h2><?php echo lang('create_group_heading');?></h2>
        <p><?php echo lang('create_group_subheading');?></p>
        <?php echo form_open('admin/auth/create_group');?>

            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6 ">
                    <div class="form-group">
                        <label for="group_name">
                        <?php echo lang('create_group_name_label');?>
                        <small>Required</small>
                        </label>
                        <input type="text" class="form-control" id="group_name" name="group_name" value="" placeholder="Group Name">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6 ">
                    <div class="form-group">
                        <label for="group_desc">
                        <?php echo lang('create_group_desc_label');?>
                        <small>Required</small>
                        </label>
                        <textarea class="form-control" id="group_desc" name="group_desc" value="" placeholder="Group Description"></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6 ">
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-primary"><?php echo lang('create_group_submit_btn');?> <i class="fa fa-user"></i></button>
                    </div>
                </div>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>
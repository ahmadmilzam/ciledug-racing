<div class="row">
    <div class="col-xs-12">
        <h2><?php echo lang('create_user_heading');?></h2>
        <p><?php echo lang('create_user_subheading');?></p>
        <?php echo form_open('admin/user/create_user');?>
            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6 ">
                    <div class="form-group">
                        <label for="first_name">
                            <?php echo lang('create_user_fname_label');?>
                            <small>Required</small>
                        </label>
                        <input class="form-control" type="text" id="" name="first_name" value="<?php echo $first_name; ?>" placeholder="First Name" required>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-6 ">
                    <div class="form-group">
                        <label for="last_name">
                            <?php echo lang('create_user_lname_label');?>
                            <small>Required</small>
                        </label>
                        <input class="form-control" type="text" id="" name="last_name" value="<?php echo $last_name; ?>" placeholder="Last Name" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6 ">
                    <div class="form-group">
                        <label for="email">
                            <?php echo lang('create_user_email_label');?>
                            <small>Required</small>
                        </label>
                        <input class="form-control" type="email" id="email" name="email" value="<?php echo $email; ?>" placeholder="Email" required>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-6 ">
                    <div class="form-group">
                        <label for="phone">
                            <?php echo lang('create_user_phone_label');?>
                            <small>Required</small>
                        </label>
                        <input class="form-control" type="text" id="phone" name="phone" value="<?php echo $phone; ?>" placeholder="Phone" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6 ">
                    <div class="frm-group">
                        <label for="pass">
                            <?php echo lang('create_user_password_label');?>
                            <small>Required</small>
                        </label>
                        <input class="form-control" type="password" id="pass" name="password" value="" placeholder="Password" required>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-6 ">
                    <div class="form-group">
                        <label for="conf_password">
                            <?php echo lang('create_user_password_confirm_label');?>
                            <small>Required</small>
                        </label>
                        <input class="form-control" type="password" id="conf_password" name="conf_password" value="" placeholder="Confirm Password" required>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-12 ">
                    <div class="form-group">
                        <!-- select group for new user -->
                        <label>Select group for new user</label>
                        <br>
                        <?php foreach ($all_groups as $group):?>

                            <?php
                                $group_id = $group['id'];
                                $checked  = null;
                                // dump($groups);
                                if ($groups && count($groups) > 0)
                                {
                                    foreach($groups as $grp_id)
                                    {
                                        if ($grp_id == $group['id'])
                                        {
                                            $checked = 'checked="checked"';
                                            break;
                                        }
                                    }
                                }
                            ?>

                            <label class="checkbox">
                                <input class="form-control" type="checkbox" name="groups[]" value="<?php echo $group['id'];?>" <?php echo $checked;?>>
                                <?php echo $group['name'];?>
                            </label>
                        <?php endforeach?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12 ">
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-primary"><?php echo lang('create_user_submit_btn');?> <i class="fa fa-user"></i></button>
                    </div>
                </div>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>
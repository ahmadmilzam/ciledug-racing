<div class="row">
    <div class="col-xs-12">
        <h2><?php echo lang('edit_user_heading');?></h2>
        <p><?php echo lang('edit_user_subheading');?></p>
        <?php echo form_open('admin/user/edit_user/'.$user->id);?>

            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6 ">
                    <div class="form-group">
                        <label for="first_name">
                            <?php echo lang('edit_user_fname_label', 'first_name');?>
                            <small>Required</small>
                        </label>
                        <?php echo form_input($first_name);?>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-6 ">
                    <div class="form-group">
                        <label for="last_name">
                            <?php echo lang('edit_user_lname_label','last_name');?>
                            <small>Required</small>
                        </label>
                        <?php echo form_input($last_name);?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6 ">
                    <div class="form-group">
                        <label for="email">
                            <?php echo lang('edit_user_email_label', 'email');?>
                            <small>Required</small>
                        </label>
                        <?php echo form_input($email);?>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-6 ">
                    <div class="form-group">
                        <label for="phone">
                            <?php echo lang('edit_user_phone_label', 'phone');?>
                            <small>Required</small>
                        </label>
                        <?php echo form_input($phone);?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6 ">
                    <div class="frm-group">
                        <label for="pass">
                            <?php echo lang('edit_user_password_label', 'password');?>
                        </label>
                        <?php echo form_input($password);?>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-6 ">
                    <div class="form-group">
                        <label for="conf_password">
                            <?php echo lang('edit_user_password_confirm_label', 'password_confirm');?>
                        </label>
                        <?php echo form_input($password_confirm);?>
                    </div>
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-xs-12 ">
                    <div class="form-group">
                        <!-- select group for new user -->
                        <label><?php echo lang('edit_user_groups_heading');?></label>
                        <br>
                        <?php foreach ($groups as $group):?>

                        <label class="checkbox">
                            <?php
                                $gID=$group['id'];
                                $checked = null;
                                $item = null;
                                foreach($currentGroups as $grp) {
                                    if ($gID == $grp->id)
                                    {
                                        $checked= ' checked="checked"';
                                    break;
                                    }
                                }
                            ?>
                                <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
                                <?php echo $group['name'];?>
                        </label>
                        <?php endforeach?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12 ">
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-primary"><?php echo lang('edit_user_submit_btn');?> <i class="fa fa-user"></i></button>
                    </div>
                </div>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>
<!--
- Reset password modal
-->

<div class="modal-content"><!-- modal content -->

  <div class="modal-header"><!-- modal header -->
      <h1 class="text-center">Reset Password</h1>
  </div><!-- //modal header -->

  <div class="modal-body"><!-- modal body -->

    <?php echo form_open("user/auth/reset_password/".$code , array('class'=>'form','role'=>'form'));?><!-- form center block -->

      <div class="form-group"><!-- form group input new password -->
      	<?php echo form_hidden($user_id); ?>
        <?php echo form_input($new_password);?>
      </div><!-- //form group input new password -->

      <div class="form-group"><!-- form group input new password confirm -->
        <?php echo form_input($new_password_confirm);?>
      </div><!-- //form group input new password confirm -->

      <div class="form-group"><!-- form group submit button -->
        <?php echo form_button($submit_button); ?>
      </div><!-- //form group submit button -->

    <?php form_close(); ?><!-- //form center block -->

  </div><!-- //modal body -->

  <div class="modal-footer"><!-- modal footer -->
    <div class="col-md-12">
      <span class="pull-left"><a href="<?php echo base_url('auth/login'); ?>">Back to login page</a></span>
      &copy; 2014&ndash;2015 Copyright - <a href="http://www.cldracing.com" target="_blank">CLD Racing</a>
    </div>
  </div><!-- //modal footer -->

</div><!-- //modal content -->
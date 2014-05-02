<!--
- login modal
-->

<div class="modal-content"><!-- modal content -->

  <div class="modal-header"><!-- modal header -->
      <h1 class="text-center">Login</h1>
  </div><!-- //modal header -->

  <div class="modal-body"><!-- modal body -->

    <?php echo form_open("user/auth/login" , array('class'=>'form','role'=>'form'));?><!-- form center block -->

      <div class="form-group"><!-- form group input email -->
        <?php echo form_input($input_email);?>
      </div><!-- //form group input email -->

      <div class="form-group"><!-- form group input password -->
        <?php echo form_input($input_password);?>
      </div><!-- //form group input password -->

      <div class="form-group"><!-- form group button sing in -->
        <?php echo form_button($submit_button); ?>
      </div><!-- //form group button sing in -->

      <div class="form-group"><!-- form group remember me -->
        <label class="checkbox">
            <?php echo form_checkbox('Remember me', '1', FALSE);?>
            <span>Remember me</span>
        </label>
      </div><!-- //form group remember me -->

    <?php form_close(); ?><!-- //form center block -->

  </div><!-- //modal body -->

  <div class="modal-footer"><!-- modal footer -->
    <div class="col-md-12">
      &copy; 2014&ndash;2015 Copyright - <a href="http://www.cldracing.com" target="_blank">CLD Racing</a>
    </div>
  </div><!-- //modal footer -->

</div><!-- //modal content -->
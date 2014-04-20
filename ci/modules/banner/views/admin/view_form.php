<div class="row">
  <div class="col-xs-12">
    <h2><?php echo $id_banner ? 'Edit Banner : '.$title : 'Add New Banner' ?></h2>

    <!-- Tab panes -->
    <?php echo form_open_multipart('admin/banner/form/'.$id_banner); ?><!-- form open -->
      <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="form-group">
              <label>
                Banner Title
                <small>: Required</small>
              </label>
              <?php echo form_input($input_title); ?>
            </div>
            <div class="form-group">
              <label>
                Banner Caption
                <small>: Required</small>
              </label>
              <?php echo form_textarea($input_caption); ?>
            </div>
            <div class="form-group">
              <label>
                Banner Link
                <small>: Optional</small>
              </label>
              <?php echo form_input($input_link); ?>
            </div>
            <div class="form-group">
              <label>
                Banner Enable On
                <small>: Required</small>
              </label>
              <?php echo form_input($input_enable); ?>
            </div>
            <div class="form-group">
              <label>
                Banner Disable On
                <small>: Required</small>
              </label>
              <?php echo form_input($input_disable); ?>
            </div>

            <div class="form-group">
              <label>
                Banner Image
                <small>: Required</small>
              </label> <br>
              <?php echo form_upload($input_file); ?>
            </div>

        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top">
          <div class="form-group">
            <?php echo form_button($submit_button); ?>
          </div>
        </div>
      </div>

    <?php echo form_close(); ?><!-- form close -->
  </div>
</div>

<?php if($id_banner && $filename != ''):?>
  <div class="row">
    <div class="col-xs-12">
      <p>
        <strong>Current Banner</strong>
      </p>
      <img src="<?php echo base_url('media/banner/'.$filename);?>" alt="current" class="img-responsive img-thumbnail"/>
    </div>
  </div>
<?php endif;?>
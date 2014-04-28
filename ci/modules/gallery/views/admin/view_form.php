<div class="row">
  <div class="col-xs-12">
    <h2><?php echo 'Edit Image Gallery : '.$alt ?></h2>

    <!-- Tab panes -->
    <?php echo form_open_multipart('admin/gallery/form/'.$id_img); ?><!-- form open -->
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-10 col-xs-12">
          <div class="form-group">
            <label>
              Image Title
              <small>: Optional</small>
            </label>
            <?php echo form_input($input_title, set_value('alt', $alt)); ?>
          </div>
          <div class="form-group">
            <label>
              image Caption
              <small>: Optional</small>
            </label>
            <?php echo form_textarea($input_caption, set_value('caption', $caption)); ?>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <?php if($id_img && $filename != ''):?>
            <div class="form-group">
              <label>Images</label>
              <div class="text-left">
                <img src="<?php echo base_url('media/gallery/thumb/'.$filename); ?>">
              </div>
            </div>
          <?php endif ?>
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
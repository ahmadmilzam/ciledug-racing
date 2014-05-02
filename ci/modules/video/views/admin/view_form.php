<div class="row">
  <div class="col-xs-12">
    <h2><?php echo $id_video ? 'Edit Video : '.$title : 'Add New Video' ?></h2>

    <!-- Tab panes -->
    <?php echo form_open('admin/video/form/'); ?><!-- form open -->
      <div class="row">
        <div class="col-lg-6 col-md-6 col-xs-12">

          <div class="form-group">
            <label>
              Video Title
              <small>: Required</small>
            </label>
            <?php echo form_input($input_title, set_value('title', $title)); ?>
          </div>
          <div class="form-group">
            <label>
              Video Url
              <small>: Required</small>
            </label>
            <?php echo form_textarea($input_url, set_value('url', $url)); ?>
          </div>

          <div class="form-group">
            <?php echo form_button($submit_button); ?>
          </div>

        </div>

        <?php if (isset($url) && !empty($url)): ?>

        <div class="col-lg-6 col-md-6 col-xs-12">
          <label>Current Video:</label>
          <div class="flex-video">
            <?php echo $url; ?>
          </div>
        </div>

        <?php endif ?>
      </div>

    <?php echo form_close(); ?><!-- form close -->
  </div>
</div>
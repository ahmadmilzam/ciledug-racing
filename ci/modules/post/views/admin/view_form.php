<div class="row">
  <div class="col-xs-12">

    <!-- form class row -->
    <?php echo form_open_multipart('admin/post/form'.$id_post, array('class'=>'row')); ?>
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
          <div class="form-group">
            <label>
              Post Title
              <small>: Required</small>
            </label>
            <?php echo form_input($input_name); ?>
          </div>
          <div class="form-group">
            <label>
              Post Excerpt
              <small>: Required</small>
            </label>
            <?php echo form_textarea($input_excerpt); ?>
          </div>
          <div class="form-group">
            <label>
              Post Description
              <small>: Required</small>
            </label>
            <?php echo form_textarea($input_description); ?>
          </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
          <label>
            Post Slug
            <small>: Optional</small>
          </label>
          <?php echo form_input($input_slug); ?>
        </div>
        <div class="form-group">
          <label>
            Post Category
            <small>: Required</small>
          </label>
          <?php
          $data = array(''=>'Select Category');
          foreach($dropdown_categories as $cat)
          {
              //$cat_menu['category']->slug
              $data[$cat->id_category] = $cat->name;
          }
          echo form_dropdown('category_id', $data, $id_category, 'class="form-control"');
          ?>
        </div>
        <div class="form-group">
          <label>
            Post Publish Date
            <small>: Required</small>
          </label>
          <?php echo form_input($input_pubdate); ?>
        </div>
        <div class="form-group">
          <label>
            Post Thumbnail
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
    <?php echo form_close(); ?><!-- form class row -->

  </div>
</div>
<script src="<?php echo base_url('assets/admin/lib/ckeditor/ckeditor.js'); ?>"></script>

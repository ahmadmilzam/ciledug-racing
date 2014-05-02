<div class="row">
  <div class="col-xs-12">

    <!-- form class row -->
    <?php echo form_open_multipart('admin/post/form/'.$id_post, array('class'=>'row')); ?>
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
          <div class="form-group">
            <label>
              Post Title
              <small>: Required</small>
            </label>
            <?php echo form_input($input_name, set_value('title', $title)); ?>
          </div>
          <div class="form-group">
            <label>
              Post Excerpt
              <small>: Required</small>
            </label>
            <?php echo form_textarea($input_excerpt, set_value('excerpt', $excerpt)); ?>
          </div>
          <div class="form-group">
            <label>
              Post Description
              <small>: Required</small>
            </label>
            <?php echo form_textarea($input_description, set_value('description', $description)); ?>
          </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
          <label>
            Post Slug
            <small>: Optional</small>
          </label>
          <?php echo form_input($input_slug, set_value('slug', $slug)); ?>
        </div>
        <div class="form-group">
          <label>
            Post Category
            <small>: Required</small>
          </label>
          <?php
          echo form_dropdown('id_category', $dropdown_categories, $id_category, 'class="form-control" required="required"');
          ?>
        </div>
        <div class="form-group">
          <label>
            Post Publish Date
            <small>: Required</small>
          </label>
          <?php echo form_input($input_pubdate, set_value('pubdate', $pubdate)); ?>
        </div>
        <div class="form-group">
          <label>
            Post Thumbnail
            <small>: Required (max size: 1MB)</small>
          </label> <br>
          <?php echo form_upload($input_file); ?>
        </div>
        <?php if(!empty($thumbnail)): ?>
        <div class="form-group">
          <label>
            Current Thumbnail
          </label> <br>
          <div class="text-center">
            <img src="<?php echo base_url('media/post/thumb/'.$thumbnail); ?>" class="img-rounded">
          </div>
        </div>
        <?php endif; ?>
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

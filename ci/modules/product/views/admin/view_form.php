<div class="row">
  <div class="col-xs-12">
    <h2><?php echo $id_product ? 'Edit Product : '.$name : 'Add New Product' ?></h2>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
      <li class="active"><a href="#detail-tab" data-toggle="tab">Details</a></li>
      <li><a href="#image-tab" data-toggle="tab">Images</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
      <div class="tab-pane active" id="detail-tab">
        <!-- form class row -->
        <?php echo form_open('admin/product/form'.$id_product, array('class'=>'row')); ?>
          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
              <div class="form-group">
                <?php echo form_label('Product name'); ?>
                <?php echo form_input($input_name); ?>
              </div>
              <div class="form-group">
                <?php echo form_label('Product slug'); ?>
                <?php echo form_input($input_slug); ?>
              </div>
              <div class="form-group">
                <?php echo form_label('Product description'); ?>
                <?php echo form_textarea($input_description); ?>
              </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
              <?php echo form_label('Product excerpt'); ?>
              <?php echo form_textarea($input_excerpt); ?>
            </div>
            <div class="form-group">
              <?php echo form_label('Product price'); ?>
              <?php echo form_input($input_slug); ?>
            </div>
            <div class="form-group">
              <?php echo form_label('Product category'); ?>
              <?php echo form_dropdown('category_id', $input_dropdown_categories, $id_category, 'class="form-control"');?>
            </div>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top">
            <div class="form-group">
              <?php echo form_button($submit_button); ?>
            </div>
          </div>
        <?php echo form_close(); ?><!-- form class row -->
      </div>
      <div class="tab-pane" id="image-tab">
        <div class="row">
          <div class="col-lg-12">
            <?php echo form_upload($input_file); ?>
            <?php echo form_button($upload_button); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url('assets/themes/admin/js/plugins/ckeditor/ckeditor.js'); ?>"></script>

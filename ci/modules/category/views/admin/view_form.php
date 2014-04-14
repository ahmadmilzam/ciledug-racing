<div class="row">
  <div class="col-xs-12">
    <h2><?php echo $id_category ? 'Edit Category : '.$name : 'Add New Category' ?></h2>
    <!-- form class row -->
    <?php echo form_open('admin/category/form/product/'.$id_category, array('class'=>'row')); ?>
      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 margin-top">
          <div class="form-group">
            <?php echo form_label('Category name'); ?>
            <?php echo form_input($input_name); ?>
          </div>
          <div class="form-group">
            <?php echo form_label('Category slug'); ?>
            <?php echo form_input($input_slug); ?>
          </div>
          <div class="form-group">
            <?php echo form_label('Category parent'); ?>
            <?php echo form_dropdown('id_parent', $input_dropdown_categories, $id_parent, 'class="form-control"'); ?>
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
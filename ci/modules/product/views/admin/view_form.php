<div class="row">
  <div class="col-xs-12">
    <h2><?php echo $id_product ? 'Edit Product : '.$name : 'Add New Product' ?></h2>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
      <li class="active"><a href="#detail-tab" data-toggle="tab">Details</a></li>
      <li><a href="#image-tab" data-toggle="tab">Images</a></li>
    </ul>

    <!-- Tab panes -->
    <?php echo form_open('admin/product/form'.$id_product, array('id'=>'product-form')); ?><!-- form open -->
    <div class="tab-content"><!-- tab content -->

      <div class="tab-pane active" id="detail-tab"><!-- product detail tab -->

        <div class="row">
          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
              <div class="form-group">
                <?php echo form_label('Product name'); ?>
                <?php echo form_input($input_name, set_value('name', $name)); ?>
              </div>
              <div class="form-group">
                <?php echo form_label('Product excerpt'); ?>
                <?php echo form_textarea($input_excerpt, set_value('excerpt', $excerpt)); ?>
              </div>
              <div class="form-group">
                <?php echo form_label('Product description'); ?>
                <?php echo form_textarea($input_description, set_value('description', $description)); ?>
              </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
              <?php echo form_label('Product slug'); ?>
              <?php echo form_input($input_slug, set_value('slug', $slug)); ?>
            </div>

            <div class="form-group">
              <?php echo form_label('Product price'); ?>
              <?php echo form_input($input_price, set_value('price', $price)); ?>
            </div>
            <div class="form-group">
              <?php echo form_label('Product category'); ?>
              <?php echo form_dropdown('category_id', $input_dropdown_categories, $id_category, 'class="form-control" required="required"');?>
            </div>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top">
            <div class="form-group">
              <?php echo form_button($submit_button); ?>
            </div>
          </div>
        </div>

      </div><!-- end product detail tab -->

      <div class="tab-pane" id="image-tab"><!-- product img tab -->

        <div class="row">
          <div class="col-lg-12 ajaxfileupload-form">
            <?php echo form_upload($input_file); ?>
            <?php echo form_button($upload_button); ?>
          </div>
        </div>

        <div id="product-img-list">
          <?php if (isset($images) && is_array($images) && count($images) > 0): ?><!-- if condition 1 -->

            <?php foreach($images as $img_id => $img_obj): ?><!-- foreach loop -->

              <?php if (!empty($img_obj)): $img = (array)$img_obj;?><!-- if condition 2 -->

                <div class="row product-img-row" id="img_<?php echo $img_id;?>" ><!-- per product -->

                  <div class="col-lg-2 col-md-3 col-xs-12">
                    <a href="#" class="thumbnail">
                      <input type="hidden" name="images[<?php echo $img_id; ?>][filename]" value="<?php echo $img['filename']; ?>">
                      <img src="<?php echo base_url('media/product/thumb/'.$img['filename']); ?>" alt="<?php echo $img['alt'];?>">
                    </a>
                  </div>

                  <div class="col-lg-10 col-md-9 col-xs-12">
                    <div class="form-group">
                      <label>Alt Tag:</label>
                      <input class="form-control" type="text" name="images[<?php echo $img_id;?>][alt]" placeholder="Alt tag" value="<?php echo $img['alt'];?>">
                    </div>
                    <div class="form-group">
                      <label>Caption:</label>
                      <textarea class="form-control" rows="3" name="images[<?php echo $img_id;?>][caption]" class="input-wide" placeholder="Caption"><?php echo $img['caption'];?></textarea>
                    </div>
                  </div>

                  <div class="col-xs-12 text-right">
                    <label class="radio-inline">
                      <input type="radio" id="primary_image_<?php echo $img_id;?>" name="primary" value="<?php echo $img_id;?>" <?php if(isset($img['primary'])) echo 'checked="checked"';?>> Main Image
                    </label>
                    <a href="<?php echo base_url('admin/media/unlink/product'); ?>" class="btn btn-danger js-delete-img margin-left" data-filename="<?php echo $img['filename']; ?>" data-id="<?php echo $img_id;?>"><i class="fa fa-trash-o"></i> Delete</a>
                  </div>

                </div><!-- per product -->

              <?php endif ?><!-- end if condition 2 -->

            <?php endforeach ?><!-- end foreach loop -->

          <?php endif ?><!-- end if condition 1 -->

        </div>

      </div><!-- end product img tab -->

    </div><!-- end tab content -->
    <?php echo form_close(); ?><!-- form close -->
  </div>
</div>
<script src="<?php echo base_url('assets/'.$this->template->get_theme().'/lib/ckeditor/ckeditor.js'); ?>"></script>

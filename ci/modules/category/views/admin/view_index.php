<div class="row">
  <div class="col-xs-12">
    <a href="<?php echo base_url('admin/category/form/'.$this->uri->segment(4)); ?>" class="btn btn-default btn-lg margin-bottom"><i class="fa fa-plus"></i> Add New Category</a>
    <?php echo simple_tree_builder($categories, '&nbsp;', $this->uri->segment(4) ); ?>
  </div>
</div>
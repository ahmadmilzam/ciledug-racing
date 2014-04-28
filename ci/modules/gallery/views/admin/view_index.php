<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12 ">
      <div class="btn-group margin-bottom">
        <!-- Button Color Classes: [secondary alert success] -->
        <?php echo anchor('admin/gallery/dropzone/', 'Add New Image <i class="fa fa-plus-circle"></i>', array('class'=>'btn btn-default btn-lg'))?>
      </div>

      <ul class="small-block-grid-1 medium-block-grid-3 large-block-grid-4 gallery-grid cs-style">
      <?php if (count($images) > 0): ?>

        <?php foreach ($images as $img): ?>
        <li>
          <figure>
            <img src="<?php echo base_url('media/gallery/thumb/'.$img->filename); ?>" alt="<?php echo $img->alt; ?>">
            <figcaption>
                <h3 class="alt"><?php echo word_limiter($img->caption, 4); ?></h3>
                <a class="label label-info pull-left" href="<?php echo base_url('admin/gallery/form/'.$img->id_img); ?>">Edit detail</a>
                <a class="label label-danger pull-right js-confirm-delete" href="<?php echo base_url('admin/gallery/delete/'.$img->id_img); ?>">Delete</a>
            </figcaption>
          </figure>
        </li>
        <?php endforeach ?>
      <?php else: ?>
        <li>Sorry, we could not found any images</li>
      <?php endif ?>
      </ul>

    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12 ">
        <?php echo $pagination; ?>
    </div>
</div>
<!--
<?php //foreach ($ as $): ?>

<?php //endforeach ?>
-->

<!-- Main row -->
<div class="row">
  <!-- Left col -->
  <section class="col-lg-6 connectedSortable">

    <!-- Box Product -->
    <div class="box box-default">
      <div class="box-header">
        <!-- tools box -->
        <div class="pull-right box-tools">
          <button class="btn btn-danger btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-danger btn-sm" data-widget='remove' data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
        </div><!-- /. tools -->
        <i class="fa fa-laptop"></i>

        <h3 class="box-title">Recent Products</h3>
      </div><!-- /.box-header -->
      <div class="box-body no-padding">
        <div class="row">
          <div class="col-sm-12">

            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                <?php if (isset($products) && count($products) > 0): ?>
                  <?php foreach ($products as $product): ?>
                    <tr>
                      <td><?php echo word_limiter($product->name, 7); ?></td>
                      <td><?php echo 'Rp. ' . number_format( $product->price, 0 , '' , '.' ) . ',-'; ?></td>
                      <th class="text-right"><?php echo button_edit(base_url('admin/product/form/'.$product->id_product)); ?></th>
                    </tr>
                  <?php endforeach ?>
                <?php else: ?>
                  <tr>
                    <td colspan="3">We could not find any product</td>
                  </tr>
                <?php endif ?>
                </tbody>
              </table>
            </div>

          </div>
        </div><!-- /.row - inside box -->
      </div><!-- /.box-body -->
      <div class="box-footer">
        <div class="row">
          <div class="col-xs-12 text-center">
          </div><!-- ./col -->
        </div><!-- /.row -->
      </div><!-- /.box-footer -->
    </div><!-- /.box -->

    <!-- Box Post -->
    <div class="box box-danger">
      <div class="box-header">
        <!-- tools box -->
        <div class="pull-right box-tools">
          <button class="btn btn-danger btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-danger btn-sm" data-widget='remove' data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
        </div><!-- /. tools -->
        <i class="fa fa-code"></i>

        <h3 class="box-title">Recent Posts</h3>
      </div><!-- /.box-header -->
      <div class="box-body no-padding">
        <div class="row">
          <div class="col-sm-12">

            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Publish date</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                <?php if (isset($posts) && count($posts) > 0): ?>
                  <?php foreach ($posts as $post): ?>
                    <tr>
                      <td><?php echo word_limiter($post->title, 7); ?></td>
                      <td><?php echo date('d M Y', strtotime($post->pubdate)); ?></td>
                      <th class="text-right"><?php echo button_edit(base_url('admin/post/form/'.$post->id_post)); ?></th>
                    </tr>
                  <?php endforeach ?>
                <?php else: ?>
                  <tr>
                    <td colspan="3">We could not find any posts</td>
                  </tr>
                <?php endif ?>
                </tbody>
              </table>
            </div>

          </div>
        </div><!-- /.row - inside box -->
      </div><!-- /.box-body -->
      <div class="box-footer">
        <div class="row">
          <div class="col-xs-12 text-center">
          </div><!-- ./col -->
        </div><!-- /.row -->
      </div><!-- /.box-footer -->
    </div><!-- /.box -->

  </section><!-- /.Left col -->

  <!-- right col (We are only adding the ID to make the widgets sortable)-->
  <section class="col-lg-6 connectedSortable">

    <!-- Box -->
    <div class="box box-info">
      <div class="box-header">
        <!-- tools box -->
        <div class="pull-right box-tools">
          <button class="btn btn-danger btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-danger btn-sm" data-widget='remove' data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
        </div><!-- /. tools -->
        <i class="fa fa-cloud"></i>

        <h3 class="box-title">Video</h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-sm-12">
            <?php if (isset($video) && count($video) > 0): ?>
              <div class="flex-video">
                <?php echo $video[0]->url; ?>
              </div>
            <?php else: ?>
              We could not find any video.
            <?php endif ?>
          </div>
        </div><!-- /.row - inside box -->
      </div><!-- /.box-body -->
      <div class="box-footer">
        <div class="row">
          <div class="col-xs-12 text-center">
          </div><!-- ./col -->
        </div><!-- /.row -->
      </div><!-- /.box-footer -->
    </div><!-- /.box -->

    <!-- Box banner -->
    <div class="box box-primary">
      <div class="box-header">
        <!-- tools box -->
        <div class="pull-right box-tools">
          <button class="btn btn-danger btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-danger btn-sm" data-widget='remove' data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
        </div><!-- /. tools -->
        <i class="fa fa-bar-chart-o"></i>

        <h3 class="box-title">Recent Banner</h3>
      </div><!-- /.box-header -->
      <div class="box-body no-padding">
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Enable date</th>
                    <th>Disable date</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                <?php if (isset($banners) && count($banners) > 0): ?>
                  <?php foreach ($banners as $banner): ?>
                    <tr>
                      <td><?php echo word_limiter($banner->title, 7); ?></td>
                      <td><?php echo date('d M Y', strtotime($banner->enable_on)); ?></td>
                      <td><?php echo date('d M Y', strtotime($banner->disable_on)); ?></td>
                      <th class="text-right"><?php echo button_edit(base_url('admin/banner/form/'.$banner->id_banner)); ?></th>
                    </tr>
                  <?php endforeach ?>
                <?php else: ?>
                  <tr>
                    <td colspan="4">We could not find any banners</td>
                  </tr>
                <?php endif ?>
                </tbody>
              </table>
            </div>
          </div>
        </div><!-- /.row - inside box -->
      </div><!-- /.box-body -->
      <div class="box-footer">
        <div class="row">
          <div class="col-xs-12 text-center">
          </div><!-- ./col -->
        </div><!-- /.row -->
      </div><!-- /.box-footer -->
    </div><!-- /.box -->

  </section><!-- right col -->
</div><!-- /.row (main row) -->

<!-- bottom row -->
<div class="row">
  <div class="col-xs-12">

    <!-- Box -->
    <div class="box box-warning">
      <div class="box-header no-move">
        <!-- tools box -->
        <div class="pull-right box-tools">
          <button class="btn btn-danger btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-danger btn-sm" data-widget='remove' data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
        </div><!-- /. tools -->
        <i class="fa fa-picture-o"></i>

        <h3 class="box-title">Recent Gallery</h3>
      </div><!-- /.box-header -->
      <div class="box-body no-padding">
        <div class="row">
          <div class="col-sm-12">
            <ul class="small-block-grid-1 medium-block-grid-3 large-block-grid-4 gallery-grid cs-style">
            <?php if (count($images) > 0): ?>

              <?php foreach ($images as $img): ?>
              <li>
                <figure>
                  <img src="<?php echo base_url('media/gallery/thumb/'.$img->filename); ?>">
                  <figcaption>
                    <h3 class="alt"><?php echo word_limiter($img->caption, 4); ?></h3>
                    <a class="label label-info pull-right" href="<?php echo base_url('admin/gallery/form/'.$img->id_img); ?>">Edit detail</a>
                  </figcaption>
                </figure>
              </li>
              <?php endforeach ?>
            <?php else: ?>
              <li>Sorry, we could not found any images</li>
            <?php endif ?>
            </ul>
          </div>
        </div><!-- /.row - inside box -->
      </div><!-- /.box-body -->
      <div class="box-footer">
        <div class="row">
          <div class="col-xs-12 text-center">
          </div><!-- ./col -->
        </div><!-- /.row -->
      </div><!-- /.box-footer -->
    </div><!-- /.box -->

  </div><!-- /.col -->
</div>
<!-- /.row -->

<?php if(isset($users) && count($users) > 0): ?>
<div class="row">
  <div class="col-xs-12">

    <!-- Box -->
    <div class="box box-warning">
      <div class="box-header no-move">
        <!-- tools box -->
        <div class="pull-right box-tools">
          <button class="btn btn-danger btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-danger btn-sm" data-widget='remove' data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
        </div><!-- /. tools -->
        <i class="fa fa-users"></i>

        <h3 class="box-title">Recent Users</h3>
      </div><!-- /.box-header -->
      <div class="box-body no-padding">
        <div class="row">
          <div class="col-sm-12">

            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Email</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                <?php if (isset($users) && count($users) > 0): ?>
                  <?php foreach ($users as $user): ?>
                    <tr>
                      <td><?php echo $user->first_name; ?></td>
                      <td><?php echo $user->last_name; ?></td>
                      <td><?php echo $user->email; ?></td>
                      <td class="text-right">
                        <?php echo button_edit(base_url('admin/user/form/'.$user->id)); ?>
                      </td>
                    </tr>
                  <?php endforeach ?>
                <?php else: ?>
                  <tr>
                    <td colspan="4">We could not find any user</td>
                  </tr>
                <?php endif ?>
                </tbody>
              </table>
            </div>

          </div>
        </div><!-- /.row - inside box -->
      </div><!-- /.box-body -->
      <div class="box-footer">
        <div class="row">
          <div class="col-xs-12 text-center">
          </div><!-- ./col -->
        </div><!-- /.row -->
      </div><!-- /.box-footer -->
    </div><!-- /.box -->

  </div>
</div>
<?php endif; ?>
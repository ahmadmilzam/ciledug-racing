<div class="row">
    <div class="col-xs-12">
        <form class="form-inline pull-right" action="<?php echo base_url('admin/post/index') ?>" method="post">
            <input type="hidden" name="search" value="1">
            <input type="text" name="title" class="form-control" placeholder="Search for post title">
            <button type="submit" name="submit" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
            <a href="<?php echo base_url('admin/post'); ?>" title="Reset search result" class="btn btn-default">Reset</a>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12 ">
        <div class="btn-group margin-bottom">
            <!-- Button Color Classes: [secondary alert success] -->
            <?php echo anchor('admin/post/form/', 'Create New Post <i class="fa fa-plus-circle"></i>', array('class'=>'btn btn-default btn-lg'))?>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Publish date</th>
                        <th>Created by</th>
                        <th>Created at</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
            <?php if(count($posts) && is_array($posts)):foreach($posts as $post): ?>
                    <tr>
                        <td><?php echo $post->title; ?></td>
                        <td><?php echo date('d M Y', strtotime($post->pubdate)); ?></td>
                        <td><?php echo $post->username; ?></td>
                        <td><?php echo date('d M Y', strtotime($post->created_at)); ?></td>
                        <td class="text-right">
                            <?php echo button_edit('admin/post/form/'.$post->id_post); ?>
                            <?php echo button_delete('admin/post/delete/'.$post->id_post); ?>
                        </td>
                    </tr>
            <?php endforeach; ?>
            <?php else: ?>
                    <tr>
                        <td colspan="5">We could not find any posts</td>
                    </tr>
            <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12 ">
        <?php echo $pagination; ?>
    </div>
</div>


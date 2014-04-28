<div class="row">
    <div class="col-xs-12">
        <form class="form-inline pull-right" action="<?php echo base_url('admin/product/index') ?>" method="product">
            <input type="hidden" name="search" value="1">
            <input type="text" name="name" class="form-control" placeholder="Search for product name">
            <button type="submit" name="submit" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
            <a href="<?php echo base_url('admin/product'); ?>" title="Reset search result" class="btn btn-default">Reset</a>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12 ">
        <div class="btn-group margin-bottom">
            <!-- Button Color Classes: [secondary alert success] -->
            <?php echo anchor('admin/product/form/', 'Create New Product <i class="fa fa-plus-circle"></i>', array('class'=>'btn btn-default btn-lg'))?>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Created at</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
            <?php if(count($products) && is_array($products)):foreach($products as $product): ?>
                    <tr>
                        <td><?php echo $product->name; ?></td>
                        <td><?php echo $product->price; ?></td>
                        <td><?php echo date('d M Y', strtotime($product->created_at)); ?></td>
                        <td class="text-right">
                            <?php echo button_edit('admin/product/form/'.$product->id_product); ?>
                            <?php echo button_delete('admin/product/delete/'.$product->id_product); ?>
                        </td>
                    </tr>
            <?php endforeach; ?>
            <?php else: ?>
                    <tr>
                        <td colspan="4">We could not find any products</td>
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


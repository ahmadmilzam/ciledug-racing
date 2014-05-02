<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12 ">
        <!-- Button Color Classes: [secondary alert success] -->
        <div class="margin-bottom">
            <?php echo anchor('admin/user/create_user', lang('index_create_user_link').' <i class="fa fa-plus-circle"></i>', array('class'=>'btn btn-default btn-lg'))?>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th><?php echo lang('index_fname_th');?></th>
                        <th><?php echo lang('index_lname_th');?></th>
                        <th><?php echo lang('index_email_th');?></th>
                        <th><?php echo lang('index_groups_th');?></th>
                        <th><?php echo lang('index_status_th');?></th>
                        <th><?php echo lang('index_last_login_th'); ?></th>
                        <th><?php echo lang('index_last_IP_th'); ?></th>
                        <th><?php echo lang('index_action_th');?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user):?>

                    <tr>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['first_name']; ?></td>
                        <td><?php echo $user['last_name']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td>
                            <?php foreach ($user['groups'] as $group):?>
                                <?php echo $group['group_name'];?><br>
                            <?php endforeach?>
                        </td>
                        <td>
                            <?php echo ($user['active']) ? anchor("admin/user/deactivate/".$user['id'], lang('index_active_link')) : anchor("admin/user/activate/". $user['id'], lang('index_inactive_link'));?>
                        </td>
                        <td><?php echo date('d-M-Y', $user['last_login']); ?></td>
                        <td><?php echo inet_ntop($user['ip_address']); ?></td><!-- inet_pton -->
                        <td>
                            <?php echo button_edit(base_url('admin/user/edit_user/'.$user['id'])); ?>
                            <?php if ($user['id'] != $this->session->userdata('user_id') ): ?>
                            <?php echo button_delete(base_url('admin/user/delete_user/'.$user['id'])); ?>
                            <?php endif ?>
                        </td>
                    </tr>

                <?php endforeach;?>
                </tbody>
            </table>
        </div>

        <?php echo $pagination; ?>
    </div>
</div>

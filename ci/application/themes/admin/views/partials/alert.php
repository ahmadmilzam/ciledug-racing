<!--
- Alert types :
- 1. success
- 2. info
- 3. danger
-->

<!-- 1 -->
<?php if ($this->session->flashdata('success')):?>
    <div data-alert class="alert alert-success js-alert-box-success">
        <a href="#" class="close js-alert-box-close" data-dismiss="alert">&times;</a>
        <p class="text-large text-bold">Well done!</p>
        <ul class="alert-list">
            <?php echo $this->session->flashdata('success');?>
        </ul>
    </div>
<?php endif;?>

<!-- 2 -->
<?php if ($this->session->flashdata('info')):?>
    <div data-alert class="alert alert-info radius">
        <a href="#" class="close js-alert-box-close" data-dismiss="alert">&times;</a>
        <p class="text-large text-bold">Heads up!</p>
        <ul class="alert-list">
            <?php echo $this->session->flashdata('info');?>
        </ul>
    </div>
<?php endif;?>

<!-- 3 -->
<?php if( (function_exists('validation_errors') && validation_errors() != '') OR $this->session->flashdata('error')): ?>
    <div data-alert class="alert alert-danger alert radius">
        <a href="#" class="close js-alert-box-close" data-dismiss="alert">&times;</a>
        <p class="text-large text-bold">Oh snap! You got an error(s)!</p>
        <?php if (function_exists('validation_errors') && validation_errors() != ''): ?>
        <?php echo $this->form_validation->validation_errors_list(); ?>

        <?php else: ?>
        <p>
            <?php echo $this->session->flashdata('error');?>
        </p>
        <?php endif ?>
    </div>
<?php endif;?>
<?php if(function_exists('display_errors') && display_errors() != ''): ?>
    <div data-alert class="alert alert-danger alert radius">
        <a href="#" class="close js-alert-box-close" data-dismiss="alert" aria-hidden="true">&times;</a>
        <p class="text-large text-bold">Oh snap! You got an error(s)!</p>
        <ul class="alert-list">
            <?php echo display_errors();?>
        </ul>
    </div>
<?php endif;?>
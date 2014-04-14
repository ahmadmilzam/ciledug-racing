<?php if ($this->session->flashdata('success')):?>
    <div data-alert class="alert-box success  js-alert-box-success">
        <a href="#" class="close   js-alert-box-close">&times;</a>
        <p class="text-large text-bold">Well done!</p>
        <ul class="alert-list">
            <?php echo $this->session->flashdata('success');?>
        </ul>
    </div>
<?php endif;?>

<?php if ($this->session->flashdata('info')):?>
    <div data-alert class="alert-box radius">
        <a href="#" class="close  js-alert-box-close">&times;</a>
        <p class="text-large text-bold">Heads up!</p>
        <ul class="alert-list">
            <?php echo $this->session->flashdata('info');?>
        </ul>
    </div>
<?php endif;?>

<?php if( (function_exists('validation_errors') && validation_errors() != '') OR $this->session->flashdata('error')): ?>
    <div data-alert class="alert-box alert radius">
        <a href="#" class="close  js-alert-box-close">&times;</a>
        <p class="text-large text-bold">Oh snap! You got an error!</p>
        <?php if (function_exists('validation_errors') && validation_errors() != ''): ?>
        <ul class="alert-list">
            <?php echo validation_errors();?>
        </ul>
        <?php else: ?>
        <ul class="alert-list">
            <?php echo $this->session->flashdata('error');?>
        </ul>
        <?php endif ?>
    </div>
<?php endif;?>

<?php if(function_exists('display_errors') && display_errors() != ''): ?>
    <div data-alert class="alert-box alert radius">
        <a href="#" class="close  js-alert-box-close">&times;</a>
        <p class="text-large text-bold">Oh snap! You got an error!</p>
        <ul class="alert-list">
            <?php echo display_errors();?>
        </ul>
    </div>
<?php endif;?>
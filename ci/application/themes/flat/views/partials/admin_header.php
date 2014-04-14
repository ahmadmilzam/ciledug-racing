<div class="bar bar--top"><!-- bar -->
    <a href="javascript:;" class="burger-icon" id="js-toggle-menu"><span></span></a>
    <div class="bar__title"><!-- page-title -->
        <?php echo $active_page; ?>
    </div><!-- page-title -->

</div><!-- bar -->

<!-- Show alert if exist-->
<div class="row">
    <div class="small-12 medium-12 large-12 columns">
        <?php echo $this->breadcrumb->output(); ?>
        <?php echo $this->template->load_view('partials/alert'); ?>
    </div>
</div>
<!-- //Show alert if exist-->
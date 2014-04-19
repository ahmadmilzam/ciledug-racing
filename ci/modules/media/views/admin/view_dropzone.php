<div class="row">
  <div class="col-lg-12">
    <form action="<?php echo base_url('admin/media/upload') ?>" id="dropzoneDiv" class="dropzone">
      <div class="fallback">
        <input name="file" type="file" multiple />
      </div>
      <div class="dropzone-additional-input">
        <label>Select Media Gallery Type:</label>
        <select name="category" class="form-control">
          <option value="product">Product</option>
          <option value="gallery">Gallery</option>
          <option value="images">Article</option>
        </select>
        <br>
        <div class="row">
          <div class="col-lg-12">
            Available media type:
            <ol class="number-list">
              <li>Product image</li>
              <li>Gallery image</li>
              <li>Article image</li>
            </ol>
            <strong>Max. file size 1MB.</strong>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
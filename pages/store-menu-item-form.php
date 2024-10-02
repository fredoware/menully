<?php
  include "templates/header-store.php";
  $Id = get_query_string("Id","");
  if ($Id) {
    $item = menuItem()->get("Id=$Id");
    $varationList = variation()->list("itemId=$Id");
  }

  
  $categoryList = menuCategory()->list("storeId=$store->Id");

?>

  <section>
    <div class="container">

      <div class="menu-item-header">
        <div class="row">
          <div class="col-2 mih-left" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
          </div>
          <div class="col mih-center">
            <h6>Item Form</h6>
          </div>
          <div class="col-2 mih-right" data-bs-toggle="modal" data-bs-target="#menuCategory">
          </div>
        </div>
      </div>



      <form action="process.php?action=item-save" method="post" enctype="multipart/form-data">

      <input type="hidden" name="Id" value="<?=$Id?>">
      <input type="hidden" name="storeId" value="<?=$store->Id?>">

<div class="row">
<div class="col-lg-8 ">
  <div class="card mt-2">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-7">

      </div>
        <div class="mb-4">
          <label class="form-label">Product Name <span class="text-danger">*</span>
          </label>
          <input type="text" name="name" id="form-name" class="form-control" placeholder="Product Name" required>
        </div>
        <div>
          <label class="form-label">Description</label>
          <textarea name="description" id="editor" required>
          </textarea>
        </div>
    </div>
  </div>

  <div class="card mt-2">
    <div class="card-body">
      <h4 class="card-title mb-7">Pricing</h4>

        <div class="mb-7">
          <div class="row" id="varationDiv"></div>

            <button onclick="addVariation()" type="button" class="btn btn-warning mt-2">Add Variation</button>


        </div>
    </div>
  </div>




</div>
<div class="col-lg-4">
  <div>
    <div class="card mt-2">
      <div class="card-body">
      <label class="form-label">Thumbnail</label>

        <input accept="image/*" style="opacity:0;height:1px;" name="image" type='file' id="imgInp"/>
        <img id="product" src="../templates/product-upload.png" onclick="upload_product()" style="width:100%" alt="">

      </div>
    </div>

    <div class="card mt-2">
      <div class="card-body">
        <h4 class="card-title mb-7">Product Details</h4>
        <div class="mb-3">


        <label class="form-label">Category</label>
          <select name="menuCategoryId" id="form-category" class="form-select mr-sm-2 mb-1" required>
            <option value="">--Select--</option>
            <?php foreach ($categoryList as $row): ?>
              <option value="<?=$row->Id?>"><?=$row->name?></option>
            <?php endforeach; ?>
          </select>


          <label class="form-label">Availability</label>
          <select name="status" id="form-status" class="form-select mr-sm-2  mb-1">
          <option value="">--Select--</option>
            <option>Available</option>
            <option>Not Available</option>
          </select>


        </div>

      </div>
    </div>
  </div>
</div>
</div>


<div class="form-actions mt-3">
<button type="submit" name="form-type" id="submit-add" value="add" class="btn btn-primary">
  Save changes
</button>
<button type="submit" name="form-type" id="submit-edit" value="edit" class="btn btn-primary">
  Save changes
</button>
<button onclick="history.back()" type="button" class="btn bg-danger-subtle text-danger ms-6">
  Cancel
</button>
</div>

</form>

<?php include "templates/footer.php"; ?>


<script>

  
var objTo = document.getElementById('varationDiv');

  // Upload product image ==========================================================
imgInp.onchange = evt => {
  const [file] = imgInp.files
  if (file) {
    product.src = URL.createObjectURL(file)
  }
}


function upload_product(){
  imgInp.click(function () {
      fileupload.click();
  });
}


  
// Text area text editor =======================================================
ClassicEditor
  .create(document.querySelector('#editor'), {

    toolbar: ['heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote']
  })
  .then(editor => {
    theEditor = editor;

  })
  .catch(error => {
    console.error(error);
  });

  // Add varation =============================================================


  <?php if ($Id): ?>
  $('#submit-add').hide();
  $('#submit-edit').show();

  $('#form-name').val("<?=$item->name?>");
  $('#editor').val("<?=htmlspecialchars_decode($item->description)?>");
  $('#form-category').val("<?=$item->menuCategoryId?>");
  $('#form-status').val("<?=$item->status?>");
  product.src = "../media/<?=$item->image;?>";



<?php foreach ($varationList as $row): ?> 
var divtest = document.createElement("div");
  divtest.innerHTML = '<div class="row mt-2"><div class="col"><input type="hidden" name="variationId[]"  value="<?=$row->Id?>" /><input class="form-control" id="form-unit" name="unit[]" value="<?=$row->unit?>"  placeholder="Unit" required /></div><div class="col"><input class="form-control"  value="<?=$row->price?>"  id="form-price" name="price[]" placeholder="Item Price" required step=".01" type="number" /></div><div class="col-2 pt-4"></div></div>';
objTo.appendChild(divtest)
 <?php endforeach; ?>


<?php else: ?>

var divtest = document.createElement("div");
  divtest.innerHTML = '<div class="row mt-2"><div class="col"><input type="hidden" name="variationId[]" value="Item" /><input class="form-control" id="form-unit" name="unit[]" placeholder="Unit" required /></div><div class="col"><input class="form-control" id="form-price" name="price[]" placeholder="Item Price" required step=".01" type="number" /></div><div class="col-2 pt-4"></div></div>';
objTo.appendChild(divtest)

// Add product ===============================================================
  $('#submit-add').show();
  $('#submit-edit').hide();
<?php endif; ?>

  


function addVariation() {
  var divtest = document.createElement("div");
  divtest.innerHTML = '<div class="row mt-2"><div class="col"><input type="hidden" name="variationId[]" /><input class="form-control" id="form-unit" name="unit[]" placeholder="Unit" required /></div><div class="col"><input class="form-control" id="form-price" name="price[]" placeholder="Item Price" required step=".01" type="number" /></div><div class="col-2"><a href="javascript:void(0)" onclick="removeVariation(this)" class="btn btn-danger"><i class="bi bi-trash"></i></a></div></div>';
    objTo.appendChild(divtest)
}

function removeVariation(e) {
  e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode);
}



</script>
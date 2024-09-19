<?php
  include "templates/header.php";

  $role = $_GET['role'];
  $account_list = account()->list("role='$role' and isDeleted=0");
?>


      <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
          <div class="row align-items-center">
            <div class="col-9">
              <h4 class="fw-semibold mb-8"><?=$role;?></h4>
              <!-- <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a class="text-muted " href="">Accounts</a></li>
                  <li class="breadcrumb-item" aria-current="page"><?=$role;?></li>
                </ol>
              </nav> -->
            </div>
            <div class="col-3">
              <div class="text-center mb-n5">
                <img src="../../dist/images/breadcrumb/ChatBc.png" alt="" class="img-fluid mb-n4">
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="widget-content searchable-container list">
        <!-- --------------------- start Contact ---------------- -->
        <div class="card card-body">
          <div class="row">
            <div class="col-md-4 col-xl-3">
              <form class="position-relative">
                <input type="hidden" name="role" value="<?=$role?>">
                <input type="text" onkeydown="return (event.keyCode!=13);" class="form-control product-search ps-5" id="input-search" placeholder="Search <?=$role?>..." />
                <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
              </form>
            </div>
            <div class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
              <a href="javascript:void(0)" id="btn-add-contact" class="btn btn-info d-flex align-items-center">
                <i class="ti ti-users text-white me-1 fs-5"></i> Add <?=$role;?>
              </a>
            </div>
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addContactModal" tabindex="-1" role="dialog" aria-labelledby="addContactModalTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header d-flex align-items-center">
                <h5 class="modal-title"><?=$role;?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="process.php?action=account-save" id="addContactModalTitle" method="post">
              <div class="modal-body">
                <div class="add-contact-box">
                  <div class="add-contact-content">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="mb-3 contact-name">
                          <input type="hidden" name="Id" id="c-id"/>
                          <input type="hidden" name="role" value="<?=$role;?>"/>
                          <input type="text" name="username" id="c-username" class="form-control" placeholder="Username" required/>
                          <span class="validation-text text-danger"></span>
                        </div>
                      </div>
                      <div class="col-md-4 col-password">
                        <div class="mb-3 contact-name">
                          <input type="text" id="c-display-password" class="form-control" placeholder="Password" disabled/>
                          <input type="hidden" name="password" id="c-password" class="form-control" placeholder="Password" required/>
                          <span class="validation-text text-danger"></span>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="mb-3 contact-name">
                          <input type="text" name="name" id="c-name" class="form-control" placeholder="Full Name" required/>
                          <span class="validation-text text-danger"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button name="form-type" value="add" id="btn-add" class="btn btn-success rounded-pill px-4">Add</button>
                <button name="form-type" value="edit" id="btn-edit" class="btn btn-success rounded-pill px-4">Save</button>
                <button class="btn btn-danger rounded-pill px-4" data-bs-dismiss="modal"> Discard </button>
              </div>
            </form>
            </div>
          </div>
        </div>
        <div class="card card-body">
          <div class="table-responsive" style="min-height:300px;">
            <table class="table search-table align-middle text-nowrap">
              <thead class="header-item">
                <th>Username</th>
                <th>Full Name</th>
                <th>Date Added</th>
                <th width="10%">Action</th>
              </thead>
              <tbody>
                <!-- start row -->

                <?php
                $count = 0;
                foreach ($account_list as $row):
                  $count += 1;
                   ?>

                <tr class="search-items">
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="ms-3">
                        <div class="user-meta-info">
                          <h6 class="user-name mb-0"
                          data-id="<?=$row->Id;?>"
                          data-username="<?=$row->username;?>"
                           data-name="<?=$row->name;?>"
                           data-password="<?=$row->password;?>"
                           data-status="<?=$row->status;?>"
                          ><?=$count;?>. <?=$row->username;?></h6>
                        </div>
                      </div>
                    </div>
                  </td>
                    <td>
                      <div class="d-flex align-items-center">
                        <div class="ms-3">
                          <div class="user-meta-info">
                            <h6 class="mb-0"><?=$row->name;?></h6>
                          </div>
                        </div>
                      </div>
                    </td>
                      <td>
                        <div class="d-flex align-items-center">
                          <div class="ms-3">
                            <div class="user-meta-info">
                              <h6 class="mb-0"><?=format_date($row->dateAdded);?></h6>
                            </div>
                          </div>
                        </div>
                      </td>
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item text-bg-primary edit" href="javascript:void(0)">Edit</a></li>
                        <!-- <li><a class="dropdown-item text-bg-danger" href="process.php?action=account-delete&Id=<?=$row->Id?>&url=<?=$current_url?>">Delete</a></li> -->
                        <li><button class="dropdown-item text-bg-danger" onclick="deleteNotification('process.php?action=account-delete&Id=<?=$row->Id?>&url=<?=$current_url?>')">Delete</button></li>
                      
                      </ul>
                    </div>
                  </td>
                </tr>
                <!-- end row -->

              <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <?php include "templates/footer.php"; ?>


<script type="text/javascript">
$(function () {

    $("#input-search").on("keyup", function () {
      var rex = new RegExp($(this).val(), "i");
      $(".search-table .search-items:not(.header-item)").hide();
      $(".search-table .search-items:not(.header-item)")
        .filter(function () {
          return rex.test($(this).text());
        })
        .show();
    });

    $("#btn-add-contact").on("click", function (event) {

      var $_username = document.getElementById("c-username");
      $_username.value = "";

      var $_generatedpw = Math.floor(Math.random()*899999+100000);

      var $_password = document.getElementById("c-password");
      $_password.value = $_generatedpw;

      var $_dpassword = document.getElementById("c-display-password");
      $_dpassword.value = $_generatedpw;

      $("#addContactModal #btn-add").show();
      $("#addContactModal #btn-edit").hide();
      $("#addContactModal").modal("show");
    });


    function editContact() {
      $(".edit").on("click", function (event) {
        $("#addContactModal #btn-add").hide();
        $("#addContactModal #btn-edit").show();

        // Get Parents
        var getParentItem = $(this).parents(".search-items");
        var getModal = $("#addContactModal");

        // Get List Item Fields
        var $_name = getParentItem.find(".user-name");
        // Set Modal Field's Value
        getModal.find("#c-id").val($_name.attr("data-id"));
        getModal.find("#c-username").val($_name.attr("data-username"));
        getModal.find("#c-name").val($_name.attr("data-name"));
        if ($_name.attr("data-status")=="Inactive") {
          getModal.find("#c-display-password").val($_name.attr("data-password"));
        }
        else{
          getModal.find("#c-display-password").val("Not shown for security");
        }

        $("#addContactModal").modal("show");
      });
    }

    editContact();

  });

</script>

<?php
session_start();
include_once ("includes/config.php");
include "includes/function.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}
addTenants();
?>

<!-- Main sidebar -->
<?php
include ("includes/sidebar.php");
?>
<!-- End:Sidebar -->

<!-- Main Body-->
<div class="d2c_main p-4 ps-lg-3">

    <!-- Title -->
    <h4 class="mb-4 text-capitalize">Add Tenant</h4>
    <!-- End:Title -->

    <!-- Alert -->
    <?php
    if (isset($_SESSION['success_message_Tenant'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_message_Tenant'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['success_message_Tenant']);
    }
    if (isset($_SESSION['error_message_Tenant'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_message_Tenant'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['error_message_Tenant']);
    }
    ?>
    <!-- / Alert -->

    <form action="" method="post" id="add_houses_form" enctype="multipart/form-data">
        <div class="card h-auto">
            <div class="card-body">
                <h3 class="card-header">Information</h3>
                <hr class="my-4">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">House/Shop Number</label>
                        <select name="house_shop_id" id="house_shop_id" class="form-select form-control house-id"
                            required>
                            <option value="">--- Select House/Shop No ---</option>
                            <!-- Add your house/shop options here -->
                        </select>
                    </div>
                    <div class="col-md-6" style="display: none;">
                        <label class="form-label">House or Shop</label>
                        <select name="house_or_shop" id="house_or_shop" class="form-select form-control house-id"
                            required>
                            <option value="">--- Select House/Shop ---</option>
                            <option value="house">House</option>
                            <option value="shop">Shop</option>
                        </select>
                    </div>

                    <!-- <div class="col-md-6">
                                <label class="form-label">House/Shop Number</label>
                                <select name="house_id" id="house_id" class="form-select form-control house-id" required>
                                    <option value="">--- Select House No ---</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Owner's Name</label>
                                <select id="owner_name" class="form-select form-control">
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Owner's Contact</label>
                                <select id="owner_contact" class="form-select form-control">
                                </select>
                            </div> -->


                    <div class="col-md-6 ">
                        <label class="form-label">Tenant's Name</label>
                        <input type="text" id="tenant-name" name="tenant_name" class="form-control"
                            placeholder="Enter Tenant's Name" required>
                        <!-- <span class="text-danger" id="tenants-name_error"></span> -->
                    </div>
                    <div class="col-md-6 ">
                        <label class="form-label">Tenant's Contact Number</label>
                        <input type="number" id="tenant-contact" name="tenant_contact" class="form-control"
                            placeholder="03XXXXXXXXX">
                        <!-- <span class="text-danger" id="tenant-contact_error"></span> -->
                    </div>
                    <div class="col-md-6 ">
                        <label class="form-label">Tenant's CNIC</label>
                        <input type="number" id="tenant-contact" name="tenant_cnic" class="form-control"
                            placeholder="XXXXX-XXXXXXX-X" required>
                        <!-- <span class="text-danger" id="tenant-cnic_error"></span> -->
                    </div>
                    <div class="col-md-6 ">
                        <label class="form-label">Tenant's Image</label>
                        <input type="file" id="tenant-contact" name="tenant_image" class="form-control">
                        <!-- <span class="text-danger" id="tenant-image_error"></span> -->
                    </div>

                    <!-- Button -->
                    <div class="col-md-12">
                        <button class="btn btn-primary" id="submit_btn" type="submit" name="submit">Add Now</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- End:Main Body -->
</div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $("#house_shop_id").select2();
    });
</script>
<!-- Start: Footer -->
<?php include_once('includes/footer.php'); ?>
<!-- End: Footer -->


<script>
    // $(document).ready(function() {
    //     function loadData(type, id) {
    //         $.ajax({
    //             url: 'ajax.php',
    //             type: 'POST',
    //             data: {
    //                 type: type,
    //                 id: id
    //             },
    //             dataType: 'html',
    //             success: function(data) {
    //                 if (type === "house_id_Data") {
    //                     $('#house_id').append(data);
    //                 } else if (type === "owner_name_Data") {
    //                     $('#owner_name').html(data);
    //                 } else if (type === "owner_contact_Data") {
    //                     $('#owner_contact').html(data);
    //                 }
    //             }
    //         });
    //     }

    //     loadData("house_id_Data");

    //     $("#house_id").on("change", function() {
    //         var customer = $("#house_id").val();
    //         if (customer != "") {
    //             loadData("owner_name_Data", customer);
    //         } else {
    //             $('#owner_name').html("");
    //         }
    //     });
    //     $("#house_id").on("change", function() {
    //         var customer = $("#house_id").val();
    //         if (customer != "") {
    //             loadData("owner_contact_Data", customer);
    //         } else {
    //             $('#owner_contact').html("");
    //         }
    //     });
    // });


    $(document).ready(function () {
        function loadData(type, id = null) {
            $.ajax({
                url: 'ajax.php',
                type: 'POST',
                data: {
                    type: type,
                    id: id
                },
                dataType: 'html',
                success: function (data) {
                    if (type === "eGate_id_Data") {
                        $('#house_shop_id').html(data);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        }

        loadData("eGate_id_Data");

        $('#house_shop_id').change(function () {
            var selectedOption = $(this).find('option:selected').parent().attr('label');
            if (selectedOption === 'House Number') {
                $('#house_or_shop').val('house');
            } else if (selectedOption === 'Shop Number') {
                $('#house_or_shop').val('shop');
            }
        });
    });
</script>


<script>
    //     document.getElementById("submit_btn").addEventListener("click", function(event) {
    //     event.preventDefault(); // Prevent default form submission behavior

    //     // Show loader and hide button
    //     document.getElementById("submit_btn").style.display = "none";
    //     document.getElementById("loader").style.display = "block";

    //     // Submit the form
    //     var form = document.getElementById("add_houses_form");
    //     var formData = new FormData(form);

    //     fetch(form.action, {
    //         method: "POST",
    //         body: formData
    //     })
    //     .then(response => {
    //         // Handle the response, for now, let's just show the button again
    //         document.getElementById("submit_btn").style.display = "block";
    //         document.getElementById("loader").style.display = "none";
    //     })
    //     .catch(error => {
    //         console.error('Error:', error);
    //         // Handle errors if any
    //     });
    // });


    // $(document).ready(function() {
    //     $("#submit_btn").click(function() {
    //         submitForm();
    //     });
    // });

    // function submitForm() {
    //     // Show loader and hide button
    //     $("#submit_btn").hide();
    //     $("#loader").show();

    //     // Get form data
    //     var formData = new FormData($("#add_houses_form")[0]);

    //     // Submit form via AJAX
    //     $.ajax({
    //         type: "POST",
    //         url: "submit_form.php",
    //         data: formData,
    //         processData: false,
    //         contentType: false,
    //         success: function(response) {
    //             // Handle success
    //             $("#submit_btn").show();
    //             $("#loader").hide();
    //             alert("Form submitted successfully!");
    //         },
    //         error: function(xhr, status, error) {
    //             // Handle errors
    //             console.error(xhr.responseText);
    //             alert("Error occurred while submitting the form.");
    //             $("#submit_btn").show();
    //             $("#loader").hide();
    //         }
    //     });
    // }
</script>
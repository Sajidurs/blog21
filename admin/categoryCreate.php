<?php
include "layout/head.php";



if ($_SERVER["REQUEST_METHOD"] == 'POST') {

    $category_name       = inputValidate($_POST["category_name"]);
    $category_slug       = inputValidate($_POST["category_slug"]);


    if (empty($category_name)) {
        $error['categoryName'] = 'Category name is required';
    } else {
        $data['categoryName'] = $category_name;
    }
    if (empty($category_slug)) {
        $error['categorySlug'] = 'Category slug is required';
    } else {
        $data['categorySlug'] = $category_slug;
    }


    if (empty($error['categoryName']) && empty($error['categorySlug'])) {

         $sql = "INSERT INTO category(name,slug)VALUES(:name,:slug)";
         if($stmpt = $conn->prepare($sql)){
             $stmpt->bindParam(':name', $data['categoryName'], PDO::PARAM_STR);
             $stmpt->bindParam(':slug', $data['categorySlug'], PDO::PARAM_STR);
           if( $stmpt->execute()){
             $_SESSION['success'] ='Category inserted successfully';
             header('location:category.php');
           }
         }
    }
}

?>



<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <?php
    include "layout/sidebar.php"
    ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <?php
            include "layout/topbar.php"
            ?>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Category</h1>
                    <a href="category.php" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
                        <i class="fas fa-reply"></i>
                        Back to list
                    </a>
                </div>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Category Create</h6>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" autocomplete="off">
                            <div class="form-group">
                                <label for="category_name">Category Name</label>
                                <input type="text" name="category_name" class="form-control" id="category_name">
                                <small id="emailHelp" class="form-text text-danger">
                                    <?php echo  $error['categoryName'] ?? ''; ?>
                                </small>
                            </div>

                            <div class="form-group">
                                <label for="slug">Category Slug</label>
                                <input type="text" name="category_slug" class="form-control" id="slug">
                                <small id="emailHelp" class="form-text text-danger">
                                    <?php echo  $error['categorySlug'] ?? ''; ?>
                                </small>
                            </div>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>


            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- footer page link -->
        <?php
        include "layout/footer.php";
        include "layout/_script.php";

        ?>

        <script>
            $('#category_name').on('keyup', function() {

                $('#slug').val('')
                var category = $(this).val();

                category = category.toLowerCase();
                category = category.replace(/[^a-zA-Z0-9]+/g, '-');

                $('#slug').val(category)

            });

            function convertToSlug(Text) {
                return Text.toLowerCase()
                    .replace(/ /g, '-')
                    .replace(/[^\w-]+/g, '');
            }
        </script>

        </body>

        </html>
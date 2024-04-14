<?php
    include 'partials/header.php';

    // fetch categories from the database by making the page dynamic using php .
    $query = "SELECT * FROM `categories` ORDER BY `categories`.`title`";
    $categories = mysqli_query($connection, $query);

?>

<section class="dashboard">
<!-- shows alert when a catgory is added successfully . -->
<?php if(isset($_SESSION['add-category-success'])) : ?>
        <div class="alert_message success container">
            <p>
                <?= $_SESSION['add-category-success'];
                unset($_SESSION['add-category-success']);
                ?>  
            </p>
        </div>
<!-- shows alert if category will not get added . -->
<?php elseif(isset($_SESSION['add-category'])) : ?>
        <div class="alert_message error container">
            <p>
                <?= $_SESSION['add-category'];
                unset($_SESSION['add-category']);
                ?>  
            </p>
        </div>
<!-- shows alert when category will be edited successfully . -->
<?php elseif(isset($_SESSION['edit-category-success'])) : ?>
        <div class="alert_message success container">
            <p>
                <?= $_SESSION['edit-category-success'];
                unset($_SESSION['edit-category-success']);
                ?>  
            </p>
        </div>
<!-- shows alert when category will be not get edited . -->
<?php elseif(isset($_SESSION['edit-category'])) : ?>
        <div class="alert_message error container">
            <p>
                <?= $_SESSION['edit-category'];
                unset($_SESSION['edit-category']);
                ?>  
            </p>
        </div>
<!-- show alert when the category will be deleted successfully -->
<?php elseif(isset($_SESSION['delete-category-success'])) : ?>
        <div class="alert_message success container">
            <p>
                <?= $_SESSION['delete-category-success'];
                unset($_SESSION['delete-category-success']);
                ?>  
            </p>
        </div>
<!-- show alert when the category will not get deleted -->
        <?php elseif(isset($_SESSION['delete-category'])) : ?>
        <div class="alert_message error container">
            <p>
                <?= $_SESSION['delete-category'];
                unset($_SESSION['delete-category']);
                ?>  
            </p>
        </div>
<?php endif ?>
    <div class="container dashboard_container">
        <button class="sidebar_toggle" id="show_sidebar-btn">
            <i class="fa-regular fa-square-caret-right"></i>
        </button>
        <button class="sidebar_toggle" id="hide_sidebar-btn">
            <i class="fa-solid fa-square-caret-left"></i>
        </button>

        <aside>
            <ul>
                <li>
                    <a href="add-post.php"><i class="fa-solid fa-pen"></i>
                    <h5>Add Post</h5>
                    </a>
                </li>
                <li>
                    <a href="index.php" ><i class="fa-solid fa-table"></i>
                    <h5>Manage Posts</h5>
                    </a>
                </li>
                <?php if(isset($_SESSION['user_is_admin'])) : ?>

                <li>
                    <a href="add-user.php"><i class="fa-solid fa-user"></i>
                    <h5>Add User</h5>
                    </a>
                </li>
                <li>
                    <a href="manage-users.php" ><i class="fa-solid fa-users"></i>
                    <h5>Manage Users</h5>
                    </a>
                </li>
                <li>
                    <a href="add-category.php" ><i class="fa-solid fa-pen-to-square"></i>
                    <h5>Add Category</h5>
                    </a>
                </li>
                <li>
                    <a href="manage-categories.php" class="active" ><i class="fa-solid fa-bars"></i>
                    <h5>Manage Category</h5>
                    </a>
                </li>
                <?php endif ?>
                
            </ul>
        </aside>

        <main>
            <h2>Manage Categories</h2>
            <?php if(mysqli_num_rows($categories) > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($category = mysqli_fetch_assoc($categories)) : ?>
                    <tr>
                        <td><?= $category['title'] ?></td>
                        <td><a href="<?= ROOT_URL ?>admin/edit-category.php?id=<?= $category['id'] ?>" class="btn sm">Edit</a></td>
                        <td><a href="<?= ROOT_URL ?>admin/delete-category.php?id=<?= $category['id'] ?>" class="btn sm danger">Delete</a></td>
                    </tr>
                    <?php endwhile ?>
                </tbody>
            </table> 
            <?php else : ?>
                <div class="alert_message error">
                    <?= "No categories found" ?>
                </div>
            <?php endif ?>
        </main>

    </div>
</section>


    <!-- -------------------------------------------------------- -->
<?php
    include '../partials/footer.php';
?>
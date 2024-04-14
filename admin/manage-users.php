<?php
    include 'partials/header.php';

    // fetch users from database , but not current user .
    // only admin can do changes in it too .
    // and current user cannot delete himself . 
    $current_admin_id = $_SESSION['user-id'];
    $query = "SELECT * FROM `users` WHERE NOT `users`.`id` = $current_admin_id";
    $users = mysqli_query($connection, $query);


?>

<section class="dashboard">
<!-- for add user success -->
<?php if(isset($_SESSION['add-user-success'])) : ?>
        <div class="alert_message success container">
            <p>
                <?= $_SESSION['add-user-success'];
                unset($_SESSION['add-user-success']);
                ?>  
            </p>
        </div>
        <!-- for edit user success -->
<?php elseif(isset($_SESSION['edit-user-success'])) : ?>
        <div class="alert_message success container">
            <p>
                <?= $_SESSION['edit-user-success'];
                unset($_SESSION['edit-user-success']);
                ?>  
            </p>
        </div>
        <!-- for deleting user success -->
<?php elseif(isset($_SESSION['delete-user-success'])) : ?>
        <div class="alert_message success container">
            <p>
                <?= $_SESSION['delete-user-success'];
                unset($_SESSION['delete-user-success']);
                ?>  
            </p>
        </div>

<?php elseif(isset($_SESSION['delete-user'])) : ?>
        <div class="alert_message error container">
            <p>
                <?= $_SESSION['delete-user'];
                unset($_SESSION['delete-user']);
                ?>  
            </p>
        </div>
        <!-- if update do not occur -->
<?php elseif(isset($_SESSION['edit-user'])) : ?>
        <div class="alert_message error container">
            <p>
                <?= $_SESSION['edit-user'];
                unset($_SESSION['edit-user']);
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
                    <a href="manage-users.php" class="active"><i class="fa-solid fa-users"></i>
                    <h5>Manage Users</h5>
                    </a>
                </li>
                <li>
                    <a href="add-category.php" ><i class="fa-solid fa-pen-to-square"></i>
                    <h5>Add Category</h5>
                    </a>
                </li>
                <li>
                    <a href="manage-categories.php" ><i class="fa-solid fa-bars"></i>
                    <h5>Manage Category</h5>
                    </a>
                </li>

                <?php endif ?>
            </ul>
        </aside>

        <main>
            <h2>Manage Users</h2>
            <?php if(mysqli_num_rows($users) > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Admin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($user = mysqli_fetch_assoc($users)) : ?>
                    <tr>
                        <td><?= "{$user['firstname']} {$user['lastname']}" ?></td>
                        <td><?= "{$user['username']} " ?></td>
                        <!-- used conditional statements -->
                        <td><a href="<?= ROOT_URL ?>admin/edit-user.php?id=<?= $user['id'] ?>" class="btn sm">Edit</a></td>
                        <td><a href="<?= ROOT_URL ?>admin/delete-user.php?id=<?= $user['id'] ?>" class="btn sm danger">Delete</a></td>
                        <!-- conditional statements -->
                        <td><?= $user['is_admin'] ? 'Yes' : 'No' ?></td>
                    </tr>
                    <?php endwhile ?>
                </tbody>
            </table>
            <?php else : ?>
                <div class="alert_message error"><?= "No users found " ?> 
                </div>
            <?php endif ?>
        </main>
    </div>
</section>


    <!-- -------------------------------------------------------- -->
<?php
    include '../partials/footer.php';
?>
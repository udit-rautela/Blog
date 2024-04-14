<?php
    include 'partials/header.php';

    // only admin who will have id , will get access to the edit page else the admin will be redirected to the manage-users.php page .
    if(isset($_GET['id'])){
        $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
        $query = "SELECT * FROM `users` WHERE `users`.`id` = $id";
        $result = mysqli_query($connection, $query);
        $user = mysqli_fetch_assoc($result);
    }
    else{
        header('location:' . ROOT_URL . 'admin/manage-users.php');
    }
?>
    <!-- --------------------------------------------------------  -->

<section class="form_section">
    <div class="container form_section-container">
        <h2>Edit User</h2>
        <form action="<?= ROOT_URL ?>admin/edit-user-logic.php" method="POST">
            <input type="hidden" value="<?= $user['id'] ?>" name="id">
            <input type="text" value="<?= $user['firstname'] ?>" name="firstname"  placeholder="first name">
            <input type="text" value="<?= $user['lastname'] ?>" name="lastname" placeholder="last name">
            <select name="userrole" >
                <option value="0">Author</option>
                <option value="1">Admin</option>
            </select>
            <button type="submit" name="submit" class="btn" >Update user</button>
        </form>
    </div>
</section>

<!-- Footer section STARTS -->

<?php
    include '../partials/footer.php';
?>
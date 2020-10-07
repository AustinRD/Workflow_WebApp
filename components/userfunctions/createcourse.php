<?php
ob_start();
if (!isset($_SESSION)) {
  session_start();
}

include_once './backend/util.php';
include_once './backend/db_connector.php';
?>

<div class="container">
  <div class="jumbotron">
    <h1 class="display-4">Create a Course</h1>
    <p class="lead">Generate a new course here however, modify course form view course.</p>
    <hr class="my-4">
    <?php if (isset($_GET['courseadd']) and $_GET['courseadd'] == 'false') { ?>
      <div class="col-6 mx-auto alert alert-warning fade show">
        Duplicate entry for course number.
      </div>
    <?php } else if (isset($_GET['courseadd']) and $_GET['courseadd'] == 'true') { ?>
      <div class="col-6 mx-auto alert alert-success fade show">
        Course added!
      </div>
    <?php } ?>
    <form method="post" class="p-5 m-4">
      <div class="row">
        <div class="col">
          <label for="type" class="col-4 col-form-label">Department</label>
          <select id="type" name="dept" class="form-control" size="1" value="" required="required">
            <?php
            $sql = "SELECT * FROM f20_academic_dept_info ORDER BY dept_code ASC";
            $deptquery  = mysqli_query($db_conn, $sql);
            $r = mysqli_num_rows($deptquery);

            if ($r > 0) {
              while ($result = mysqli_fetch_assoc($deptquery)) {
                $deptcode = $result['dept_code'];
            ?>

                <option value="<?php echo $deptcode; ?>"><?php echo $deptcode; ?></option>

            <?php }
            } ?>
          </select>
        </div>
        <div class="col">
          <label for="classnumber">Class number </label>
          <input id="classnumber" name="classnumber" type="text" class="form-control" maxlength="3" size="3" required="required" />
        </div>
      </div>
      <div class="float-right">
        <button name="addcourse" type="submit" class="btn btn-primary">Add course</button>
      </div>
  </div>
  </form>
</div>
</div>
<?php


if (isset($_POST['addcourse'])) {
  $dept = mysqli_real_escape_string($db_conn, $_POST['dept']);
  $class = mysqli_real_escape_string($db_conn, $_POST['classnumber']);

  $insertclass = "INSERT INTO f20_course_numbers (dept_code, course_number) VALUES ('$dept', '$class')";
  $insertclassquery = mysqli_query($db_conn, $insertclass);

  if (mysqli_errno($db_conn) == 0) {  //success
    header('Location: ./createcourse.php?courseadd=true');
  } else if (mysqli_errno($db_conn) == 1062) {  //duplicate
    header('Location: ./createcourse.php?courseadd=false');
  }
}

include_once('components/footer.php');
?>
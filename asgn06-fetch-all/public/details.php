<?php require_once('../private/initialize.php'); ?>

<?php


  $id = $_GET['id'] ?? false;

  if(!$id) {
    redirect_to('bird.php');
  }

  // Find bicycle using ID

  $bird = Bird::find_by_id($id);

?>

<?php $page_title = 'Detail: ' . $bird->name(); ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

<div id="main">

  <a href="bird.php">Back to Inventory</a>

  <div id="page">

    <div class="detail">
      <dl>
        <dt>Common Name</dt>
        <dd><?php echo h($bird->common_name); ?></dd>
      </dl>
      <dl>
        <dt>Habitat</dt>
        <dd><?php echo h($bird->habitat); ?></dd>
      </dl>
      <dl>
        <dt>Food</dt>
        <dd><?php echo h($bird->food); ?></dd>
      </dl>
      <dl>
        <dt>Nest Placement</dt>
        <dd><?php echo h($bird->nest_palcement); ?></dd>
      </dl>
      <dl>
        <dt>behavior</dt>
        <dd><?php echo h($bird->behavior); ?></dd>
      </dl>
      <dl>
        <dt>Conservation Level</dt>
        <dd><?php echo h($bird->conservation()); ?></dd>
      </dl>
      <dl>
        <dt>Backyard Tips</dt>
        <dd><?php echo h($bird->backyard_tips); ?></dd>
      </dl>
    </div>

  </div>

</div>

<?php include(SHARED_PATH . '/public_footer.php'); ?>

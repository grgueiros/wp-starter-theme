<?php

$ancestrais = get_post_ancestors(the_post());

$ancestrais = array_reverse($ancestrais);

?>


<?php if (is_category()) : ?>

  <div class="breadcrumb-wrapper">
    <div class="breadcrumb">
      <a href="<?php echo home_url(); ?>">Home</a>
      <p>></p>
      <a href="<?= home_url(); ?>/blog">Blog</a>
      <p>></p>
      <p><?= get_queried_object()->name ?></p>
    </div>
  </div>



<?php else : ?>

  <div class="breadcrumb-wrapper">
    <div class="breadcrumb">
      <a href="<?php echo home_url(); ?>">Home</a>
      <p>></p>
      <?php foreach ($ancestrais as $key => $ancestral) : ?>
        <a href="<?= the_permalink($ancestral); ?>"><?= get_the_title($ancestral) ?></a>
      <?php endforeach; ?>
      <p>></p>
      <p><?= get_the_title(); ?></p>
    </div>
  </div>
<?php endif; ?>
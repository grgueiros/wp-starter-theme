<?php


$query = $_GET['q'];
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

$recentQuery = new WP_Query(array(
  'post_type' => 'post',
  'posts_per_page' => 3,
));


$q = new WP_Query(array(
  'post_type' => 'post',
  'posts_per_page' => 10,
  's' => $query,
  'paged' => $paged,
));

$total_posts = $q->found_posts;

?>

<h2 class="-green text-center mt-60 mb-50"><?= get_the_title(); ?></h2>

<?php if ($total_posts && $query) : ?>
  <div class="search-results mb-100 text-center">
    <?php if ($total_posts === 1) : ?>
      <p><strong><?= $total_posts ?> resultado</strong> encontrado para <strong><?= $query ?></strong></p>
    <?php else : ?>
      <p><strong><?= $total_posts ?> resultados</strong> encontrados para <strong><?= $query ?></strong></p>
    <?php endif; ?>
  </div>


  <div class="query-results">
    <?php if ($q->have_posts()) : while ($q->have_posts()) : $q->the_post(); ?>
        <a href="<?= get_post_permalink(); ?>" class="post">
          <div class="post-image" style="background-image:  url('<?= get_the_post_thumbnail_url(); ?>')"> </div>
          <div class="post-content">
            <div class="post-category">
              <img src="<?= get_field('icone', 'category_' . get_the_category()[0]->term_id)['url'] ?>">
              <p class="-green"><?= get_the_category()[0]->name ?></p>
            </div>
            <h4 class="strong"><?= get_the_title(); ?></h4>
            <p class="excerpt -grey-80"><?= axs_custom_excerpts(17); ?></p>
          </div>
        </a>
    <?php endwhile;
    endif; ?>
    <?php get_template_part('template-parts/global/pagination', null, array('query' => $q)); ?>
    <?php wp_reset_postdata(); ?>
  </div>



<?php else : ?>

  <div class="search-results text-center">
    <p><strong>Nenhum</strong> resultado encontrado para <strong><?= $query ?></strong></p>
  </div>

  <form>
    <div class="input-wrapper">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#180D5B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        <path d="M21.0004 21.0001L16.6504 16.6501" stroke="#180D5B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
      <input class="input-query" name="q" placeholder="Pesquisar" type="text" />
    </div>
  </form>

  <div class="categories mb-100">
    <?php foreach (get_categories() as $key => $categoria) : ?>
      <a href="<?= get_category_link($categoria) ?>" class="category">
        <div class="category-image">
          <img src="<?= get_field('icone', 'category_' . $categoria->term_id)['url'] ?>">
        </div>
        <p><?= $categoria->name ?></p>
      </a>
    <?php endforeach; ?>
  </div>



  <div class="related-posts">
    <?php if ($recentQuery->have_posts()) : ?>
      <?php while ($recentQuery->have_posts()) : $recentQuery->the_post() ?>
        <a href="<?= get_post_permalink(); ?>" class="post">
          <div class="post-image" style="background-image:  url('<?= get_the_post_thumbnail_url(); ?>')">
            <div class="arrow-icon">
              <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8.99961C0 8.50255 0.447715 8.09961 1 8.09961H17C17.5523 8.09961 18 8.50255 18 8.99961C18 9.49667 17.5523 9.89961 17 9.89961H1C0.447715 9.89961 0 9.49667 0 8.99961Z" fill="white" />
                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.38957 0.292893C8.77619 -0.0976311 9.40303 -0.0976311 9.78964 0.292893L17.7096 8.29289C18.0963 8.68342 18.0963 9.31658 17.7096 9.70711L9.78964 17.7071C9.40303 18.0976 8.77619 18.0976 8.38957 17.7071C8.00295 17.3166 8.00295 16.6834 8.38957 16.2929L15.6095 9L8.38957 1.70711C8.00295 1.31658 8.00295 0.683418 8.38957 0.292893Z" fill="white" />
              </svg>
            </div>
          </div>
          <div class="post-content">
            <div class="post-category">
              <img src="<?= get_field('icone', 'category_' . get_the_category()[0]->term_id)['url'] ?>">
              <p class="-green"><?= get_the_category()[0]->name ?></p>
            </div>
            <h5 class="strong"><?= get_the_title(); ?></h5>
            <p class="excerpt -grey-80"><?= axs_custom_excerpts(17); ?></p>
          </div>
        </a>
    <?php endwhile;
    endif; ?>
  </div>
<?php endif; ?>
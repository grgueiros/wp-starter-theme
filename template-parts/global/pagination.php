<?php

$query = $args['query'];
?>

<div class="pagination">
  <?php
  echo paginate_links(array(
    'base'         => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
    'total'        => $query->max_num_pages,
    'current'      => max(1, get_query_var('paged')),
    'format'       => '?paged=%#%',
    'show_all'     => false,
    'type'         => 'plain',
    'end_size'     => 1,
    'mid_size'     => 2,
    'prev_next'    => true,
    'prev_text'    => sprintf('<i class="prev-icon"></i> %1$s', __('', 'text-domain')),
    'next_text'    => sprintf('%1$s <i class="next-icon"></i>', __('', 'text-domain')),
    'add_args'     => false,
    'add_fragment' => '',
  ));
  ?>
</div>
<div class="magazine-header">
  <div class="magazine-column">
    <header class="magazine-title">
        <?php if(is_category()):?>
          <h4><a data-toggle="magazine_menu">Tin tức</a></h4>
          <aside>
            <h1 class="sub"><?php single_cat_title()?></h1>
          </aside>
        <?php elseif(is_single()):?>
          <h4><a data-toggle="magazine_menu">Tin tức</a></h4>
        <?php else:?>
          <h1><a data-toggle="magazine_menu">Tin tức</a></h1>
        <?php endif;?>
    </header>
    <div id="magazine_menu" data-toggler data-animate="fade-in fade-out">
          <?php
          if (has_nav_menu ( 'magazine-menu' )) {
            $main_menu_args = array (
              'container' => '',
              'menu_class' => 'vertical menu',
              'items_wrap'      => '<ul id="%1$s" class="dropdown menu" data-responsive-menu="accordion large-dropdown">%3$s</ul>',
             // 'fallback_cb' => 'mag_menu_fallback',
              'walker' => new Magazine_Walker_Nav_Menus(),
              'theme_location' => 'magazine-menu' 
            );
            wp_nav_menu ( $main_menu_args);
          }
          ?>
          <?php wp_reset_postdata(); ?>
    </div>
  </div>
</div>

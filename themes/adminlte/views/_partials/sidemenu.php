

<aside class="main-sidebar sidebar-dark-primary elevation-4">

<a href="<?=base_url();?>" class="brand-link">
  <img src="<?=base_url();?>assets/uploads/logos/<?=$settings->logo;?>" alt="<?=$settings->title;?>" class="brand-image img-circle elevation-3" style="opacity: .8">
  <span class="brand-text font-weight-light"><?=$settings->title;?></span>
</a>

<div class="sidebar">

 <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?= base_url(); ?>assets/uploads/members/<?= $user->image; ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= $user->first_name.' '.$user->last_name; ?></a>
        </div>
      </div>


<nav class="mt-2">
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

<?php foreach ($menu as $parent => $parent_params): ?>
              <?php if ( empty($page_auth[$parent_params['url']]) || $this->ion_auth->in_group($page_auth[$parent_params['url']]) ): ?>
                  <?php if ( empty($parent_params['children']) ): ?>
                      <?php if($this->Admin || (@$this->GP[str_replace('/', '-', $parent_params['name'])])): ?>
                          <?php $active = ($current_uri==$parent_params['url'] || $ctrler==$parent); ?>


                          <li class="nav-item ">
                            <a href="<?= base_url();?>panel/<?php echo $parent_params['url']; ?>" class="nav-link <?php if ($active) echo 'active'; ?>">
                              <i class="nav-icon <?php echo $parent_params['icon']; ?>"></i>
                              <p>
                               <?php echo lang($parent_params['name']); ?>
                              </p>
                            </a>
                          </li>

                      <?php endif; ?>
                  <?php else: ?>
                      <?php $parent_active = ($ctrler==$parent); ?>
                       <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                        <li class="nav-item <?php if ($parent_active) echo 'menu-open'; ?> ">
                          <a href="#" class="nav-link <?php if ($parent_active) echo 'active'; ?>">
                            <i class="nav-icon <?php echo $parent_params['icon']; ?>"></i>
                            <p>
                              <?php echo lang($parent_params['name']); ?>
                              <i class="right fas fa-angle-left"></i>
                            </p>
                          </a>
                          <ul class="nav nav-treeview">
                           <?php foreach ($parent_params['children'] as $name => $url): ?>
                                <?php if($this->Admin || @$this->GP[str_replace('/', '-', $name)]): ?>
                                    <?php $child_active = ($current_uri==$url); ?>

                                    <li class="nav-item <?php if ($child_active) echo 'active'; ?>">
                                      <a href="<?= base_url();?>panel/<?php echo $url; ?>" class="nav-link <?php if ($child_active) echo 'active'; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p> <?php echo lang($name); ?></p>
                                      </a>
                                    </li>

                                <?php endif; ?>
                            <?php endforeach; ?>
                          </ul>
                        </li>
                  <?php endif; ?>
              <?php endif; ?>
          <?php endforeach; ?>
</ul>
</nav>

</div>

</aside>
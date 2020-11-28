<?php 

use Core\Router;
use Core\Helpers;

use App\Models\Users;

$menu = Router::get_menu('menu_acl');  
$currentPage = Helpers::currentPage();

?>
<nav class="navbar navbar-expand-lg navbar-light fixed bg-light">
  <a class="navbar-brand" href="<?= PROJECT_ROOT; ?>">MVC Architecture </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav">
      <?php 
      foreach ($menu as $key => $value): 
        $active = '';
      ?>
        <?php if(is_array($value)): ?>
          <li class="nav-item dropdown">
            <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $key; ?> <span class="carret"></span></a>
            <ul class="dropdown-menu">
              <?php foreach($value as $k => $v): 
                $active = ($v == $currentPage) ? 'active' : '' ;
              ?>
              <?php if($k == "separator"): ?>
                <li role="separator" class="divider"></li>
              <?php else: ?>
                <li class="dropdown-item <?= $active; ?>">
                  <a class="nav-link <?= $item; ?>" href="<?= $v; ?>"><?= $k; ?></a>
                </li>
              <?php endif; ?>
              <?php endforeach; ?>
            </ul>
          </li>

        <?php else: 
          $active = ($value === $currentPage) ? 'active' : '' ;
         ?>
          <li class="nav-item <?= $active; ?>">
            <a class="nav-link" href="<?= $value; ?>"><?= $key; ?></a>
          </li>
        <?php endif; ?>
      <?php endforeach; ?>

    </ul>
    <ul class="navbar-nav ml-auto">
      <?php if(Users::currentUser()): ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= PROJECT_ROOT; ?>user/detail/<?= Users::currentUser()->id; ?>">Hi <?= Users::currentUser()->first_name;  ?></a>
        </li>
      <?php else: ?>
      <?php endif; ?>
    </ul>
  </div>
</nav>
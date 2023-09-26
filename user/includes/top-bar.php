<header class="top-bar">
  <h3><?php echo ucfirst($filename) ; ?></h3>
  <div class="bell">
    <span>
      <img src="<?php echo $settings['site_url']; ?>assets/images/bell.svg" alt="" />
      <small>
        5
      </small>
    </span>
    <div onclick="handleProfile()"><?php echo $userfirstletter; ?></div>
  </div>
</header>

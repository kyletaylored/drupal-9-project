<?php

// Enable Redis on site creation
if (isset($_POST['environment'])) {
  $req = pantheon_curl('https://api.live.getpantheon.com/sites/self/settings', NULL, 8443);
  $meta = json_decode($req['body'], true);

  // Enable Redis
  if ($meta['allow_cacheserver'] != 1) {
    $req = pantheon_curl('https://api.live.getpantheon.com/sites/self/settings', '{"allow_cacheserver":true}', 8443, 'PUT');
  }
}

// Get Label
$req = pantheon_curl('https://api.live.getpantheon.com/sites/self', NULL, 8443);
$meta = json_decode($req['body'], true);

// Install from profile.
echo "Installing default profile...\n";
passthru("drush site:install demo_umami --site-name {$meta['label']} --account-mail {$_POST['user_email']} --account-name superuser -y");
echo "Installation complete.\n";

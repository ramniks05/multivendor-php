<?php defined('BASEPATH') or exit('No direct script access allowed');
$guide_url = base_url('user-guide');
$compact = !empty($demo_compact);
?>
<div class="dc-demo-access<?= $compact ? ' dc-demo-access-compact' : ''; ?>">
    <?php if (!$compact): ?>
        <p class="dc-demo-kicker">Live demo · Digital Creatorss marketplace</p>
        <p class="dc-demo-lead">Explore buyer, vendor, and admin features. Open the user guide to see how to customize the platform, then contact the team for a build like this.</p>
    <?php else: ?>
        <p class="dc-demo-kicker">Demo login</p>
    <?php endif; ?>
    <ul class="dc-demo-creds">
        <li><strong>Admin</strong> <span>admin@example.com</span> / <span>admin123</span> · <a href="<?php echo admin_url(); ?>login">Admin panel</a></li>
        <li><strong>Vendor</strong> <span>novatech@shop.example</span> / <span>vendor123</span> · also urbanthreads@, nesthome@, glowlab@shop.example</li>
    </ul>
    <div class="dc-demo-actions">
        <a class="dc-demo-btn" href="<?php echo $guide_url; ?>">User guide</a>
        <a class="dc-demo-btn dc-demo-btn-ghost" href="<?php echo $guide_url; ?>#customize">How to customize</a>
        <a class="dc-demo-btn dc-demo-btn-ghost" href="<?php echo $guide_url; ?>#support">Contact the team</a>
    </div>
</div>

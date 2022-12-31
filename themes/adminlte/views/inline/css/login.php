<?php if($settings->background): ?>
.login-page {
    position: relative;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
.login-page {
    background-image: url('<?= base_url(); ?>assets/uploads/backgrounds/<?= $settings->background;?>');
    height: 100%;
}
<?php endif; ?>
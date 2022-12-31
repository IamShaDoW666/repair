.modal-ku {
    width: calc(100% - 30px);
}
    
.loader {
    color: white;
    top: 30px;
    right: -9px;
    position:fixed; z-index:9999;
    width: 106px;
    height: 106px;
    background: url('<?= $assets ?>dist/img/loading-page.gif') no-repeat center;
}
<?php if($settings->use_dark_theme): ?>
    .skin-custom .main-header {
        background-color: <?=$settings->header_color; ?>;
    }
    .skin-custom .main-header .navbar .nav > li > a {
        color: #ffffff;
    }
    .skin-custom .main-header .navbar .nav > li > a:hover,
    .skin-custom .main-header .navbar .nav > li > a:active,
    .skin-custom .main-header .navbar .nav > li > a:focus,
    .skin-custom .main-header .navbar .nav .open > a,
    .skin-custom .main-header .navbar .nav .open > a:hover,
    .skin-custom .main-header .navbar .nav .open > a:focus,
    .skin-custom .main-header .navbar .nav > .active > a {
        background: rgba(0, 0, 0, 0.1);
        color: #f6f6f6;
    }
    .skin-custom .main-header .navbar .sidebar-toggle {
        color: #ffffff;
    }
    .skin-custom .main-header .navbar .sidebar-toggle:hover {
        color: #f6f6f6;
        background: rgba(0, 0, 0, 0.1);
    }
    .skin-custom .main-header .navbar .sidebar-toggle {
        color: #fff;
    }
    .skin-custom .main-header .navbar .sidebar-toggle:hover {
        background-color: <?=$settings->header_color; ?>;
    }
    @media (max-width: 767px) {
        .skin-custom .main-header .navbar .dropdown-menu li.divider {
        background-color: rgba(255, 255, 255, 0.1);
        }
    }
    .skin-custom .main-header .logo {
        background-color: <?=$settings->header_color; ?>;
        color: #ffffff;
        border-bottom: 0 solid transparent;
    }
    .skin-custom .main-header .logo:hover {
        background-color: <?=$settings->header_color; ?>;
    }
    .skin-custom .main-header li.user-header {
        background-color: <?=$settings->header_color; ?>;
    }
    .skin-custom .content-header {
        background: transparent;
    }
    .skin-custom .wrapper,
    .skin-custom .main-sidebar,
    .skin-custom .left-side {
        background-color: <?=$settings->menu_color; ?>;
    }
    .skin-custom .user-panel > .info,
    .skin-custom .user-panel > .info > a {
        color: <?=$settings->mmenu_text_color; ?>;
    }
    .skin-custom .nav-sidebar > li.header {
        color: <?=$settings->mmenu_text_color; ?>;
        background: <?=$settings->menu_color; ?>;
    }
    .skin-custom .nav-sidebar > li:hover > a,
    .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active, .sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active{
        color: <?=$settings->mmenu_text_color; ?>;
        background: <?=$settings->menu_active_color; ?>;
    }
    .skin-custom .nav-sidebar > li > .nav-sidebar {
        margin: 0 1px;
        background: <?=$settings->menu_active_color; ?>;
    }
    .skin-custom .nav-link {
        color: <?=$settings->mmenu_text_color; ?>;
    }
    .skin-custom .sidebar a:hover {
        text-decoration: none;
    }
    .skin-custom .nav-sidebar > li > a {
        color: <?=$settings->menu_text_color; ?>;
    }
    .skin-custom .nav-sidebar > li.active > a,
    .skin-custom .nav-sidebar > li > a:hover {
        color: #ffffff;
    }
    .skin-custom .sidebar-form {
        border-radius: 3px;
        border: 1px solid #374850;
        margin: 10px 10px;
    }
    .skin-custom .sidebar-form input[type="text"],
    .skin-custom .sidebar-form .btn {
        box-shadow: none;
        background-color: #374850;
        border: 1px solid transparent;
        height: 35px;
    }
    .skin-custom .sidebar-form input[type="text"] {
        color: #666;
        border-top-left-radius: 2px;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 2px;
    }
    .skin-custom .sidebar-form input[type="text"]:focus,
    .skin-custom .sidebar-form input[type="text"]:focus + .input-group-btn .btn {
        background-color: #fff;
        color: #666;
    }
    .skin-custom .sidebar-form input[type="text"]:focus + .input-group-btn .btn {
        border-left-color: #fff;
    }
    .skin-custom .sidebar-form .btn {
        color: #999;
        border-top-left-radius: 0;
        border-top-right-radius: 2px;
        border-bottom-right-radius: 2px;
        border-bottom-left-radius: 0;
    }
    .skin-custom.layout-top-nav .main-header > .logo {
        background-color: <?=$settings->header_color; ?>;
        color: #ffffff;
        border-bottom: 0 solid transparent;
    }
    .skin-custom.layout-top-nav .main-header > .logo:hover {
        background-color: #3b8ab8;
    }

    .content-wrapper {
        background-color: <?=$settings->bg_color; ?> !important;
    }
    
    .spinner-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 999999;
    }
    .spinner {
        width: 40px;
        height: 40px;
        position: relative;
        position: absolute;
        top: 48%;
        left: 48%;
    }

    .double-bounce1, .double-bounce2 {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background-color: #333;
        opacity: 0.6;
        position: absolute;
        top: 0;
        left: 0;
        
        -webkit-animation: sk-bounce 2.0s infinite ease-in-out;
        animation: sk-bounce 2.0s infinite ease-in-out;
    }

    .double-bounce2 {
        -webkit-animation-delay: -1.0s;
        animation-delay: -1.0s;
    }

    @-webkit-keyframes sk-bounce {
        0%, 100% { -webkit-transform: scale(0.0) }
        50% { -webkit-transform: scale(1.0) }
    }

    @keyframes sk-bounce {
        0%, 100% { 
        transform: scale(0.0);
        -webkit-transform: scale(0.0);
        } 50% { 
        transform: scale(1.0);
        -webkit-transform: scale(1.0);
        }
    }
    .main-header .sidebar-toggle:before {
            font-family: "Font Awesome 5 Free"; font-weight: 900; content: "\f0c9";

    }
    .content-header h1 {
        color: <?=$settings->bg_text_color; ?>;
    }
<?php endif;?>
body{
    font-size: <?=$settings->body_font; ?>px;
}


.warranty_row td:first-child:before {
  background: <?= $settings->warranty_ribbon_color; ?>;
}


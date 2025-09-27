<?php
$select_db="SELECT * FROM mf_cc_menu WHERE usr_access LIKE '%".$_SESSION['usertype']."%' ORDER BY menidx DESC";
$stmt = $link->prepare($select_db);
$stmt->execute();
?>

<nav class="cc-sidebar">
    <div class="cc-menu">
        <?php while($rs = $stmt->fetch()): ?>
            <div class="cc-menu-row">
                <a class="cc-menu-link" href="<?= htmlspecialchars($rs['menprog']); ?>">
                    <span class="cc-icon-wrap">
                        <img src="images/menu_logos/<?= htmlspecialchars($rs['menlogo']); ?>" alt="">
                    </span>
                    <span class="cc-label"><?= htmlspecialchars($rs['mencap']); ?></span>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
</nav>

<style>
/* --- sidebar container (adjust width if needed) --- */
.cc-sidebar { 
    width: 260px; 
    padding: 22px 16px; 
    background: transparent; /* outer container uses your existing rounded white card */ 
    font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
}

/* each menu row spacing */
.cc-menu-row { margin-bottom: 14px; }

/* default link (inactive) */
.cc-menu-link {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 10px 12px;
    border-radius: 12px;
    text-decoration: none;
    color: #6b7280;              /* gray text like your screenshot */
    background: transparent;
    transition: all .18s ease;
    font-size: 15px;
    font-weight: 500;
}

/* icon container */
.cc-icon-wrap {
    width: 36px;
    height: 36px;
    min-width: 36px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background: transparent;
}

/* icon image - desaturated for inactive */
.cc-icon-wrap img {
    width: 18px;
    height: 18px;
    display: block;
    filter: grayscale(100%) brightness(80%);
    opacity: 0.9;
}

/* subtle hover for inactive items */
.cc-menu-link:hover {
    background: #f7f8ff;
    color: #4338ca;
}
.cc-menu-link:hover .cc-icon-wrap img {
    filter: none;
    opacity: 1;
    /* slightly colorize on hover */
}

/* --- ACTIVE style: big rounded purple pill like your image --- */
.cc-menu-link.active {
    background: linear-gradient(90deg, #5b4bff 0%, #7c6bff 100%);
    color: #ffffff;
    padding: 12px 18px;
    border-radius: 14px;
    box-shadow: 0 8px 22px rgba(91,75,255,0.18);
    font-weight: 600;
}

/* icon inside active pill: subtle white circle */
.cc-menu-link.active .cc-icon-wrap {
    background: rgba(255,255,255,0.12);
    border-radius: 10px;
}

/* make icon white in active */
.cc-menu-link.active .cc-icon-wrap img {
    filter: brightness(0) invert(1); /* turns icon white */
    opacity: 1;
}

/* label sizing & alignment */
.cc-label {
    line-height: 1;
    white-space: nowrap;
}

/* responsive small tweaks if your sidebar is used on narrow screens */
@media (max-width: 480px) {
    .cc-sidebar { width: 100%; padding: 12px; }
    .cc-menu-link { font-size: 14px; gap: 12px; padding: 10px; }
}
</style>

<script>
/* Auto-detect active menu by URL (non-invasive) */
document.addEventListener('DOMContentLoaded', function () {
    try {
        var links = document.querySelectorAll('.cc-menu-link');
        var current = window.location.href;

        // Prefer exact match, otherwise check substring
        links.forEach(function(a){
            var href = a.href;
            if (!href) return;
            // If href is same as current page or href is a substring of current URL -> mark active
            if (current === href || current.indexOf(href) !== -1 || href.indexOf(location.pathname.split('/').pop()) !== -1) {
                a.classList.add('active');
            }
        });

        // If none matched and you want the first to be active (optional)
        // if (!document.querySelector('.cc-menu-link.active') && links[0]) links[0].classList.add('active');
    } catch (e) {
        console.warn('Menu active detection error', e);
    }
});
</script>

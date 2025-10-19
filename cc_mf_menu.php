<?php
// PHP database retrieval logic. The $link variable must be established prior to this inclusion.
// Ensure $link and $_SESSION['usertype'] are defined/initialized before this file is required.

// --- NOTE: Assuming $link is a valid PDO/mysqli connection and $_SESSION['usertype'] is set. ---
if (isset($link)) {
    try {
        // Fetch dynamic menu items
        $select_db="SELECT * FROM mf_cc_menu WHERE usr_access LIKE :usertype_access ORDER BY menidx DESC";
        $stmt = $link->prepare($select_db);
        $stmt->bindValue(':usertype_access', '%' . $_SESSION['usertype'] . '%');
        $stmt->execute();
    } catch (Exception $e) {
        // Handle database error gracefully
        $stmt = null; // Ensure $stmt is null on failure
    }
} else {
    $stmt = null;
}
?>

<nav class="cc-sidebar">

    <div class="cc-header">
        <div class="cc-logo-wrap">
            <span class="cc-initials">DD</span>
        </div>
        <div class="cc-profile-info">
            <span class="cc-profile-name">DeskStaff</span>
            <span class="cc-profile-role">Dashboard</span>
        </div>
        <a href="javascript:void(0);" class="cc-arrow-btn" aria-label="Collapse menu">
             <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg>
        </a>
    </div>

    <div class="cc-search-bar">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        <input type="text" placeholder="Search..." aria-label="Search menu items">
    </div>

    <div class="cc-menu-links">
        
        <div class="cc-menu-row">
            <a class="cc-menu-link cc-home-link" href="select_option.php"> 
                <span class="cc-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                </span>
                <span class="cc-label">Home</span>
            </a>
        </div>
        <?php 
        if ($stmt) {
            while($rs = $stmt->fetch()): 
                $label = htmlspecialchars($rs['mencap']);
                $url = htmlspecialchars($rs['menprog']);
        ?>
            <div class="cc-menu-row">
                <a class="cc-menu-link" data-label="<?= $label; ?>" href="<?= $url; ?>">
                    <span class="cc-icon-wrap">
                        <?php 
                        // SVG icons for specific labels
                        if ($label === 'Certificates'): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 12 7 14 9"></polyline></svg>
                        <?php elseif ($label === 'Report Generation'): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                        <?php elseif ($label === 'Account Confirmations'): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>
                        <?php elseif ($label === 'Timeslot Viewing'): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        <?php elseif ($label === 'Inquiry'): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-help-circle"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.82 1c0 2-3 2-3 4"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                        <?php elseif ($label === 'Add Questions'): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        <?php else: // Fallback to image for any other menu item ?>
                            <img src="images/menu_logos/<?= htmlspecialchars($rs['menlogo']); ?>" alt="<?= $label ?> icon">
                        <?php endif; ?>
                    </span>
                    <span class="cc-label"><?= $label ?></span>
                </a>
            </div>
        <?php endwhile; 
        } // End if($stmt)
        ?>
    </div>

    <div class="cc-separator"></div>
        
    <div class="cc-menu-row">
        <a class="cc-menu-link cc-logout-link" href="logout.php"> 
            <span class="cc-icon-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
            </span>
            <span class="cc-label">Logout</span>
        </a>
    </div>
</nav>

<style>
/* Font Selection: Roboto for clean, formal look */
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

/* Scrollbar Customization for Consistency (Desktop) */
.cc-sidebar::-webkit-scrollbar { width: 6px; }
.cc-sidebar::-webkit-scrollbar-track { background: transparent; }
.cc-sidebar::-webkit-scrollbar-thumb { background: rgba(0, 0, 0, 0.1); border-radius: 10px; }
.cc-sidebar::-webkit-scrollbar-thumb:hover { background: rgba(0, 0, 0, 0.2); }

/* Base Styles for Sidebar Container (Desktop/Tablet View) */
.cc-sidebar { 
    padding: 24px 16px; 
    background: transparent; 
    font-family: 'Roboto', 'Open Sans', system-ui, sans-serif;
    color: #1f2937; 
    overflow-y: auto; /* Enable vertical scroll on desktop if needed */
    overflow-x: hidden;
}

/* 1. Profile and Header Section (Desktop/Tablet) */
.cc-header { display: flex; align-items: center; margin-bottom: 24px; gap: 12px; }
.cc-logo-wrap { width: 40px; height: 40px; min-width: 40px; border-radius: 12px; background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); display: flex; align-items: center; justify-content: center; }
.cc-initials { color: white; font-weight: 700; font-size: 16px; }
.cc-profile-info { display: flex; flex-direction: column; flex-grow: 1; }
.cc-profile-name { font-weight: 600; font-size: 16px; line-height: 1.2; }
.cc-profile-role { font-size: 12px; color: #6b7280; line-height: 1.2; }
.cc-arrow-btn { color: #9ca3af; display: flex; align-items: center; text-decoration: none; padding: 8px; }
.cc-arrow-btn svg { width: 20px; height: 20px; stroke-width: 2; }


/* 2. Search Input Field (Desktop/Tablet) */
.cc-search-bar { display: flex; align-items: center; gap: 10px; background: #f8fafc; border-radius: 12px; padding: 10px 14px; margin-bottom: 24px; color: #9ca3af; border: 1px solid transparent; }
.cc-search-bar svg { width: 20px; height: 20px; stroke-width: 2; }
.cc-search-bar input { border: none; outline: none; background: transparent; font-size: 15px; color: #1f2937; width: 100%; padding: 0; }
.cc-search-bar input::placeholder { color: #9ca3af; }

/* 3. Dynamic Menu Links (Desktop/Tablet) */
.cc-menu-row { margin-bottom: 4px; } 
.cc-menu-link { 
    display: flex; align-items: center; gap: 14px; padding: 10px 14px; border-radius: 10px; text-decoration: none; 
    color: #4b5563; 
    background: transparent; transition: all .18s ease; font-size: 15px; font-weight: 500; 
}
.cc-icon-wrap { width: 20px; height: 20px; min-width: 20px; display: inline-flex; align-items: center; justify-content: center; color: #9ca3af; }
.cc-icon-wrap svg { stroke: #9ca3af; stroke-width: 2; fill: none; transition: all .18s ease; }
.cc-icon-wrap img { width: 100%; height: 100%; display: block; filter: grayscale(100%) brightness(100%) opacity(0.8); transition: all .18s ease; }

/* Hover effect */
.cc-menu-link:hover { background: #f3f4f6; color: #4f46e5; }
.cc-menu-link:hover .cc-icon-wrap svg { stroke: #4f46e5; }
.cc-menu-link:hover .cc-icon-wrap img { filter: none; opacity: 1; }

/* --- ACTIVE link style: Purple pill design --- */
.cc-menu-link.active { 
    background: linear-gradient(90deg, #6366f1 0%, #8b5cf6 100%); 
    color: #ffffff; 
    padding: 12px 18px; border-radius: 12px; box-shadow: 0 4px 16px rgba(99, 102, 241, 0.35); font-weight: 600; 
}
.cc-menu-link.active .cc-icon-wrap { background: rgba(255,255,255,0.18); border-radius: 8px; width: 30px; height: 30px; min-width: 30px; padding: 5px; color: #ffffff; }
.cc-menu-link.active .cc-icon-wrap svg { stroke: #ffffff; }
.cc-menu-link.active .cc-icon-wrap img { filter: brightness(0) invert(1); opacity: 1; }

/* 4. Separator */
.cc-separator { height: 1px; background-color: #e5e7eb; margin: 20px 0 10px 0; }

/* 5. Logout Link Styling */
.cc-logout-link { color: #ef4444; }
.cc-logout-link:hover { background: #fee2e2; color: #dc2626; }
.cc-logout-link .cc-icon-wrap svg { stroke: #ef4444; }
.cc-logout-link:hover .cc-icon-wrap svg { stroke: #dc2626; }
.cc-logout-link.active { 
    background: transparent !important; color: #ef4444 !important; box-shadow: none !important;
    padding: 10px 14px !important; font-weight: 500 !important;
}
.cc-logout-link.active .cc-icon-wrap { background: transparent !important; width: 20px !important; height: 20px !important; min-width: 20px !important; padding: 0 !important; }
.cc-logout-link.active .cc-icon-wrap svg { stroke: #ef4444 !important; }

/* --- RESPONSIVE ADJUSTMENTS: PHONE/ICON-ONLY LAYOUT (Under 768px) --- */
@media (max-width: 768px) {
    .cc-sidebar { 
        width: 100%;
        height: auto;
        padding: 0;
        background-color: white; 
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        
        display: flex;
        flex-direction: row;
        flex-wrap: wrap; /* Allows icons to wrap to 2nd line */
        justify-content: flex-start; 
        align-items: flex-start; 
        
        overflow: hidden !important; 
    }
    
    /* Hide search and separator completely */
    .cc-search-bar,
    .cc-separator {
        display: none !important;
    }

    /* 1. DD Logo Alignment (Treating header as the first icon block) */
    .cc-header {
        /* Makes the header take 1/5th of the width (5 items per row) */
        width: 20%; 
        min-width: 60px; 
        height: 50px; 
        display: flex; 
        align-items: center;
        justify-content: center;
        padding: 0;
        margin: 0;
    }
    
    .cc-logo-wrap {
        /* Smaller logo for mobile view */
        width: 30px; 
        height: 30px; 
        min-width: 30px;
        margin: 0;
        border-radius: 8px;
    }
    
    /* Hide profile text and arrow in the header */
    .cc-profile-info,
    .cc-arrow-btn {
        display: none !important;
    }
    
    /* 2. Icon Arrangement (2 lines) and 3. Alignment Fix */
    .cc-menu-links {
        display: contents; 
    }
    
    .cc-menu-row {
        /* Each icon item takes 20% width for 5 items per line */
        width: 20%; 
        min-width: 60px;
        margin: 0;
    }
    
    .cc-menu-link {
        flex-direction: column; 
        gap: 4px;
        padding: 6px 4px; 
        align-items: center;
        text-align: center;
        border-radius: 0; 
        height: 50px; 
        justify-content: center;
    }
    
    /* Hide the text label completely */
    .cc-label {
        display: none !important; 
    }

    .cc-icon-wrap {
        width: 24px;
        height: 24px;
        min-width: 24px;
    }
    
    /* === FIX: Ensure all icons are visible (dark color) on the white mobile bar === */
    .cc-menu-link .cc-icon-wrap svg { 
        stroke: #4b5563 !important; /* Dark gray for visibility on white background */
    }
    .cc-menu-link .cc-icon-wrap img {
         filter: grayscale(100%) brightness(50%) !important; /* Make dynamic images dark */
         opacity: 1 !important;
    }

    /* Active state for icons (Blue) */
    .cc-menu-link.active {
        color: #6366f1 !important; 
    }
    .cc-menu-link.active .cc-icon-wrap svg { 
        stroke: #6366f1 !important; /* Active icon is blue */
    }
    
    /* Logout Link styling for mobile: Use dark gray for consistency, not red. */
    .cc-logout-link {
        color: #4b5563 !important; /* Dark gray text */
    }
    .cc-logout-link .cc-icon-wrap svg {
        stroke: #4b5563 !important; /* Dark gray icon */
    }
    .cc-logout-link:hover {
        background: #f3f4f6 !important; /* Light gray hover */
        color: #4b5563 !important;
    }
    /* Ensure logout link also respects the 20% width */
    .cc-menu-row:last-child {
        width: 20%;
        min-width: 60px;
    }
}
</style>

<script>
/* Dynamic Active Menu State and Link Handling (Unchanged) */
document.addEventListener('DOMContentLoaded', function () {
    const links = document.querySelectorAll('.cc-menu-link');

    // Function to set the active class
    function setActiveLink(currentPathname) {
        // 1. Remove 'active' from all links
        links.forEach(function(a){
            a.classList.remove('active');
        });

        const currentFile = currentPathname.split('/').pop().toLowerCase();

        // 2. Find and set 'active' class on the matching link
        links.forEach(function(a){
            // Skip utility links like logout from ever being set as 'active'
            if (a.classList.contains('cc-logout-link')) {
                return;
            }

            const linkPathname = a.pathname.split('/').pop().toLowerCase();
            
            // Check for exact file match.
            if (linkPathname === currentFile) {
                a.classList.add('active');
            }
            // Special handling for the 'Home' link (cc-home-link) 
            // which should be active when the current page is select_option.php
            else if (a.classList.contains('cc-home-link') && (currentFile === 'select_option.php' || currentFile === '')) {
                a.classList.add('active');
            }
        });
    }

    // Initialize active state on load
    setActiveLink(window.location.pathname);

    // Event listener for clicks to visually update the active state *immediately* before navigation
    links.forEach(function(a) {
        // Exclude logout link from the active page setting logic on click
        if (a.classList.contains('cc-logout-link')) return; 

        a.addEventListener('click', function(event) {
            // No action needed here; DOMContentLoaded on the next page handles the active state.
        });
    });
});
</script>
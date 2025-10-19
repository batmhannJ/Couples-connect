<?php
// feedback_management.php - Page for Desk Staff to view feedbacks
require "includes/cc_header.php";

// Check if user is desk staff
if($_SESSION['usertype'] != 'DSK') {
    header('Location: dashboard_user.php');
    exit;
}

// Handle mark as read
if(isset($_POST['mark_read'])) {
    $feedback_id = $_POST['feedback_id'];
    $update_read = "UPDATE user_feedback SET status = 'read', date_read = NOW(), read_by = ? WHERE feedback_id = ?";
    $stmt_update = $link->prepare($update_read);
    $stmt_update->execute(array($_SESSION['usr_id'], $feedback_id));
    header('Location: feedback_management.php');
    exit;
}

// Get all feedbacks with user info
$select_feedback = "SELECT uf.*, 
                           CONCAT(eca1.first_name, ' ', eca1.last_name) as partner1_name,
                           CONCAT(eca2.first_name, ' ', eca2.last_name) as partner2_name,
                           mpu.email
                    FROM user_feedback uf
                    LEFT JOIN mf_prog_users mpu ON uf.user_id = mpu.userid
                    LEFT JOIN ext_couples_accountinfo eca1 ON mpu.userid = eca1.userid AND eca1.partnerno = 1
                    LEFT JOIN ext_couples_accountinfo eca2 ON mpu.userid = eca2.userid AND eca2.partnerno = 2
                    ORDER BY uf.date_submitted DESC";
$stmt_feedback = $link->prepare($select_feedback);
$stmt_feedback->execute();
$feedbacks = $stmt_feedback->fetchAll();

// Calculate stats
$total_feedback = count($feedbacks);
$unread_count = 0;
$read_count = 0;

foreach($feedbacks as $feedback) {
    if($feedback['status'] == 'unread') {
        $unread_count++;
    } else {
        $read_count++;
    }
}

$header_name = 'DESK';
?>

<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
<link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>

<style>
    /* Global Styles */
    #search_text:focus { outline: none; }
    .has_hover:hover { color: #4f46e5 !important; transition: color 0.2s ease; }
    
    /* Dashboard Grid */
    .dashboard-grid {
        grid-template-columns: 320px 1fr;
        gap: 24px;
        height: auto; 
        max-width: 1400px; 
        display: grid; 
    }
    .cc-sidebar { height: calc(100vh - 80px); max-height: 650px; }
    .main-content-box { height: calc(100vh - 80px); max-height: 650px; }

    /* Medium Screen Collapse */
    @media (max-width: 1200px) {
        .dashboard-grid { 
            grid-template-columns: 80px 1fr !important;
            gap: 16px !important; 
        }
        .dashboard-grid > div:first-child { width: 80px; }
        .sidebar-label { display: none !important; opacity: 0 !important; width: 0 !important; overflow: hidden !important; max-width: 0 !important; } 
        .cc-profile-info, .cc-search-bar input { display: none !important; }
        .cc-menu-link { 
            display: flex !important; flex-direction: column !important; justify-content: center !important; 
            align-items: center !important; padding: 10px 0 !important; width: 100% !important; overflow: hidden !important; 
            text-align: center !important; max-width: 80px !important;
        } 
        .cc-menu-link .cc-icon-wrap { margin: 0 !important; }
        .cc-sidebar li { padding: 0 !important; margin: 0 !important; }
        .cc-menu-link > *:not(.cc-icon-wrap) { display: none !important; }
    }

    /* Mobile */
    @media (max-width: 768px) {
        .container-fluid { padding: 0 !important; max-width: 100% !important; }
        .container-fluid > .row { margin: 0 !important; padding: 0 !important; }
        form { padding: 0 !important; min-height: auto !important; }
        
        .dashboard-grid {
             display: flex !important; flex-direction: column !important; gap: 8px !important;
             width: 100% !important; max-width: 100% !important; margin: 0 !important; padding: 5px !important; 
        }
        
        .cc-sidebar {
            order: 1; width: 100% !important; max-width: 100% !important; height: auto !important;
            max-height: none !important; margin: 0 !important; padding: 8px 5px !important; 
            border-radius: 12px !important; display: flex; flex-direction: row !important;
            justify-content: space-around; align-items: center; overflow-x: auto; white-space: nowrap; 
        }
        
        .sidebar-label { opacity: 1 !important; width: auto !important; overflow: visible !important; display: none; } 
        .cc-menu-link { flex-direction: column; align-items: center; justify-content: center; padding: 4px; }
        .cc-menu-link .cc-icon-wrap { margin: 0 !important; }
        
        .main-content-box {
            order: 2; width: 100% !important; max-width: 100% !important; height: auto !important; 
            max-height: none !important; margin: 0 !important; padding: 8px !important; 
        }

        .main-content-box > div:first-child { padding: 8px !important; } 
        h1 { font-size: 16px !important; }
        
        .feedback-card { margin-bottom: 12px !important; }
        .feedback-header { padding: 12px 15px !important; font-size: 13px !important; }
        .feedback-body { padding: 15px !important; font-size: 12px !important; }
        .stat-card { padding: 15px !important; }
        .stat-number { font-size: 1.5em !important; }
    }

    /* Feedback Styles */
    .feedback-card {
        background: white;
        border-radius: 12px;
        margin-bottom: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .feedback-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
    }

    .feedback-header {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: white;
        padding: 16px 20px;
        font-family: Inter, sans-serif;
    }

    .feedback-body {
        padding: 20px;
        font-family: Inter, sans-serif;
    }

    .status-unread {
        background: #ef4444;
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-read {
        background: #10b981;
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-card {
        background: white;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        text-align: center;
        font-family: Inter, sans-serif;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    .stat-number {
        font-size: 2.5em;
        font-weight: 700;
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stat-label {
        color: #6b7280;
        margin-top: 8px;
        font-size: 14px;
        font-weight: 500;
    }

    .btn-mark-read {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        font-family: Inter, sans-serif;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-mark-read:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }

    .feedback-scroll {
        max-height: calc(100vh - 350px);
        overflow-y: auto;
        padding-right: 8px;
    }

    .feedback-scroll::-webkit-scrollbar {
        width: 8px;
    }

    .feedback-scroll::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.05);
        border-radius: 4px;
    }

    .feedback-scroll::-webkit-scrollbar-thumb {
        background: rgba(79, 70, 229, 0.3);
        border-radius: 4px;
    }

    .feedback-scroll::-webkit-scrollbar-thumb:hover {
        background: rgba(79, 70, 229, 0.5);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #9ca3af;
    }

    .empty-state i {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.3;
    }
</style>

<div class="container-fluid">
    <div class='row bg-white' style="height:99px">
        <div class="col-3 pe-0 d-flex align-items-center">
            <img src="images/350 x 88.png" style='height:76px;width:auto;'>
        </div>
    </div>
</div>

<form name='myforms' id="myforms" method="post" target="_self" style='min-height:100vh; background: linear-gradient(135deg, rgb(215, 217, 225) 0%, rgb(162, 185, 231) 100%); padding: 20px; font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;'>

    <div class="dashboard-grid" style="max-width: 1400px; margin: 0 auto; display: grid;">

        <!-- Sidebar -->
        <div class="cc-sidebar" style=" 
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 0;
            height: calc(100vh - 80px); 
            max-height: 650px; 
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow-y: auto;
            transition: width 0.3s ease;
        ">
            <div style="display: flex; flex-direction: column; gap: 0;">
                <?php require 'cc_mf_menu.php'; ?>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content-box" style=" 
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(255, 255, 255, 0.2);
            height: calc(100vh - 80px); 
            max-height: 650px;
            overflow: hidden;
        ">

            <!-- Header -->
            <div style="padding: 20px 24px 16px 24px; text-align: center; border-bottom: 1px solid rgba(0, 0, 0, 0.05); flex-shrink: 0;">
                <h1 style="font-size: 26px; font-weight: 700; color: #1a1a1a; margin: 0 0 10px 0;">
                    <i class="bi bi-chat-left-text-fill" style="margin-right: 8px;"></i>
                    Feedback Management
                </h1>
                <div style="height: 3px; background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%); border-radius: 2px; width: 180px; margin: 0 auto;"></div>
            </div>

            <!-- Stats Cards -->
            <div style="padding: 16px 24px; flex-shrink: 0;">
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;">
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $total_feedback; ?></div>
                        <div class="stat-label">Total Feedback</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?php echo $unread_count; ?></div>
                        <div class="stat-label">Unread</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?php echo $read_count; ?></div>
                        <div class="stat-label">Read</div>
                    </div>
                </div>
            </div>

            <!-- Feedback List -->
            <div style="flex: 1; padding: 0 24px 24px 24px; overflow: hidden; min-height: 0;">
                <div class="feedback-scroll">
                    <?php if(empty($feedbacks)): ?>
                        <div class="feedback-card">
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <h4 style="color: #6b7280; font-weight: 600; margin-bottom: 8px;">No Feedback Yet</h4>
                                <p style="color: #9ca3af;">Feedback from users will appear here.</p>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach($feedbacks as $feedback): ?>
                            <div class="feedback-card">
                                <div class="feedback-header">
                                    <div style="display: flex; justify-content: space-between; align-items: start; gap: 12px; flex-wrap: wrap;">
                                        <div style="flex: 1; min-width: 200px;">
                                            <h5 style="margin: 0 0 6px 0; font-weight: 700; font-size: 16px;">
                                                <?php echo htmlspecialchars($feedback['subject']); ?>
                                            </h5>
                                            <div style="font-size: 12px; opacity: 0.9;">
                                                <i class="bi bi-people-fill" style="margin-right: 4px;"></i>
                                                <?php echo htmlspecialchars($feedback['partner1_name'] . ' & ' . $feedback['partner2_name']); ?>
                                            </div>
                                        </div>
                                        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                                            <span class="<?php echo $feedback['status'] == 'unread' ? 'status-unread' : 'status-read'; ?>">
                                                <?php echo strtoupper($feedback['status']); ?>
                                            </span>
                                            <div style="font-size: 11px; opacity: 0.9; white-space: nowrap;">
                                                <i class="bi bi-clock-fill" style="margin-right: 4px;"></i>
                                                <?php echo date('M j, Y g:i A', strtotime($feedback['date_submitted'])); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="feedback-body">
                                    <div style="margin-bottom: 16px;">
                                        <div style="display: flex; align-items: center; gap: 8px; color: #6b7280; font-size: 13px; margin-bottom: 4px;">
                                            <i class="bi bi-envelope-fill"></i>
                                            <strong>Email:</strong>
                                        </div>
                                        <div style="color: #1f2937; font-size: 14px; margin-left: 24px;">
                                            <?php echo htmlspecialchars($feedback['email']); ?>
                                        </div>
                                    </div>
                                    
                                    <div style="margin-bottom: 16px;">
                                        <div style="display: flex; align-items: center; gap: 8px; color: #6b7280; font-size: 13px; margin-bottom: 8px;">
                                            <i class="bi bi-chat-square-text-fill"></i>
                                            <strong>Message:</strong>
                                        </div>
                                        <div style="background: rgba(249, 250, 251, 0.8); padding: 16px; border-radius: 8px; border-left: 4px solid #4f46e5; color: #374151; line-height: 1.6; font-size: 14px;">
                                            <?php echo nl2br(htmlspecialchars($feedback['message'])); ?>
                                        </div>
                                    </div>
                                    
                                    <?php if($feedback['status'] == 'unread'): ?>
                                        <form method="post" style="display: inline;">
                                            <input type="hidden" name="feedback_id" value="<?php echo $feedback['feedback_id']; ?>">
                                            <button type="submit" name="mark_read" class="btn-mark-read">
                                                <i class="bi bi-check-circle-fill" style="margin-right: 6px;"></i>
                                                Mark as Read
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <div style="color: #10b981; font-style: italic; font-size: 13px; display: flex; align-items: center; gap: 6px;">
                                            <i class="bi bi-check-circle-fill"></i>
                                            Read on <?php echo date('M j, Y g:i A', strtotime($feedback['date_read'])); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<?php require "includes/cc_footer.php"; ?>
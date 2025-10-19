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
?>

<style>
.feedback-card {
    background: white;
    border-radius: 10px;
    margin-bottom: 20px;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.feedback-header {
    background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);
    color: white;
    padding: 15px 20px;
    font-family: inter;
}

.feedback-body {
    padding: 20px;
    font-family: inter;
}

.status-unread {
    background: #ff6b6b;
    color: white;
    padding: 5px 10px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: bold;
}

.status-read {
    background: #51cf66;
    color: white;
    padding: 5px 10px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: bold;
}

.feedback-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.feedback-stats {
    display: flex;
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
    flex: 1;
    text-align: center;
    font-family: inter;
}

.stat-number {
    font-size: 2em;
    font-weight: bold;
    color: #23408E;
}

.stat-label {
    color: #666;
    margin-top: 5px;
}
</style>

<div class="container-fluid">
    <div class='row bg-white' style="height:99px">
        <div class="col-3 pe-0 d-flex align-items-center">
            <img src="images/350 x 88.png" style='height:76px;width:auto;'>
        </div>

        <div class="col-9 d-flex align-items-center justify-content-end" style="font-family:inter;font-size:21px;gap:30px;padding-right:50px"> 
            <a href="dashboard_desk.php" style='color:black;text-decoration:none' class='has_hover'>DASHBOARD</a>
            <a href="feedback_management.php" style='color:#23408E;text-decoration:none;font-weight:bold'>FEEDBACK</a>
            <span>|</span>
            <span>DESK</span>
            <a href="logout_cc.php" style='color:black;text-decoration:none' class='has_hover'>LOGOUT</a>
        </div> 
    </div>
</div>

<div class="feedback-container">
    <h2 style="font-family:inter;font-weight:700;color:#23408E;margin-bottom:30px">Feedback Management</h2>
    
    <?php
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
    ?>
    
    <div class="feedback-stats">
        <div class="stat-card">
            <div class="stat-number"><?php echo $total_feedback; ?></div>
            <div class="stat-label">Total Feedback</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $unread_count; ?></div>
            <div class="stat-label">Unread</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $read_count; ?></div>
            <div class="stat-label">Read</div>
        </div>
    </div>

    <?php if(empty($feedbacks)): ?>
        <div class="feedback-card">
            <div class="feedback-body text-center">
                <h4>No feedback submitted yet</h4>
                <p style="color:#666">Feedback from users will appear here.</p>
            </div>
        </div>
    <?php else: ?>
        <?php foreach($feedbacks as $feedback): ?>
            <div class="feedback-card">
                <div class="feedback-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 style="margin:0;font-weight:600"><?php echo htmlspecialchars($feedback['subject']); ?></h5>
                            <small>From: <?php echo htmlspecialchars($feedback['partner1_name'] . ' & ' . $feedback['partner2_name']); ?></small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="<?php echo $feedback['status'] == 'unread' ? 'status-unread' : 'status-read'; ?>">
                                <?php echo strtoupper($feedback['status']); ?>
                            </span>
                            <small><?php echo date('M j, Y g:i A', strtotime($feedback['date_submitted'])); ?></small>
                        </div>
                    </div>
                </div>
                <div class="feedback-body">
                    <div style="margin-bottom:15px">
                        <strong>Email:</strong> <?php echo htmlspecialchars($feedback['email']); ?>
                    </div>
                    <div style="margin-bottom:15px">
                        <strong>Message:</strong>
                    </div>
                    <div style="background:#f8f9fa;padding:15px;border-radius:5px;margin-bottom:15px">
                        <?php echo nl2br(htmlspecialchars($feedback['message'])); ?>
                    </div>
                    
                    <?php if($feedback['status'] == 'unread'): ?>
                        <form method="post" style="display:inline">
                            <input type="hidden" name="feedback_id" value="<?php echo $feedback['feedback_id']; ?>">
                            <button type="submit" name="mark_read" class="btn" style="background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;padding:8px 20px;border-radius:5px;font-family:inter;font-weight:600">
                                Mark as Read
                            </button>
                        </form>
                    <?php else: ?>
                        <div style="color:#666;font-style:italic">
                            Read on <?php echo date('M j, Y g:i A', strtotime($feedback['date_read'])); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
// Auto refresh every 30 seconds to check for new feedback
setInterval(function() {
    // Only refresh if there are unread messages
    <?php if($unread_count > 0): ?>
    location.reload();
    <?php endif; ?>
}, 30000);
</script>

<?php require "includes/cc_footer.php"; ?>
<?php
session_start();
require_once 'database.php';
header('Content-Type: text/html; charset=utf-8');

$username = isset($_GET['user']) ? $_GET['user'] : null;
$user = null;
$error = null;

if ($username) {
    $user = $db->getUserByUsername($username);
    if (!$user) {
        $error = 'User not found! 👤';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $user ? $user['fullName'] . ' (@' . $user['username'] . ')' : 'Instagram Profile Viewer'; ?> - InstaProfile</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 500px;
            margin: 0 auto;
        }
        
        .search-box {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            margin-bottom: 30px;
        }
        
        .search-box h1 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .search-form {
            display: flex;
            gap: 10px;
        }
        
        .search-form input {
            flex: 1;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: border-color 0.3s;
        }
        
        .search-form input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .search-form button {
            padding: 12px 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: transform 0.2s;
        }
        
        .search-form button:hover {
            transform: translateY(-2px);
        }
        
        .profile-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            animation: slideUp 0.5s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .cover-photo {
            width: 100%;
            height: 150px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }
        
        .cover-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .cover-actions {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            gap: 8px;
        }
        
        .cover-actions a {
            background: rgba(255,255,255,0.9);
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #333;
            font-size: 18px;
            transition: all 0.2s;
        }
        
        .cover-actions a:hover {
            background: white;
            transform: scale(1.1);
        }
        
        .profile-header {
            padding: 0 25px;
            position: relative;
            margin-top: -60px;
        }
        
        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 5px solid white;
            background: white;
            overflow: hidden;
            position: relative;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .profile-pic img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .pic-actions {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0,0,0,0.7);
            display: flex;
            gap: 5px;
            justify-content: space-around;
            padding: 8px 0;
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .profile-pic:hover .pic-actions {
            opacity: 1;
        }
        
        .pic-actions a {
            color: white;
            text-decoration: none;
            font-size: 12px;
            flex: 1;
            text-align: center;
            padding: 5px;
        }
        
        .privacy-badge {
            display: inline-block;
            padding: 5px 12px;
            background: #f0f0f0;
            border-radius: 20px;
            font-size: 12px;
            margin-top: 15px;
            color: #666;
            font-weight: 600;
        }
        
        .privacy-badge.private {
            background: #ffe0e0;
            color: #d32f2f;
        }
        
        .privacy-badge.public {
            background: #e0f2e0;
            color: #1b5e20;
        }
        
        .verified {
            display: inline-block;
            color: #1976d2;
            margin-left: 5px;
        }
        
        .profile-info {
            padding: 20px 25px;
            text-align: center;
        }
        
        .profile-name {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }
        
        .profile-username {
            font-size: 15px;
            color: #999;
            margin-bottom: 15px;
        }
        
        .profile-bio {
            font-size: 15px;
            color: #333;
            line-height: 1.5;
            margin-bottom: 15px;
        }
        
        .profile-contact {
            display: flex;
            justify-content: space-around;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 13px;
        }
        
        .contact-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
            color: #666;
        }
        
        .contact-item strong {
            color: #333;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .stat {
            text-align: center;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 10px;
        }
        
        .stat-number {
            font-size: 22px;
            font-weight: 700;
            color: #667eea;
        }
        
        .stat-label {
            font-size: 12px;
            color: #999;
            margin-top: 5px;
        }
        
        .action-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .btn {
            padding: 12px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 14px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-secondary {
            background: #f0f0f0;
            color: #333;
        }
        
        .btn-secondary:hover {
            background: #e0e0e0;
        }
        
        .details {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
            font-size: 14px;
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            color: #999;
            font-weight: 600;
        }
        
        .detail-value {
            color: #333;
            text-align: right;
        }
        
        .detail-value a {
            color: #667eea;
            text-decoration: none;
        }
        
        .detail-value a:hover {
            text-decoration: underline;
        }
        
        .error {
            background: #fff3e0;
            border: 2px solid #ff9800;
            color: #e65100;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            font-weight: 600;
        }
        
        .public-users {
            margin-top: 30px;
        }
        
        .section-title {
            color: white;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 15px;
        }
        
        .users-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        
        .user-card {
            background: white;
            border-radius: 15px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .user-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        
        .user-card a {
            text-decoration: none;
            color: inherit;
        }
        
        .user-pic {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 10px;
            overflow: hidden;
            background: #f0f0f0;
        }
        
        .user-pic img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .user-name {
            font-weight: 700;
            color: #333;
            font-size: 14px;
        }
        
        .user-username {
            color: #999;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="search-box">
            <h1>🔍 InstaProfile</h1>
            <form class="search-form" method="GET">
                <input type="text" name="user" placeholder="Search username..." value="<?php echo htmlspecialchars($username ?? ''); ?>">
                <button type="submit">Search</button>
            </form>
        </div>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php elseif ($user): ?>
            <div class="profile-card">
                <!-- Cover Photo -->
                <div class="cover-photo">
                    <img src="<?php echo htmlspecialchars($user['coverPhoto']); ?>" alt="Cover">
                    <div class="cover-actions">
                        <a href="download.php?file=<?php echo urlencode($user['coverPhoto']); ?>" title="Download Cover">⬇️</a>
                    </div>
                </div>
                
                <!-- Profile Header -->
                <div class="profile-header">
                    <div class="profile-pic">
                        <img src="<?php echo htmlspecialchars($user['profilePicture']); ?>" alt="<?php echo htmlspecialchars($user['fullName']); ?>">
                        <div class="pic-actions">
                            <a href="download.php?file=<?php echo urlencode($user['profilePicture']); ?>">⬇️ Download</a>
                        </div>
                    </div>
                    
                    <div class="privacy-badge <?php echo $user['isPrivate'] ? 'private' : 'public'; ?>">
                        <?php echo $user['isPrivate'] ? '🔒 Private Account' : '🌍 Public Account'; ?>
                    </div>
                </div>
                
                <!-- Profile Info -->
                <div class="profile-info">
                    <div class="profile-name">
                        <?php echo htmlspecialchars($user['fullName']); ?>
                        <?php if ($user['bio_verified']): ?>
                            <span class="verified">✅</span>
                        <?php endif; ?>
                    </div>
                    <div class="profile-username">@<?php echo htmlspecialchars($user['username']); ?></div>
                    <div class="profile-bio"><?php echo htmlspecialchars($user['bio']); ?></div>
                    
                    <!-- Contact Info -->
                    <div class="profile-contact">
                        <div class="contact-item">
                            <strong>📧 Email</strong>
                            <a href="mailto:<?php echo htmlspecialchars($user['email']); ?>" style="color: #667eea; text-decoration: none;"><?php echo htmlspecialchars($user['email']); ?></a>
                        </div>
                        <?php if ($user['phone']): ?>
                        <div class="contact-item">
                            <strong>📱 Phone</strong>
                            <a href="tel:<?php echo htmlspecialchars($user['phone']); ?>" style="color: #667eea; text-decoration: none;"><?php echo htmlspecialchars($user['phone']); ?></a>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Stats -->
                    <div class="stats">
                        <div class="stat">
                            <div class="stat-number"><?php echo number_format($user['postsCount']); ?></div>
                            <div class="stat-label">Posts</div>
                        </div>
                        <div class="stat">
                            <div class="stat-number"><?php echo count($user['followers']); ?></div>
                            <div class="stat-label">Followers</div>
                        </div>
                        <div class="stat">
                            <div class="stat-number"><?php echo count($user['following']); ?></div>
                            <div class="stat-label">Following</div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <button class="btn btn-primary">👥 Follow</button>
                        <button class="btn btn-secondary">💬 Message</button>
                    </div>
                    
                    <!-- Details -->
                    <div class="details">
                        <div class="detail-row">
                            <span class="detail-label">📍 Location</span>
                            <span class="detail-value"><?php echo htmlspecialchars($user['location']); ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">🌐 Website</span>
                            <span class="detail-value">
                                <?php if ($user['website']): ?>
                                    <a href="<?php echo htmlspecialchars($user['website']); ?>" target="_blank"><?php echo htmlspecialchars($user['website']); ?></a>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">📅 Joined</span>
                            <span class="detail-value"><?php echo date('M d, Y', strtotime($user['createdAt'])); ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">🔄 Last Active</span>
                            <span class="detail-value"><?php echo date('M d, Y H:i', strtotime($user['lastLogin'])); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Public Users Section -->
        <?php if (!$user): ?>
            <div class="public-users">
                <h2 class="section-title">👥 Public Profiles</h2>
                <div class="users-grid">
                    <?php foreach ($db->getPublicUsers() as $publicUser): ?>
                        <div class="user-card">
                            <a href="?user=<?php echo urlencode($publicUser['username']); ?>">
                                <div class="user-pic">
                                    <img src="<?php echo htmlspecialchars($publicUser['profilePicture']); ?>" alt="<?php echo htmlspecialchars($publicUser['fullName']); ?>">
                                </div>
                                <div class="user-name"><?php echo htmlspecialchars($publicUser['fullName']); ?></div>
                                <div class="user-username">@<?php echo htmlspecialchars($publicUser['username']); ?></div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

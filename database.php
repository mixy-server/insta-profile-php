<?php
require_once 'config.php';

class Database {
    private $users = array();
    private $posts = array();
    
    public function __construct() {
        $this->initializeData();
    }
    
    private function initializeData() {
        $this->users = array(
            'user1' => array(
                'id' => 'user1',
                'username' => 'john_doe',
                'email' => 'john@example.com',
                'fullName' => 'John Doe',
                'bio' => '📸 Photography Enthusiast | Traveler',
                'profilePicture' => 'uploads/john_doe_profile.jpg',
                'coverPhoto' => 'uploads/john_doe_cover.jpg',
                'phone' => '+1-234-567-8901',
                'location' => 'New York, USA',
                'website' => 'https://johndoe.com',
                'isPrivate' => false,
                'followers' => array('user2', 'user3', 'user4'),
                'following' => array('user2', 'user3'),
                'postsCount' => 45,
                'bio_verified' => true,
                'createdAt' => '2022-01-15',
                'lastLogin' => '2024-01-20 10:30:00'
            ),
            'user2' => array(
                'id' => 'user2',
                'username' => 'jane_private',
                'email' => 'jane@example.com',
                'fullName' => 'Jane Smith',
                'bio' => '🔒 Private Account | No DMs',
                'profilePicture' => 'uploads/jane_private_profile.jpg',
                'coverPhoto' => 'uploads/jane_private_cover.jpg',
                'phone' => '+1-345-678-9012',
                'location' => 'Paris, France',
                'website' => 'https://janesmith.com',
                'isPrivate' => true,
                'followers' => array('user1'),
                'following' => array('user1'),
                'postsCount' => 12,
                'bio_verified' => false,
                'createdAt' => '2022-06-20',
                'lastLogin' => '2024-01-19 15:45:00'
            ),
            'user3' => array(
                'id' => 'user3',
                'username' => 'alex_adventures',
                'email' => 'alex@example.com',
                'fullName' => 'Alex Johnson',
                'bio' => '✈️ World Traveler | Food Lover',
                'profilePicture' => 'uploads/alex_adventures_profile.jpg',
                'coverPhoto' => 'uploads/alex_adventures_cover.jpg',
                'phone' => '+1-456-789-0123',
                'location' => 'London, UK',
                'website' => 'https://alextravel.com',
                'isPrivate' => false,
                'followers' => array('user1', 'user2', 'user4'),
                'following' => array('user1', 'user4'),
                'postsCount' => 78,
                'bio_verified' => true,
                'createdAt' => '2021-03-10',
                'lastLogin' => '2024-01-20 08:20:00'
            ),
            'user4' => array(
                'id' => 'user4',
                'username' => 'sarah_secret',
                'email' => 'sarah@example.com',
                'fullName' => 'Sarah Williams',
                'bio' => '🤫 Private & Mysterious',
                'profilePicture' => 'uploads/sarah_secret_profile.jpg',
                'coverPhoto' => 'uploads/sarah_secret_cover.jpg',
                'phone' => '+1-567-890-1234',
                'location' => 'Sydney, Australia',
                'website' => '',
                'isPrivate' => true,
                'followers' => array('user1', 'user3'),
                'following' => array('user3'),
                'postsCount' => 5,
                'bio_verified' => false,
                'createdAt' => '2023-02-05',
                'lastLogin' => '2024-01-20 12:00:00'
            )
        );
    }
    
    public function getUserByUsername($username) {
        foreach ($this->users as $user) {
            if ($user['username'] === $username) {
                return $user;
            }
        }
        return null;
    }
    
    public function getUserById($userId) {
        return isset($this->users[$userId]) ? $this->users[$userId] : null;
    }
    
    public function getAllUsers() {
        return $this->users;
    }
    
    public function getPublicUsers() {
        $publicUsers = array();
        foreach ($this->users as $user) {
            if (!$user['isPrivate']) {
                $publicUsers[] = $user;
            }
        }
        return $publicUsers;
    }
    
    public function getPrivateUsers() {
        $privateUsers = array();
        foreach ($this->users as $user) {
            if ($user['isPrivate']) {
                $privateUsers[] = $user;
            }
        }
        return $privateUsers;
    }
    
    public function updateProfilePicture($userId, $filename) {
        if (isset($this->users[$userId])) {
            $this->users[$userId]['profilePicture'] = UPLOAD_DIR . $filename;
            return true;
        }
        return false;
    }
    
    public function updateCoverPhoto($userId, $filename) {
        if (isset($this->users[$userId])) {
            $this->users[$userId]['coverPhoto'] = UPLOAD_DIR . $filename;
            return true;
        }
        return false;
    }
    
    public function getUserStats($userId) {
        $user = $this->getUserById($userId);
        if (!$user) return null;
        
        return array(
            'followers' => count($user['followers']),
            'following' => count($user['following']),
            'posts' => $user['postsCount'],
            'isPrivate' => $user['isPrivate']
        );
    }
}

$db = new Database();
?>

# Instagram Profile PHP 📸

A complete Instagram-style profile viewer with public & private accounts, real profile pictures, and download functionality.

## Features ✨

- 🔍 **Search Users** - Find profiles by username
- 👥 **Public & Private Accounts** - Different visibility levels
- 📸 **Profile Pictures** - View and download user profile photos
- 🖼️ **Cover Photos** - Beautiful cover images with download
- ✅ **Verified Badges** - Mark verified users
- 📊 **User Stats** - Posts, followers, following counts
- 📧 **Contact Info** - Email, phone, location, website
- 🎯 **User Directory** - Browse all public profiles
- 📥 **Download Feature** - Download profile & cover photos
- 🔐 **Security** - File validation and access control

## Sample Users 👤

### Public Accounts
1. **john_doe** (@john_doe)
   - Full Name: John Doe
   - Bio: 📸 Photography Enthusiast | Traveler
   - Location: New York, USA
   - Followers: 3 | Following: 2 | Posts: 45
   - Verified ✅

2. **alex_adventures** (@alex_adventures)
   - Full Name: Alex Johnson
   - Bio: ✈️ World Traveler | Food Lover
   - Location: London, UK
   - Followers: 3 | Following: 2 | Posts: 78
   - Verified ✅

### Private Accounts
1. **jane_private** (@jane_private)
   - Full Name: Jane Smith
   - Bio: 🔒 Private Account | No DMs
   - Location: Paris, France
   - Followers: 1 | Following: 1 | Posts: 12
   - Status: 🔒 Private

2. **sarah_secret** (@sarah_secret)
   - Full Name: Sarah Williams
   - Bio: 🤫 Private & Mysterious
   - Location: Sydney, Australia
   - Followers: 2 | Following: 1 | Posts: 5
   - Status: 🔒 Private

## Installation 🚀

### Requirements
- PHP 7.0+
- Web Server (Apache, Nginx)
- Folder Permissions (755 for uploads/)

### Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/mixy-server/insta-profile-php.git
   cd insta-profile-php
   ```

2. **Create uploads folder**
   ```bash
   mkdir uploads
   chmod 755 uploads
   ```

3. **Add sample images** (optional)
   ```bash
   # Add profile pictures to uploads/ folder:
   uploads/john_doe_profile.jpg
   uploads/jane_private_profile.jpg
   uploads/alex_adventures_profile.jpg
   uploads/sarah_secret_profile.jpg
   
   # Add cover photos:
   uploads/john_doe_cover.jpg
   uploads/jane_private_cover.jpg
   uploads/alex_adventures_cover.jpg
   uploads/sarah_secret_cover.jpg
   ```

4. **Run with PHP Built-in Server**
   ```bash
   php -S localhost:8000
   ```

5. **Access in Browser**
   ```
   http://localhost:8000
   ```

## Usage 📖

### View Profile
```
http://localhost:8000?user=john_doe
http://localhost:8000?user=jane_private
http://localhost:8000?user=alex_adventures
```

### Download Profile Picture
```
http://localhost:8000/download.php?file=uploads/john_doe_profile.jpg
```

### Upload New Profile Picture
```bash
curl -X POST http://localhost:8000/upload.php \
  -F "userId=user1" \
  -F "type=profile" \
  -F "profilePicture=@path/to/image.jpg"
```

### Upload Cover Photo
```bash
curl -X POST http://localhost:8000/upload.php \
  -F "userId=user1" \
  -F "type=cover" \
  -F "profilePicture=@path/to/cover.jpg"
```

## API Endpoints 🔌

### GET Endpoints

| Endpoint | Description |
|----------|-------------|
| `index.php?user=username` | View user profile |
| `download.php?file=path` | Download image file |

### POST Endpoints

| Endpoint | Description |
|----------|-------------|
| `upload.php` | Upload profile/cover picture |

## File Structure 📁

```
insta-profile-php/
├── index.php          # Main profile viewer
├── upload.php         # File upload handler
├── download.php       # File download handler
├── database.php       # User data
├── config.php         # Configuration
├── README.md          # Documentation
└── uploads/           # Profile pictures & covers
    ├── john_doe_profile.jpg
    ├── john_doe_cover.jpg
    ├── jane_private_profile.jpg
    └── ...
```

## Security Features 🔐

- ✅ File type validation (images only)
- ✅ File size limits (5MB max)
- ✅ Directory traversal prevention
- ✅ MIME type checking
- ✅ Secure file permissions
- ✅ Session management

## Customization 🎨

### Change Colors
Edit the CSS in `index.php` gradient colors:
```css
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
```

### Add New Users
Edit `database.php` and add to `$users` array

### Change Max Upload Size
Edit `config.php`:
```php
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10MB
```

## Features in Detail 💡

### Profile Display
- Cover photo with download button
- Circular profile picture with download overlay
- User stats (posts, followers, following)
- Full user details (email, phone, location, website)
- Join date and last active timestamp
- Private/Public account badge
- Verified user checkmark

### User Discovery
- Search users by username
- Browse public profiles grid
- View user bio and location
- Follow/Message buttons

### Download System
- Download profile pictures
- Download cover photos
- Secure file access control
- Original filename preservation

## Troubleshooting 🐛

### 404 File Not Found
- Check if uploads folder exists
- Verify file paths in database.php
- Create placeholder images

### Upload Fails
- Check folder permissions (755)
- Verify file is actually an image
- Check file size < 5MB

### Images Not Showing
- Verify uploads folder is readable
- Check image file paths
- Use absolute paths in config

## License 📄

MIT License - Feel free to use and modify

## Support 💬

For issues and questions:
- GitHub Issues: https://github.com/mixy-server/insta-profile-php/issues
- Email: mixy-server@example.com

---

**Made with ❤️ by Mixy Server**

# 🎯 Admin Panel Documentation

## 📁 File Structure
```
admin/
├── auth.php                 # Authentication middleware (include in all admin pages)
├── header.php               # Admin header with sidebar
├── footer.php               # Admin footer with scripts
├── admin-styles.css         # All admin panel styling
├── dashboard.php            # Main admin dashboard (stats & overview)
├── manage_users.php         # User management (view, delete, change role)
├── manage_services.php      # Service management (add, edit, delete)
└── manage_bookings.php      # Booking management (view, update status)
```

## 🔐 Authentication

All admin pages are protected by `admin/auth.php`. This file:
- Checks if user is logged in via session
- Verifies user has `role = 'admin'`
- Redirects non-admin users to the regular site

### How to Use Auth.php
Simply include it at the top of each admin page:
```php
<?php
include 'auth.php';
include 'header.php';
// Your content here
include 'footer.php';
?>
```

## 🎨 Design & Styling

### Color Scheme (Matching Your Theme)
- **Primary Background**: White (#FAFAFA)
- **Secondary/Accent**: Green (#10B981) - For highlights
- **Dark Accent**: Dark Gray (#1F2937) - For header/sidebar
- **Status Colors**:
  - Pending: Yellow (#F59E0B)
  - Confirmed: Blue (#3B82F6)
  - Completed: Green (#10B981)
  - Cancelled: Red (#DC2626)

### CSS Components
All styling is in `admin-styles.css` - includes:
- Responsive sidebar navigation
- Professional stat cards
- Data tables with hover effects
- Forms with validation styling
- Status badges and filters
- Mobile-friendly design

### Responsive Breakpoints
- **Desktop**: Full sidebar + main content
- **Tablet (1024px)**: Condensed sidebar (200px)
- **Mobile (768px)**: Hidden sidebar (toggle via hamburger)
- **Small phones (480px)**: Full-width, stacked layout

## 📊 Pages Overview

### 1. Dashboard (`dashboard.php`)
**Purpose**: Overview of business metrics

**Features**:
- Total Users count card
- Total Services count card
- Total Bookings count card
- Total Revenue (confirmed + completed bookings)
- Booking status breakdown with visual progress bars
- Recent 5 bookings list
- Quick action buttons

**Database Queries**:
- Count users, services, bookings
- Sum revenue from confirmed/completed bookings
- Group bookings by status
- Fetch latest 5 bookings with joins

### 2. Manage Users (`manage_users.php`)
**Purpose**: View and manage platform users

**Features**:
- View all users in table format
- User count by role (Admin/Regular)
- Change user role (User ↔ Admin)
- Delete user account
- Prevents admin from deleting themselves
- Displays: Name, Email, Phone, Role, Member Since

**Database Queries**:
- SELECT all users with sorting
- UPDATE user role
- DELETE user account

**Security**:
- Validates role values before update
- Prevents self-deletion and self-role change

### 3. Manage Services (`manage_services.php`)
**Purpose**: CRUD operations for services

**Features**:
- Add new service with:
  - Service name
  - Category selection
  - Icon class (FontAwesome)
  - Description
  - Mark as popular checkbox
- Edit existing services
- Delete services
- View all services table
- Filter by popularity

**Database Queries**:
- SELECT all categories
- SELECT all services with category names
- INSERT new service
- UPDATE service details
- DELETE service

**Validation**:
- Service name is required
- Category must be valid ID
- Icon class is optional with default value
- Popular flag is optional

### 4. Manage Bookings (`manage_bookings.php`)
**Purpose**: Track and update booking statuses

**Features**:
- View all bookings with pagination (15 per page)
- Filter by status: Pending, Confirmed, Completed, Cancelled
- Update booking status (dropdown)
- Display booking details:
  - Booking ID (formatted: #000123)
  - Service name
  - Customer name & email
  - Provider name
  - Booking date & time
  - Total amount with GST breakdown
  - Current status with badge

**Database Queries**:
- SELECT bookings with JOINS to services, users, providers
- Count bookings by status
- UPDATE booking status
- Pagination with LIMIT & OFFSET

**Features**:
- Status filter buttons with counts
- Inline status update forms
- Pagination controls (First, Previous, Next, Last)
- Responsive table design

## 🔄 Login Flow

1. User logs in via `/login.php`
2. If role = 'admin', redirects to `/admin/dashboard.php`
3. If role = 'user', redirects to `/dashboard.php`
4. All admin pages check session & role via `auth.php`
5. Invalid access redirects to appropriate page

## 🛠️ How to Use

### Access Admin Panel
1. **Create an admin user** in your database:
   ```sql
   UPDATE users SET role = 'admin' WHERE user_id = 1;
   ```
   
2. **Login** with admin credentials at `/login.php`

3. **Redirects automatically** to `/admin/dashboard.php`

### Manage Users
- Go to "Users" in sidebar
- View all users with their details
- Click shield icon to change role
- Click trash icon to delete user

### Manage Services
- Go to "Services" in sidebar
- Fill form to add new service
- Click edit icon to modify existing service
- Click trash icon to delete service

### Manage Bookings
- Go to "Bookings" in sidebar
- Use filter buttons to view by status
- Click edit icon to change booking status
- Pagination for viewing large lists

## 📝 Code Standards

### Used Throughout Admin Panel
- **MySQLi Prepared Statements**: Prevents SQL injection
- **htmlspecialchars()**: XSS protection for output
- **Proper URL encoding**: For URLs and parameters
- **Session validation**: Every page checks auth
- **Form submission**: POST method with action field
- **Error handling**: Try-catch and graceful fallbacks

### Example Pattern
```php
<?php
include 'auth.php';  // Verify admin access
include 'header.php'; // Include header & sidebar

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = (int)$_POST['user_id'];
    
    $sql = "UPDATE users SET role = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newRole, $userId);
    
    if ($stmt->execute()) {
        header("Location: manage_users.php?message=Updated");
        exit();
    }
    $stmt->close();
}

// Fetch and display data
$sql = "SELECT * FROM users";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!-- Display data -->
<?php foreach ($users as $user): ?>
    <tr>
        <td><?php echo htmlspecialchars($user['name']); ?></td>
    </tr>
<?php endforeach; ?>

<?php include 'footer.php'; ?>
```

## 🎯 Key Features

✅ **Professional UI** - Modern design matching your theme  
✅ **Fully Functional** - Real database operations  
✅ **Secure** - Prepared statements, session validation  
✅ **Responsive** - Works on desktop, tablet, mobile  
✅ **Modular** - Reusable header/footer/auth components  
✅ **User-Friendly** - Clear navigation, quick actions  
✅ **Scalable** - Easy to add more admin features  

## 🚀 Adding New Admin Pages

To create a new admin page:

1. Create file: `admin/new_page.php`
2. Start with:
```php
<?php
include 'auth.php';
include 'header.php';
?>

<!-- Your content here -->

<?php include 'footer.php'; ?>
```

3. Add navigation link in `admin/header.php`:
```php
<li class="nav-item">
    <a href="new_page.php" class="nav-link">
        <i class="fa-solid fa-icon"></i>
        <span>New Page</span>
    </a>
</li>
```

4. Style as needed using existing CSS classes

## 📞 Support & Customization

### Change Colors
Edit color variables in `admin-styles.css` or `CSS/commonfile.css`

### Add More Stats
Query database in `dashboard.php` and add new stat cards

### Add More Filters
Use similar pattern in `manage_bookings.php` for other pages

### Change Sidebar Navigation
Edit nav items in `header.php` nav-list

## 📋 Database Requirements

Ensure these tables exist in your database:
- `users` (with role field)
- `services`
- `categories`
- `bookings`
- `provider`

## ✨ Best Practices

1. **Always use prepared statements** for queries
2. **Validate & sanitize** all inputs
3. **Use htmlspecialchars()** when outputting user data
4. **Check role** at the beginning of each admin page
5. **Use POST** for form submissions
6. **Redirect after POST** to prevent resubmission
7. **Add confirmation dialogs** for destructive actions

---

**Admin Panel Built with ❤️ for Fixora**

Enjoy your fully functional admin dashboard! 🎉

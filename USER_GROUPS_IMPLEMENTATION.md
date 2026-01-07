# User Groups Implementation - Multiple Groups Support

## Overview
Updated the user management system to support multiple groups per user using a many-to-many relationship.

## Changes Made

### Backend Changes

#### UserController.php
- **index()**: Now loads both `roles` and `groups` relationships
- **store()**: Added validation and sync for multiple groups via `groups[]` array
- **edit()**: Loads `groups` relationship along with roles
- **update()**: Syncs multiple groups, detaches if none selected
- **show()**: Loads groups relationship for display

#### Validation Rules
```php
'groups' => 'nullable|array',
'groups.*' => 'exists:groups,id',
```

### Frontend Changes

#### users/index.blade.php
- Added "Groups" column to the users table
- Displays multiple group badges for each user
- Added "Manage User Groups" button in header
- Added quick "Manage Groups" icon button for each user row
- Updated colspan for empty state (6 → 7)

#### users/create.blade.php
- Replaced single group dropdown with checkbox-based multiple group selection
- Kept legacy "Primary Group" dropdown for backward compatibility
- Shows group descriptions under each checkbox option

#### users/edit.blade.php
- Replaced single group dropdown with checkbox-based multiple group selection
- Pre-selects user's current groups using `$user->groups->pluck('id')->toArray()`
- Kept legacy "Primary Group" dropdown for backward compatibility
- Shows group descriptions under each checkbox option

#### users/show.blade.php
- Added Groups row in user details table
- Added dedicated "Assigned Groups" section after roles
- Displays groups as cards with name, description, and member count

#### layouts/admin.blade.php
- Added "User Groups" menu item under "User Management" section
- Properly highlights when on user-groups routes

## Features

### Multiple Groups per User
- Users can now be assigned to multiple groups simultaneously
- Checkbox interface for easy selection
- Visual group badges throughout the interface

### Backward Compatibility
- Legacy `group_id` field still supported
- Single group relationship (`$user->group`) still works
- New many-to-many relationship (`$user->groups`) available

### User Interface Enhancements
- Quick access to manage groups from users list
- Visual group badges with descriptions
- Dedicated group management section in user details
- Integration with existing user-groups management system

## Database Schema
- `user_group` pivot table with:
  - `user_id` (foreign key)
  - `group_id` (foreign key)
  - Unique constraint on [user_id, group_id]
  - Cascade delete on both foreign keys

## Usage Examples

### In Controllers
```php
// Get user's groups
$user->groups; // Collection of groups

// Attach groups to user
$user->groups()->attach([1, 2, 3]);

// Sync groups (replace all)
$user->groups()->sync([1, 2, 3]);

// Detach a group
$user->groups()->detach(1);

// Detach all groups
$user->groups()->detach();
```

### In Blade Views
```blade
{{-- Display user's groups --}}
@foreach($user->groups as $group)
    <span class="badge bg-success">{{ $group->name }}</span>
@endforeach

{{-- Check if user has groups --}}
@if($user->groups->count() > 0)
    User has {{ $user->groups->count() }} group(s)
@endif
```

### Form Handling
```blade
{{-- Create checkboxes for group selection --}}
@foreach ($groups as $group)
    <input type="checkbox" name="groups[]" value="{{ $group->id }}"
        {{ in_array($group->id, old('groups', $user->groups->pluck('id')->toArray())) ? 'checked' : '' }}>
    {{ $group->name }}
@endforeach
```

## Routes
- `/users` - List users with their groups
- `/users/{user}/edit` - Edit user (including multiple groups)
- `/users/{user}` - View user details (including groups)
- `/user-groups` - Dedicated user-group management interface
- `/user-groups/{user}/edit` - Focused group assignment for a user

## Navigation
- **Admin Sidebar**: User Management > User Groups
- **Users Index**: "Manage User Groups" button (header)
- **Users Index**: Green collection icon per user row
- **User Details**: Groups section with full details

## Testing Checklist
- ✅ Create user with multiple groups
- ✅ Edit user and update groups
- ✅ View user with groups displayed
- ✅ Remove all groups from user
- ✅ Navigate to user-groups management
- ✅ Quick edit groups from users list
- ✅ Legacy group_id still works

## Migration
Run `php artisan migrate` to create the `user_group` pivot table.

## Benefits
1. **Flexible**: Users can belong to multiple communities/teams
2. **Scalable**: Easy to add/remove group memberships
3. **Compatible**: Works alongside existing single-group system
4. **User-Friendly**: Intuitive checkbox interface
5. **Visual**: Clear group badges throughout the UI
6. **Integrated**: Seamlessly works with dedicated user-groups pages

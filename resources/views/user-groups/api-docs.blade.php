@extends('layouts.app')

@section('title', 'User Groups API Documentation')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="mb-3">User Groups API Documentation</h1>
            <p class="text-muted">API endpoints for managing user-group relationships</p>
        </div>
    </div>

    <div class="accordion" id="apiAccordion">
        <!-- Get User Groups -->
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#endpoint1">
                    <span class="badge bg-success me-2">GET</span>
                    <code>/api/users/{user}/groups</code>
                </button>
            </h2>
            <div id="endpoint1" class="accordion-collapse collapse show" data-bs-parent="#apiAccordion">
                <div class="accordion-body">
                    <h5>Get all groups for a specific user</h5>
                    <p><strong>Description:</strong> Returns a user and all their associated groups.</p>
                    
                    <h6>Parameters:</h6>
                    <ul>
                        <li><code>user</code> (required) - User ID</li>
                    </ul>

                    <h6>Example Response:</h6>
                    <pre class="bg-light p-3 rounded"><code>{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  },
  "groups": [
    {
      "id": 1,
      "name": "Developers",
      "description": "Development team"
    },
    {
      "id": 2,
      "name": "Managers",
      "description": "Management team"
    }
  ]
}</code></pre>
                </div>
            </div>
        </div>

        <!-- Get Group Users -->
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#endpoint2">
                    <span class="badge bg-success me-2">GET</span>
                    <code>/api/groups/{group}/users</code>
                </button>
            </h2>
            <div id="endpoint2" class="accordion-collapse collapse" data-bs-parent="#apiAccordion">
                <div class="accordion-body">
                    <h5>Get all users in a specific group</h5>
                    <p><strong>Description:</strong> Returns a group and all its members.</p>
                    
                    <h6>Parameters:</h6>
                    <ul>
                        <li><code>group</code> (required) - Group ID</li>
                    </ul>

                    <h6>Example Response:</h6>
                    <pre class="bg-light p-3 rounded"><code>{
  "group": {
    "id": 1,
    "name": "Developers",
    "description": "Development team"
  },
  "users": [
    {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com"
    },
    {
      "id": 2,
      "name": "Jane Smith",
      "email": "jane@example.com"
    }
  ]
}</code></pre>
                </div>
            </div>
        </div>

        <!-- Attach Group -->
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#endpoint3">
                    <span class="badge bg-primary me-2">POST</span>
                    <code>/user-groups/{user}/attach</code>
                </button>
            </h2>
            <div id="endpoint3" class="accordion-collapse collapse" data-bs-parent="#apiAccordion">
                <div class="accordion-body">
                    <h5>Attach a group to a user</h5>
                    <p><strong>Description:</strong> Adds a user to a group (if not already a member).</p>
                    
                    <h6>Parameters:</h6>
                    <ul>
                        <li><code>user</code> (required) - User ID in URL</li>
                        <li><code>group_id</code> (required) - Group ID in request body</li>
                    </ul>

                    <h6>Example Request:</h6>
                    <pre class="bg-light p-3 rounded"><code>{
  "group_id": 1
}</code></pre>

                    <h6>Example Response (Success):</h6>
                    <pre class="bg-light p-3 rounded"><code>{
  "message": "Group attached successfully"
}</code></pre>

                    <h6>Example Response (Already Exists):</h6>
                    <pre class="bg-light p-3 rounded"><code>{
  "message": "User already in this group"
}</code></pre>
                </div>
            </div>
        </div>

        <!-- Detach Group -->
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#endpoint4">
                    <span class="badge bg-danger me-2">DELETE</span>
                    <code>/user-groups/{user}/detach/{group}</code>
                </button>
            </h2>
            <div id="endpoint4" class="accordion-collapse collapse" data-bs-parent="#apiAccordion">
                <div class="accordion-body">
                    <h5>Detach a group from a user</h5>
                    <p><strong>Description:</strong> Removes a user from a group.</p>
                    
                    <h6>Parameters:</h6>
                    <ul>
                        <li><code>user</code> (required) - User ID</li>
                        <li><code>group</code> (required) - Group ID</li>
                    </ul>

                    <h6>Example Response:</h6>
                    <pre class="bg-light p-3 rounded"><code>{
  "message": "Group detached successfully"
}</code></pre>
                </div>
            </div>
        </div>

        <!-- Update User Groups -->
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#endpoint5">
                    <span class="badge bg-warning me-2">PUT</span>
                    <code>/user-groups/{user}</code>
                </button>
            </h2>
            <div id="endpoint5" class="accordion-collapse collapse" data-bs-parent="#apiAccordion">
                <div class="accordion-body">
                    <h5>Update user's groups (sync)</h5>
                    <p><strong>Description:</strong> Syncs a user's groups. Removes any groups not in the list and adds new ones.</p>
                    
                    <h6>Parameters:</h6>
                    <ul>
                        <li><code>user</code> (required) - User ID in URL</li>
                        <li><code>groups</code> (optional) - Array of group IDs in request body</li>
                    </ul>

                    <h6>Example Request:</h6>
                    <pre class="bg-light p-3 rounded"><code>{
  "groups": [1, 2, 3]
}</code></pre>

                    <h6>Example Response:</h6>
                    <pre class="bg-light p-3 rounded"><code>Redirects to /user-groups with success message</code></pre>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="bi bi-info-circle"></i> Additional Information</h5>
        </div>
        <div class="card-body">
            <h6>Authentication</h6>
            <p>All endpoints require authentication. Make sure to include authentication headers in your requests.</p>

            <h6>Database Schema</h6>
            <p>The <code>user_group</code> table structure:</p>
            <ul>
                <li><code>id</code> - Primary key</li>
                <li><code>user_id</code> - Foreign key to users table</li>
                <li><code>group_id</code> - Foreign key to groups table</li>
                <li><code>created_at</code> - Timestamp</li>
                <li><code>updated_at</code> - Timestamp</li>
                <li>Unique constraint on [user_id, group_id]</li>
            </ul>

            <h6>Model Relationships</h6>
            <pre class="bg-light p-3 rounded"><code>// Get user's groups
$user->groups;

// Get group's users
$group->users;

// Attach a group to user
$user->groups()->attach($groupId);

// Detach a group from user
$user->groups()->detach($groupId);

// Sync user's groups
$user->groups()->sync([1, 2, 3]);</code></pre>
        </div>
    </div>
</div>
@endsection

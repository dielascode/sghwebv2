<div class="container-fluid p-4 p-lg-5">
    <!-- Order Management Container -->
    <div class="d-flex justify-content-between align-items-center mb-4 mb-lg-5 mb-xl-6">
        <div>
            <h1 class="h3 mb-0">User Management</h1>
            <p class="text-muted mb-0">Manage users, roles, and permissions</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="bi bi-upload me-2"></i>Import Users
            </button>
            <button type="button" class="btn btn-outline-secondary" @click="exportUsers()">
                <i class="bi bi-download me-2"></i>Export
            </button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">
                <i class="bi bi-person-plus me-2"></i>Add User
            </button>
        </div>
    </div>

    <!-- Users Management Container -->
    <div x-data="userTable">

        <!-- User Stats Widgets -->
        <div class="row g-4 g-lg-5 g-xl-6 mb-5 mb-lg-5 mb-xl-6">
            <div class="col-xl-3 col-lg-6">
                <div class="card stats-card">
                    <div class="card-body p-3 p-lg-4">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon bg-primary bg-opacity-10 text-primary me-3">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Total Users</h6>
                                <h3 class="mb-0" x-text="stats.total"></h3>
                                <small class="text-success">
                                    <i class="bi bi-arrow-up"></i> +12% from last month
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card stats-card">
                    <div class="card-body p-3 p-lg-4">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon bg-success bg-opacity-10 text-success me-3">
                                <i class="bi bi-person-check-fill"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Active Users</h6>
                                <h3 class="mb-0" x-text="stats.active"></h3>
                                <small class="text-success">
                                    <i class="bi bi-arrow-up"></i> +8% from last week
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card stats-card">
                    <div class="card-body p-3 p-lg-4">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon bg-info bg-opacity-10 text-info me-3">
                                <i class="bi bi-person-plus-fill"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">New This Month</h6>
                                <h3 class="mb-0" x-text="stats.newThisMonth"></h3>
                                <small class="text-success">
                                    <i class="bi bi-arrow-up"></i> +15% growth
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card stats-card">
                    <div class="card-body p-3 p-lg-4">
                        <div class="d-flex align-items-center">
                            <div id="activeUserChart" style="min-height: 40px; width: 50px;"></div>
                            <div class="ms-3">
                                <h6 class="mb-0 text-muted">Active Rate</h6>
                                <h3 class="mb-0" x-text="`${Math.round(stats.activePercentage)}%`"></h3>
                                <small class="text-muted">
                                    <i class="bi bi-clock"></i> Last 24h
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Users Table -->

<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="card-title mb-0">Users Directory</h5>
            </div>
            <div class="col-auto">
                <div class="d-flex gap-2">
                    <!-- Search -->
                    <div class="position-relative">
                        <input type="search"
                            class="form-control form-control-sm"
                            placeholder="Search users..."
                            x-model="searchQuery"
                            @input="filterUsers()"
                            style="width: 200px;">
                        <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-2 text-muted"></i>
                    </div>

                    <!-- Status Filter -->
                    <select class="form-select form-select-sm"
                        x-model="statusFilter"
                        @change="filterUsers()"
                        style="width: 150px;">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="pending">Pending</option>
                    </select>

                    <!-- Role Filter -->
                    <select class="form-select form-select-sm"
                        x-model="roleFilter"
                        @change="filterUsers()"
                        style="width: 150px;">
                        <option value="">All Roles</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                        <option value="moderator">Moderator</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <!-- Bulk Actions Bar -->
        <div class="bulk-actions-bar p-3 bg-primary bg-opacity-10 border-bottom border-primary border-opacity-25"
            x-show="selectedUsers.length > 0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill text-primary me-2"></i>
                    <span class="fw-medium text-primary">
                        <span x-text="selectedUsers.length"></span> user<span x-show="selectedUsers.length !== 1">s</span> selected
                    </span>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-success" @click="bulkAction('activate')">
                        <i class="bi bi-check-circle me-1"></i>Activate
                    </button>
                    <button class="btn btn-sm btn-warning" @click="bulkAction('deactivate')">
                        <i class="bi bi-x-circle me-1"></i>Deactivate
                    </button>
                    <button class="btn btn-sm btn-danger" @click="bulkAction('delete')">
                        <i class="bi bi-trash me-1"></i>Delete
                    </button>
                    <button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center justify-content-center px-2" @click="selectedUsers = []" title="Clear selection">
                        <i class="bi bi-x-lg" style="margin-left: 7px"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 40px;">
                            <input type="checkbox"
                                class="user-select-checkbox"
                                @change="toggleAll($event.target.checked)"
                                :checked="selectedUsers.length === filteredUsers.length && filteredUsers.length > 0">
                        </th>
                        <th @click="sortBy('name')" class="sortable">
                            Name
                            <i class="bi bi-arrow-up" x-show="sortField === 'name' && sortDirection === 'asc'"></i>
                            <i class="bi bi-arrow-down" x-show="sortField === 'name' && sortDirection === 'desc'"></i>
                        </th>
                        <th @click="sortBy('email')" class="sortable">
                            Email
                            <i class="bi bi-arrow-up" x-show="sortField === 'email' && sortDirection === 'asc'"></i>
                            <i class="bi bi-arrow-down" x-show="sortField === 'email' && sortDirection === 'desc'"></i>
                        </th>
                        <th>Role</th>
                        <th>Status</th>
                        <th @click="sortBy('lastActive')" class="sortable">
                            Last Active
                            <i class="bi bi-arrow-up" x-show="sortField === 'lastActive' && sortDirection === 'asc'"></i>
                            <i class="bi bi-arrow-down" x-show="sortField === 'lastActive' && sortDirection === 'desc'"></i>
                        </th>
                        <th style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="user in paginatedUsers" :key="user.id">
                        <tr :class="{ 'selected': selectedUsers.includes(user.id) }">
                            <td>
                                <input type="checkbox"
                                    class="user-select-checkbox"
                                    :value="user.id"
                                    :checked="selectedUsers.includes(user.id)"
                                    @change="toggleUser(user.id)">
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img :src="user.avatar"
                                        class="rounded-circle me-2"
                                        width="32"
                                        height="32"
                                        :alt="user.name">
                                    <div>
                                        <div class="fw-medium" x-text="user.name"></div>
                                        <small class="text-muted" x-text="'ID: ' + user.id"></small>
                                    </div>
                                </div>
                            </td>
                            <td x-text="user.email"></td>
                            <td>
                                <span class="badge"
                                    :class="{
                                                                  'bg-danger': user.role === 'admin',
                                                                  'bg-primary': user.role === 'user', 
                                                                  'bg-warning': user.role === 'moderator'
                                                              }"
                                    x-text="user.role"></span>
                            </td>
                            <td>
                                <span class="badge"
                                    :class="{
                                                                  'bg-success': user.status === 'active',
                                                                  'bg-secondary': user.status === 'inactive',
                                                                  'bg-warning': user.status === 'pending'
                                                              }"
                                    x-text="user.status"></span>
                            </td>
                            <td x-text="user.lastActive"></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                        type="button"
                                        data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" @click="editUser(user)">
                                                <i class="bi bi-pencil me-2"></i>Edit
                                            </a></li>
                                        <li><a class="dropdown-item" href="#" @click="viewUser(user)">
                                                <i class="bi bi-eye me-2"></i>View Profile
                                            </a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item text-danger" href="#" @click="deleteUser(user)">
                                                <i class="bi bi-trash me-2"></i>Delete
                                            </a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center p-3">
            <div class="text-muted">
                Showing <span x-text="(currentPage - 1) * itemsPerPage + 1"></span> to
                <span x-text="Math.min(currentPage * itemsPerPage, filteredUsers.length)"></span> of
                <span x-text="filteredUsers.length"></span> results
            </div>
            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item" :class="{ 'disabled': currentPage === 1 }">
                        <a class="page-link" href="#" @click.prevent="goToPage(currentPage - 1)">Previous</a>
                    </li>
                    <template x-for="page in visiblePages" :key="page">
                        <li class="page-item" :class="{ 'active': page === currentPage }">
                            <a class="page-link" href="#" @click.prevent="goToPage(page)" x-text="page"></a>
                        </li>
                    </template>
                    <li class="page-item" :class="{ 'disabled': currentPage === totalPages }">
                        <a class="page-link" href="#" @click.prevent="goToPage(currentPage + 1)">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
    </div> <!-- End Users Management Container -->

</div>




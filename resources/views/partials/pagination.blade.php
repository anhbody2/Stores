<!-- Sidebar Navigation -->
<form class="form_edit" method="POST" id="logout-form">
    @csrf

</form>
<button href="/logout" class="list-group-item list-group-item-action text-danger logout"
    onclick="confirmDelete({
                                                        url: '/logout',
                                                        formId: 'logout-form',
                                                        title: 'Log out?',
                                                        text: 'You are about to log out of your account.',
                                                        confirmText: 'Log out',
                                                    })">

    <i class="fas fa-sign-out-alt me-2"></i> Logout
</button>
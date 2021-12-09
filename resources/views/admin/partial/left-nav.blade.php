<div id="left-nav">
    <div class="menu-link">
        <a href="/dashboard">
            <div></div>
            Настройки</a>
    </div>
    <div class="menu-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : null }}">
        <a href="/admin/users">
        <div></div>
        Пользователи</a>
    </div>
    <div class="menu-link">
        <a href="/dashboard">
        <div></div>
        Сделки</a>
    </div>
    <div class="menu-link {{ request()->is('admin/documents') || request()->is('admin/documents/*') ? 'active' : null }}">
        <a href="/admin/documents">
        <div></div>
        Документы</a>
    </div>
</div>

<div id="top-nav">
    <div class="logo">
        <p>Admin</p>
    </div>
    <div class="links-group">
        <div><a href="/dashboard">О сервисе</a></div>
        <div><a href="/dashboard">Как пользоваться</a></div>
        <div><a href="/dashboard">Подбор недвижимости</a></div>
        <div><a href="/dashboard">Контакты</a></div>
    </div>
    <div class="info-group">
        @if(request()->is('admin/users'))
        <div>
            <a class="btn btn-dark" href="/admin/users/create">Добавить пользователя</a>
        </div>
        @endif
        @if(request()->is('admin/documents'))
        <div>
            <a class="btn btn-dark" href="/admin/documents/create">Добавить документ</a>
        </div>
        @endif
    </div>
</div>

<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Управление прайслистами</a>
        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse"
                aria-expanded="false"
                aria-label="Переключить навигацию">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => !isset($export)]) {{ !isset($export) ? 'aria-current=page' : '' }} href="/">Список прайслистов</a>
                </li>
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => isset($export)]) {{ isset($export) ? 'aria-current=page' : '' }} href="/export">Экспорт даннных</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

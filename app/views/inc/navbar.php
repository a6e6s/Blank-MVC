<nav class="navbar navbar-expand-lg navbar-dark bg-success mb-3">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT; ?>">الرئيسية</a>
                </li>
                <?php foreach ($data['pages'] as $page): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT . '/pages/show/' . $page->page_id; ?>"><?php echo $page->title; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>

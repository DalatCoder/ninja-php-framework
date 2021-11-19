{% extends layout.html.php %}

{% block title %}{{ $title }}{% endblock %}

{% block content %}
<h1>Home</h1>
<p>Welcome to the home page, list of colors:</p>
<ul>
    <?php foreach ($colors as $color): ?>
        <li><?= $color ?></li>
    <?php endforeach; ?>
</ul>
{% endblock %}

<?php
$currentPage = $_GET["page"] ?? "personal";
?>
<nav class="menu-bar">
    <a href="index.php?page=personal"
       class="<?= $currentPage === "personal" ? "active" : "" ?>">Personal</a>
    <a href="index.php?page=shared"
       class="<?= $currentPage === "shared" ? "active" : "" ?>">Shared</a>
</nav>
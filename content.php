
<?php
$page = $_GET["page"] ?? "personal";

if ($page != "shared") {
    $page = "personal";
}

$stmt = $conn->prepare("SELECT * FROM todos WHERE todo_type = ? ORDER BY id DESC");
$stmt->bind_param("s", $page);
$stmt->execute();
$todos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<main>
    <section class="todo-panel">
        <div class="panel-header">
            <h2><?= ucfirst($page) ?> Todos</h2>
            <span><?= count($todos) ?> task(s)</span>
        </div>

        <div class="todo-list">
            <?php if (empty($todos)): ?>
                <p class="empty">No todos yet. Create one using the form.</p>
            <?php endif; ?>

            <?php foreach ($todos as $todo): ?>
                <article class="todo-item">
                    <div class="todo-details">
                        <h3><?= $todo["title"] ?></h3>
                        <p><?= nl2br($todo["description"]) ?></p>

                        <?php if ($todo["due_date"]): ?>
                            <p class="meta">Date: <?= $todo["due_date"] ?></p>
                        <?php endif; ?>

                        <?php if ($todo["notification"]): ?>
                            <p class="meta">Notification: <?= $todo["notification"] ?></p>
                        <?php endif; ?>

                        <?php if ($todo["image"]): ?>
                            <p><a href="uploads/<?= rawurlencode($todo["image"]) ?>" target="_blank">View image</a></p>
                        <?php endif; ?>
                    </div>

                    <div class="todo-actions">
                        <span class="status <?= $todo["completed"] ? "completed" : "pending" ?>">
                            <?= $todo["completed"] ? "Completed" : "Pending" ?>
                        </span>

                        <form action="update.php" method="post">
                            <input type="hidden" name="id" value="<?= $todo["id"] ?>">
                            <input type="hidden" name="page" value="<?= $page ?>">
                            <input type="hidden" name="completed" value="<?= $todo["completed"] ? 0 : 1 ?>">
                            <button><?= $todo["completed"] ? "Mark Pending" : "Complete" ?></button>
                        </form>

                        <details class="edit-box">
                            <summary>Edit</summary>
                            <form action="update.php" method="post" class="edit-form">
                                <input type="hidden" name="id" value="<?= $todo["id"] ?>">
                                <input type="hidden" name="page" value="<?= $page ?>">

                                <label>Title
                                    <input name="title" value="<?= $todo["title"] ?>" required>
                                </label>

                                <label>Description
                                    <textarea name="description" required><?= $todo["description"] ?></textarea>
                                </label>

                                <label>Date
                                    <input type="date" name="due_date" value="<?= $todo["due_date"] ?>">
                                </label>

                                <label>Notification time
                                    <input type="datetime-local" name="notification" value="<?= $todo["notification"] ?>">
                                </label>

                                <button>Save Changes</button>
                            </form>
                        </details>

                        <form action="delete.php" method="post" onsubmit="return confirm('Delete this todo?')">
                            <input type="hidden" name="id" value="<?= $todo["id"] ?>">
                            <input type="hidden" name="page" value="<?= $page ?>">
                            <button class="delete-button">Delete</button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <aside class="detail-panel">
        <form class="new-todo" action="create.php" method="post" enctype="multipart/form-data">
            <h3>Create New Todo</h3>
            <input type="hidden" name="page" value="<?= $page ?>">

            <label for="title">Title</label>
            <input id="title" name="title" required>

            <label for="description">Description</label>
            <textarea id="description" name="description" required></textarea>

            <label for="due_date">Date</label>
            <input type="date" id="due_date" name="due_date">

            <label for="image">Image</label>
            <input type="file" id="image" name="image" accept="image/*">

            <label for="notification">Notification Time</label>
            <input type="datetime-local" id="notification" name="notification">

            <button>Create Todo</button>
        </form>
    </aside>
</main>

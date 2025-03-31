<!DOCTYPE>
<html>
<head>
        <title>My List</title>
</head>
<body>
    <h1>My List</h1>
    <ul>
        <?php
            foreach ($pokemons as $item) {
                echo '<li>'; 
                echo '<a href="?route=pokemon&name=' . $item['name'] . '">' . $item['name'] . '</a>';
                echo ' <form method="post">
                    <input type="hidden" name="id" value="' . $item['id'] . '">
                    <input type="hidden" name="action" value="delete">
                    <button type="submit">Delete</button>
                </form>';
                echo '</li>';
            }
        ?>
        </ul>
        <form method="post">
            <input type="text" name="name" placeholder="Name">
            <input type="hidden" name="action" value="add">
            <button type="submit">Add</button>
        </form>
</body>
</html>

<?php
session_start();
define('BASE_PATH', dirname(__DIR__));

require_once "./assets/php/functions.php";


if (!isset($_COOKIE["token"])) {
    header("Location: ./index.html");
    exit();
} else {
    if(!is_admin($_COOKIE["token"])) {
        header("Location: ./user.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>AcVis - Admin</title>
    <link rel="stylesheet" href="assets/css/nav-style.css">
    <link rel="stylesheet" href="assets/css/admin-style.css">
    <script defer src="assets/js/admin-edit.js"></script>
</head>
<body>
    <nav>
        <ul class="topnav">
            <li><a href="Main.html">Home</a></li>
            <li><a href="login.php" class="active">Admin</a></li>
        </ul>
    </nav>
    <main class="container">
        <div class="tab-bar-menu">
            <button class="tab-bar-link" onclick="openProp(event, 'menu-user')" id="defaultOpen">Users</button>
            <button class="tab-bar-link" onclick="openProp(event, 'menu-actor')">Actors</button>
            <button class="tab-bar-link" onclick="openProp(event, 'menu-oscar')">SAG</button>
        </div>
        <div class="tab-bar-content" id="menu-user">
            <table class="user-table" id="general-user-table">
                <tr>
                    <th class="id-content">ID</th>
                    <th class="name-content">First Name</th>
                    <th class="name-content">Last Name</th>
                    <th class="name-content">Email</th>
                    <th class="action-content" colspan="2">Actions</th>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <div class="data-box">
                <div class="component centered">
                    <button id="button-user-table-previous" class="page-index previous">Previous</button>
                    <input placeholder="Page" id="user-table-page-index" type="number" value="1" class="favorite-page">
                    <button id="button-user-table-next" class="page-index next">Next</button>
                </div>
            </div>
        </div>
        <div class="tab-bar-content" id="menu-actor">
            <table class="user-table" id="general-actor-table">
                <tr>
                    <th class="id-content">ID</th>
                    <!--
                        <th class="name-content">First Name</th>
                        <th class="name-content">Last Name</th>
                        <th class="name-content">Date of Birth</th>
                        <th class="action-content" colspan="2">Actions</th>
                    -->
                    <th class="name-actor-content">Actor Name</th>
                    <th class="action-content" colspan="2">Actions</th>
                </tr>
            </table>
            <div class="data-box">
                <div class="component centered">
                    <button id="button-actor-table-previous" class="page-index previous">Previous</button>
                    <input placeholder="Page" id="actor-table-page-index" type="number" value="1" class="favorite-page">
                    <button id="button-actor-table-next" class="page-index next">Next</button>
                </div>
            </div>
            <!--
            <div class="data-box">
                <div class="component centered">
                    <button id="button-actor-table-import" class="triple">Import</button>
                    <button id="button-actor-table-export" class="triple">Export</button>
                    <button id="button-actor-table-delete" class="triple delete">Delete</button>
                </div>
            </div>
            -->
            <hr>
            <div class="create-entry">
                <div class="data-box">
                    <h3>Create an Actor Entry</h3>
                    <div class="component" id="add-entry-actor-result">
                    </div>
                    <div class="component">
                        <label>Actor's Name</label>
                        <input placeholder="Actor's Name" id="new_actor-name" value="" type="text">
                    </div>
                    <div class="component">
                        <button name="save" id="button-actor-save">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-bar-content" id="menu-oscar">
            <table class="oscar-table" id="general-sag-table">
                <tr>
                    <th class="id-content">Year</th>
                    <th class="name-content">Category</th>
                    <th class="name-content">Full Name</th>
                    <th class="name-content">Show</th>
                    <th class="name-content small">Won</th>
                    <th class="action-content small">Actions</th>
                </tr>
            </table>
            <div class="data-box">
                <div class="component centered">
                    <button id="button-oscar-table-previous" class="page-index previous">Previous</button>
                    <input placeholder="Page" id="oscar-table-page-index" type="number" value="1" class="favorite-page">
                    <button id="button-oscar-table-next" class="page-index next">Next</button>
                </div>
            </div>
            <hr>
            <div class="create-entry">
                <form class="data-box">
                    <div class="component">
                        <h3>Import/Export/Delete data</h3>
                    </div>
                    <div class="component">
                        <label>Year Column Number</label>
                        <input placeholder="Year" id="sag-year-import-index" value="1" type="number">
                    </div>
                    <div class="component">
                        <label>Category Column Number</label>
                        <input placeholder="Category" id="sag-category-import-index" value="2" type="number">
                    </div>
                    <div class="component">
                        <label>Actor's Full Name Column Number</label>
                        <input placeholder="Actor" id="sag-actor-import-index" value="3" type="number">
                    </div>
                    <div class="component">
                        <label>Show Title Column Number</label>
                        <input placeholder="Show" id="sag-show-import-index" value="4" type="number">
                    </div>
                    <div class="component">
                        <label>Nominalization Result Column Number</label>
                        <input placeholder="Nom" id="sag-nominalization-import-index" value="5" type="number">
                    </div>
                    <div class="component">
                        <label>Load File</label>
                        <input id="sag-file-import-index" type="file">
                    </div>
                    <div class="component" id="progress-bar" style="display: none">
                        <div class="progress-bar">
                            <div id="progressing-bar" class="progressing-bar"></div>
                            <div id="progress-bar-text" class="progress-bar-text">Uploading...</div>
                        </div>
                    </div>
                    <div class="component centered">
                        <button id="button-oscar-table-import" class="triple">Import</button>
                        <button id="button-oscar-table-export" class="triple">Export</button>
                        <button id="button-oscar-table-delete" class="triple delete">Delete</button>
                    </div>
                </form>
            </div>
            <hr>
            <div class="create-entry">
                <form class="data-box">
                    <h3>Create an SAG Entry</h3>
                    <div class="component" id="add-entry-sag-result">
                    </div>
                    <div class="component">
                        <label>Year</label>
                        <input placeholder="Year" id="entry-sag-year" value="2000" type="number">
                    </div>
                    <div class="component">
                        <label>Category</label>
                        <select id="entry-sag-category" name="Category">
                        </select>
                    </div>
                    <div class="component">
                        <label>Actor</label>
                        <select id="entry-sag-actor" name="Actor">
                        </select>
                    </div>
                    <div class="component">
                        <label>Show</label>
                        <select id="entry-sag-show" name="Show">
                        </select>
                    </div>
                    <div class="component">
                        <label>Winning Nominalization</label>
                        <input id="entry-sag-win" type="checkbox" class="form-checkbox">
                    </div>
                    <div class="component">
                        <button name="save" id="button-entry-sag-save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
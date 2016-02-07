<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./css/greenbuttons.css">
        <title>Green Buttons!</title>
    </head>
    <?php
    $config = include(__DIR__ . '/config.php');
    $data = getRedirects($config);

    # Gets all redirect links from the mysql database
    function getRedirects($config) {
        $database = mysqli_connect($config['mysql-host'], $config['mysql-username'], $config['mysql-password'], $config['mysql-database']);
        $result = mysqli_query($database, "SELECT * FROM `redirects`");
        $dat = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $dat[] = $row['url'];
        }
        $files = getInternalFiles($config);
        $url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}files/";
        for ($i = 0, $c = count($files); $i < ($c - 2); $i++) {
            $dat[] = $url . $files[$i];
        }
        return $dat;
    }

    # Get a random link
    function getLink($data) {
        $r = rand("0", (count($data) - 1));
        return $data[$r];
    }

    # Get files from 'file-dir'
    function getInternalFiles($config) {
        $files = scandir($config['file-dir'], 1);
        return $files;
    }
    ?>
    <body>
        <?php
        for ($i = 1; $i < $config['button-amount']; $i++) {
            ?>
            <a href="<?php echo getLink($data); ?>" target="_blank"><div class="btn btn-lg btn-success" style="margin: 10px;">Stora gröna knappar!</div></a>
            <?php
        }
        ?>
    </body>
</html>

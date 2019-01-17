<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <title>Compute size of link - light</title>
</head>
<body>
<div class="container">
    <div class="jumbotron">
        <h1 class="display-4">Compute size of links</h1>
        <hr class="my-4">

        <form action="" method="post">
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Enter up to 20 URLs</label>
                <textarea name="list" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary mb-2" name="submit">Submit</button>
        </form>

        <div class="result">

            <?php
            if (isset($_POST['submit'])) {
                $urlsList = $_POST['list'];
                $urls = explode("\n", str_replace("\r", "", $urlsList));
                if (count($urls) > 20) {
                    echo "<div class=\"alert alert-warning\" role=\"alert\">
                              Enter up to 20 URLs!
                            </div>";
                    return;
                }
            }
            function getRemoteFileSize($url)
            {
                $head = array_change_key_case(get_headers($url, 1));
                return $head['content-length'];
            }

            function formatBytes($clen)
            {
                $size = $clen;
                switch ($clen) {
                    case $clen < 1024                :
                        $size = $clen . ' B';
                        break;
                    case $clen < 1048576            :
                        $size = round($clen / 1024, 2) . ' KB';
                        break;
                    case $clen < 1073741824            :
                        $size = round($clen / 1048576, 2) . ' MB';
                        break;
                    case $clen < 1099511627776        :
                        $size = round($clen / 1073741824, 2) . ' GB';
                        break;
                }
                return $size;
            }

            $sum = 0;
            $resultLinks = array();

            foreach ($urls as $url) {
                $urlSize = getRemoteFileSize($url);
                $resultLinks[$url] = $urlSize;
                $sum += isset($urlSize) ? $urlSize : 0;
            }
            ?>

            <?php if (count($resultLinks) > 0): ?>
                <hr class="my-4">
                <div><span class="font-weight-bold">Result</span> <span>[<?php echo formatBytes($sum); ?>]</span></div>

                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Link</th>
                        <th scope="col">Size</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $index = 1; ?>
                    <?php foreach ($resultLinks as $link => $size): ?>
                        <tr class="<?= isset($size) ? "table-success" : "table-danger" ?>">
                            <th scope="row"><?php echo $index++ ?></th>
                            <td><a href="<?php echo $link; ?>"><?php echo $link; ?></a></td>
                            <td><?= isset($size) ? formatBytes($size) : "This link not support" ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>


        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
</body>
</html>
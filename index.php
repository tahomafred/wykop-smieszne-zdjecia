<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
            </button>
            <a class="navbar-brand" href="#">Wykop Śmieszne Zdjęcia</a>
        </div>
        <form method="post">
            <?php /*echo ('<input type="submit" value="' . $pageC . '" placeholder="Następna strona" class="btn btn-default">'); */?>
        </form>
        <form class="navbar-form navbar-right">
            <div class="form-group">
                <form method="GET">
                    <input type="text" class="form-control" name="tag" placeholder="Wpisz Nazwę #tagu">
                    <input type="submit" class="btn btn-default">
                </form>
            </div>

        </form>

    </div>
</nav>
<div class="container">
    <?php
    function clean($string)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    function loadPage($tag, $pageCount, $imgCount)
    {
        $wapi = new libs_Wapi('RhlrYpS1MM', 'MrktNTguBl');
        $result = $wapi->doRequest('search/entries/page/' . $pageCount, array('q' => $tag));
        if ($wapi->isValid()) {
            foreach ($result as $r) {
                $r = $r['embed'];
                if (!is_null($r) && $r['type'] == 'image') {
                    print "<a href='" . $r['url'] . "'><img class='block img.responsive img-rounded' src='" . $r['preview'] . "'></a>";
                    $imgCount++;
                }
            }

        } else {
            echo $wapi->getError();
        };
    };



    $pageC = 1;
    $imgCount = 1;
    @$tag = '#' . clean($_GET['tag']);
    $maxPage = 10;
    include('libs/Wapi.php');
    if ($tag != NULL) {

        loadPage($tag, $pageC, $imgCount);
        var_dump ($pageC);
        $pageC++;
        loadPage($tag, $pageC, $imgCount);
        var_dump ($pageC);

    };
    ?>
</div>
</body>
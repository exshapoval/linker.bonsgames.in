<?php
ini_set('display_errors', 0);
include_once 'config.php';
include_once 'functions.php';
$linksAll = "SELECT * FROM links";
$resAll = $conn->query($linksAll);
if (isset ($_GET['perPage']) ) $perPage = $_GET['perPage'];
$number_of_page = ceil ($resAll->num_rows / $perPage);

if (!isset ($_GET['page']) ) $page = 0;
else $page = $_GET['page'];

$page_first_result = $page * $perPage;

$pagenav = create_page_nav($page, $resAll->num_rows, 'links.php', $perPage);

$sort = ((isset($_GET['sort']) && $_GET['sort'] != '') ? $_GET['sort'] : 'linkid');
$by = ((isset($_GET['dir']) && $_GET['dir'] != '') ? $_GET['dir'] : 'ASC');

$links = "SELECT * FROM links " . " ORDER BY " . $sort . " " . $by . " LIMIT ".$page_first_result.", " . $perPage;

$res = $conn->query($links);

include_once 'header.php';
?>
    <div class="off-canvas-wrapper">
        <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
            <?php include 'menu.php'; ?>

            <div class="off-canvas-content" data-off-canvas-content>
                <div class="callout primary">
                    <div class="row column">
                        <h1>Список ссылок</h1>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <form method="get">
                        <?= $pagenav; ?>
                        выводить по
                        <select name="perPage" onchange="this.form.submit()" >
                            <option value="20" <?= ($perPage == 20 ? 'selected' : ''); ?>>20</option>
                            <option value="50" <?= ($perPage == 50 ? 'selected' : ''); ?>>50</option>
                            <option value="100" <?= ($perPage == 100 ? 'selected' : ''); ?>>100</option>
                            <option value="500" <?= ($perPage == 500 ? 'selected' : ''); ?>>500</option>
                            <option value="1000" <?= ($perPage == 1000 ? 'selected' : ''); ?>>1000</option>
                        </select>
                    </form>
                    <table style="width: 100%">
                        <tr>
                            <td><a href="<?= getSort('linkid') ?>">ID <?= (($_GET['dir'] == 'desc' && $_GET['sort'] == 'linkid') ? '&#8595;' : '') . (($_GET['dir'] == 'asc' && $_GET['sort'] == 'linkid') ? '&#8593;' : ''); ?></a></td>
                            <td style="width: 50%"><a href="<?= getSort('oldlink') ?>">Old link <?= (($_GET['dir'] == 'desc' && $_GET['sort'] == 'oldlink') ? '&#8595;' : '') . (($_GET['dir'] == 'asc' && $_GET['sort'] == 'oldlink') ? '&#8593;' : ''); ?></a></td>
                            <td><a href="<?= getSort('newlink') ?>">New Link <?= (($_GET['dir'] == 'desc' && $_GET['sort'] == 'newlink') ? '&#8595;' : '') . (($_GET['dir'] == 'asc' && $_GET['sort'] == 'newlink') ? '&#8593;' : ''); ?></a></td>
                            <td><a href="<?= getSort('created') ?>">Created <?= (($_GET['dir'] == 'desc' && $_GET['sort'] == 'created') ? '&#8595;' : '') . (($_GET['dir'] == 'asc' && $_GET['sort'] == 'created') ? '&#8593;' : ''); ?></a></td>
                            <td><a href="<?= getSort('edited') ?>">Edited <?= (($_GET['dir'] == 'desc' && $_GET['sort'] == 'edited') ? '&#8595;' : '') . (($_GET['dir'] == 'asc' && $_GET['sort'] == 'edited') ? '&#8593;' : ''); ?></a></td>
                            <td></td>
                        </tr>
                        <?php
                            foreach ($res as $value) {
                                echo '<tr>';
                                echo '<td>';
                                echo $value['linkid'];
                                echo '</td>';
                                echo '<td>';
                                echo $value['oldlink'];
                                echo '</td>';
                                echo '<td>';
                                echo $value['newlink'];
                                echo '</td>';
                                echo '<td>';
                                if ($value['created'] != '' && $value['created'] != null)
                                    echo date('d.m.Y H:i',strtotime($value['created']));
                                echo '</td>';
                                echo '<td>';
                                if ($value['edited'] != '' && $value['edited'] != null)
                                    echo date('d.m.Y H:i',strtotime($value['edited']));
                                echo '</td>';
                                echo '<td>';
                                echo '<a href="index.php?id='.$value['linkid'].'" target="_blank">Редактировать</a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                        ?>
                    </table>
                    <form method="get">
                        <?= $pagenav; ?>
                        выводить по
                        <select name="perPage" onchange="this.form.submit()" >
                            <option value="20" <?= ($perPage == 20 ? 'selected' : ''); ?>>20</option>
                            <option value="50" <?= ($perPage == 50 ? 'selected' : ''); ?>>50</option>
                            <option value="100" <?= ($perPage == 100 ? 'selected' : ''); ?>>100</option>
                            <option value="500" <?= ($perPage == 500 ? 'selected' : ''); ?>>500</option>
                            <option value="1000" <?= ($perPage == 1000 ? 'selected' : ''); ?>>1000</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php include 'footer.php';?>
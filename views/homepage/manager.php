<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once('./views/parts/__head.php') ?>
    <title>Quản lý HB</title>
    <style>
        .top-nav {
            padding: 10px 20px;
        }

        .control {
            list-style: none;
            padding: 40px 20px;
            margin: 0;
        }

        .control li a {
            padding: 10px 0;
            display: block;
        }
    </style>
</head>

<body>
    <div class="app">
        <div class="row no-gutter top-nav" style="background-color: #999;">
            <div class="col-6">Xin chào <?php echo $name ?></div>
            <div class="col-6 text-right">
                <a href="index.php?action=posts" target="_blank" class="btn btn-sm btn-light">Trang chủ</a>
                <a href="index.php?controller=admin&action=logout" class="btn btn-sm btn-dark">Đăng xuất</a>
            </div>
        </div>
        <div class="row no-gutter">
            <div class="col-2">
                <ul class="control">
                    <li>
                        <a href="#" class="text-primary">Quản lý bài đăng</a>
                    </li>
                    <li>
                        <a href="#" title="Chức năng đang xây dựng" class="text-reset">Quản lý danh mục</a>
                    </li>
                    <li>
                        <a href="index.php?controller=admin&action=newPost" class="text-reset">Thêm bài đăng</a>
                    </li>
                </ul>
            </div>
            <div class="col-10" style="background-color: #f5f5f5; border-left: solid 1px #000; height: 100%;">
                <div class="content">
                    <div class="search-element my-3">
                        <form class="form-inline">
                            <div class="form-group flex-grow-1">
                                <input type="text" class="form-control w-75" id="search-post" placeholder="Tìm kiếm ...">
                            </div>
                            <div class="form-group pr-3">
                                <div class="form-check">
                                    <input type="checkbox" name="option" id="hide-row" class="form-check-input" value="off">
                                    <label for="hide-row" class="form-check-label">Ẩn bài viết đã xoá</label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <table class="table">
                        <thead class='thead-dark'>
                            <tr>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Người đăng</th>
                                <th scope="col">Tiêu đề</th>
                                <th scope="col">Ngày đăng</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($posts) > 0) : ?>
                                <?php foreach ($posts as $post) : ?>
                                    <tr class='post-row' data-del="<?php echo $post['deleted_at'] ?? 'visible' ?>">
                                        <td><?php echo $post['category'] ?></td>
                                        <td><?php echo $post['user'] ?></td>
                                        <td class='post-title'><?php echo html_entity_decode(html_entity_decode($post['title'])) ?></td>
                                        <td class='post-date'><?php echo date('d-m-Y', strtotime($post['date'])) ?></td>
                                        <td>
                                            <?php if (isset($post['deleted_at'])) : ?>
                                                <span class="btn btn-sm btn-secondary">Đã xoá</span>
                                            <?php else : ?>
                                                <a href="index.php?action=post&id=<?php echo $post['id'] ?>" target="_blank" class="btn btn-sm btn-outline-info">Xem</a>
                                                <a href="index.php?controller=admin&action=edit&post_id=<?php echo $post['id'] ?>" class="btn btn-sm btn-outline-warning">Sửa</a>
                                                <a href="index.php?controller=admin&action=delete&post_id=<?php echo $post['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn muốn xoá bài viết này?')">Xoá</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php require_once('./views/parts/__script.php') ?>
    <script>
        $(function() {
            $('form').submit(function(e) {
                e.preventDefault();
            });

            $('td.post-title').each(function (index, element) {
                // element == this
                $(this).html(
                    "<p>" + $(this).text() + "</p>"
                )
            });

            // Sort element
            $("input#search-post").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                console.log(value);
                $("tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            })

            $('input#hide-row').change(function(e) {
                e.preventDefault();
                if ($(this).attr('value') == 'off') {
                    $(this).attr('value', 'on');
                    $("tbody tr").filter(function() {
                        $(this).toggle($(this).attr('data-del') == 'visible')
                    });
                } else {
                    $(this).attr('value', 'off');
                    $("tbody tr").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf("") > -1)
                    });
                }
            });
        })
    </script>
</body>

</html>
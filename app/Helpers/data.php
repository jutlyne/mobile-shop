<?php
function data_tree($data, $parent_id = 0, $level = 0)
{
    $result = [];
    foreach ($data as $key => $item) {
        if ($item['cat_product_parent'] == $parent_id) {
            $item['level'] = $level;
            $result[] = $item;
            unset($data[$key]);
            $child = data_tree($data, $item['cat_product_id'], $level + 1);
            $result = array_merge($result, $child);
        }
    }
    return $result;
}

function showCategories($categories, $parent_id = 0)
{
    // BƯỚC 1: LẤY DANH SÁCH CATE CON
    $cate_child = array();
    foreach ($categories as $key => $item) {
        if ($item['cat_product_parent'] == $parent_id) {
            $cate_child[] = $item;
            unset($categories[$key]);
        }
    }
    // BƯỚC 2: HIỂN THỊ DANH SÁCH CHUYÊN MỤC CON NẾU CÓ
    if ($cate_child) {
        echo "<ul class='sub-menu'>";
        foreach ($cate_child as $key => $item) {
            echo "<li>";
            echo "<a href = 'san-pham/{$item->cat_product_slug}-{$item->cat_product_id}'>";
            echo $item->cat_product_name;
            echo "</a>";
            showCategories($categories, $item->cat_product_id);
            echo "</li>";
        }
        echo "</ul>";
    }
}

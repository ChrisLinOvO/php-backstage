<?php
//建立種類列表
function buildTree($pdo, $parentId = 0){
    $sql = "SELECT `coursesCategoryId`, `coursesCategoryName`, `coursesCategoryParentId`
            FROM `coursescategory` 
            WHERE `coursesCategoryParentId` = ?";
    $stmt = $pdo->prepare($sql);
    $arrParam = [$parentId];
    $stmt->execute($arrParam);
    if($stmt->rowCount() > 0) {
        echo "<ul>";
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for($i = 0; $i < count($arr); $i++) {
            echo "<li class='listLi'>";
            echo "<a class=listA href='./coursesPage.php?coursesCategoryId={$arr[$i]['coursesCategoryId']}'>{$arr[$i]['coursesCategoryName']}</a>";
            buildTree($pdo, $arr[$i]['coursesCategoryId']);
            echo "</li>";
        }
        echo "</ul>";
    }
}
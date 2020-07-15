<?php
//搭配全域變數，遞迴取得上下階層的 id 字串集合
function getRecursiveCategoryIds($pdo, $categoryId){
    global $strCategoryIds;
    $sql = "SELECT `coursesCategoryId`
            FROM `coursescategory` 
            WHERE `coursesCategoryParentId` = ?";
    $stmt = $pdo->prepare($sql);
    $arrParam = [$categoryId];
    $stmt->execute($arrParam);
    if($stmt->rowCount() > 0) {
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for($i = 0; $i < count($arr); $i++) {
            $strCategoryIds.= ",".$arr[$i]['coursesCategoryId'];
            getRecursiveCategoryIds($pdo, $arr[$i]['coursesCategoryId']);
        }
    }
}
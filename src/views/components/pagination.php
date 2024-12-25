<?php
//Tao/Xu ly Phân Trang
function paging(
  $db,
  $sql,
  $limit=20,
)
{
  global $db;

  $current_page = 0;
  $newQueryStr = "";

  if($_GET['page']) {
    $current_page = $_GET['page'];
  }
  else {
    $queryStr="";
    foreach($_GET as $key => $value) {
      $queryStr .= "$key=$value&";
    }
    header("location: ?{$queryStr}page=1");
    exit();
  }

  foreach($_GET as $key => $value) {
    if($key == 'page') continue;
    $newQueryStr .= "$key=$value&";
  }

  $total_records = $db->rows_count($db->query($sql));
  $total_page = ceil($total_records / $limit);
  $total_page = ($total_page == 0 ? 1 : $total_page);

  if ($current_page > $total_page) {
    $current_page = $total_page;
  } else if ($current_page < 1) {
    $current_page = 1;
  }

  $start = ($current_page - 1) * $limit;
  $newSQL = "$sql LIMIT $start, $limit";

  $html = '';

  if ($current_page > 1 && $total_page > 1) {
    $html .= "<a class='pagination__btn btn flex-center' href='?{$newQueryStr}page=" . ($current_page - 1) . "'>Prev</a>";
  }

  $html.= ($current_page == 1)
  ? "<span class='pagination__btn btn btn-primary flex-center'>1</span>"
  : "<a class='pagination__btn btn flex-center' href='?{$newQueryStr}page=1'>1</a>" ;
  
  if($total_page > 1){
    if($current_page > 3){
      $html .= "<span class='pagination__btn btn flex-center'>...</span>";
    }

    if($current_page - 1 > 1){
      $html .= "<a class='pagination__btn btn flex-center' href='?{$newQueryStr}page=" . $current_page-1 . "'>" . $current_page-1 . "</a>";
    }
    if($current_page !=1 && $current_page != $total_page){
      $html .= "<span class='pagination__btn btn btn-primary flex-center'>".$current_page."</span>";
    }
    if($current_page + 1 < $total_page){
      $html .= "<a class='pagination__btn btn flex-center' href='?{$newQueryStr}page=" . $current_page+1 . "'>" . $current_page+1 . "</a>";
    }

    if($current_page <= $total_page - 3){
      $html .= "<span class='pagination__btn btn flex-center'>...</span>";
    }

    $html.= ($current_page == $total_page)
    ? "<span class='pagination__btn btn btn-primary flex-center'>" . $total_page . "</span>"
    : "<a class='pagination__btn btn flex-center' href='?{$newQueryStr}page=" . $total_page . "'>" . $total_page . "</a>";
  }

  if ($current_page < $total_page && $total_page > 1) {
    $html .= "<a class='pagination__btn btn flex-center' href='?{$newQueryStr}page=" . ($current_page + 1) . "'>Next</a>";
  }

  return [
    'sql' => $newSQL,
    'html' => "
      <div class='flex-center' id='pagination'>
        $html
      </div>
    "
  ];
}

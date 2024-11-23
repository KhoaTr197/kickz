<?php
function paging(
  $db,
  $sql,
  $current_page=1,
  $limit=20,
)
{
  global $db;

  $newQueryStr = str_replace("page=$current_page", "", $_SERVER['QUERY_STRING']);

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

  for ($i = 1; $i <= $total_page; $i++) {
    if ($i == $current_page) {
      $html .= "<span class='pagination__btn btn btn-primary flex-center'>" . $i . "</span>";
    } else {
      $html .= "<a class='pagination__btn btn flex-center' href='?{$newQueryStr}page=" . $i . "'>" . $i . "</a>";
    }
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
